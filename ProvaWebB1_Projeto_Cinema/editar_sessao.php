<?php
include('config/conexao.php');

$erros = array('Sala' => '' , 'Id_filme' => '','Dia'=> '','Hora' => '' );
$Sala = $Id_filme = $Dia = $Hora = '';
$Sessao_id = 0;

function validarHora($str){
    return strlen($str) == 5
           && $str[2] == ':'
           && $str[0] >= '0' && $str[0] <= '2'
           && $str[1] >= '0' && $str[1] <= ($str[0]=='2'?'3':'9')
           && $str[3] >= '0' && $str[3] <= '5'
           && $str[4] >= '0' && $str[4] <= '9';
     }
 
 
     
function validarDia($d){
         //Se ocorrer erro depois é só returnar o conteudo de dia real, mas ai datas erras como 31 de fevereiro vão passar
         $diareal= (strlen($d) == 5) && ($d[2] == '-' || $d[2] == '/') &&
                (intval($d[0].$d[1]) <=12 && intval($d[0].$d[1]) > 0 ) && (intval($d[3].$d[4]) <= 31 && intval($d[3].$d[4])>0);
 
         if($diareal){
            switch(intval($d[0].$d[1])){
             case 2:
                 return intval($d[3].$d[4]) <= 28;
             
             case 1:
             case 3:
             case 5:
             case 7:
             case 8:
             case 10:
             case 12:   
                 return intval($d[3].$d[4]) <= 31;
              
             case 4:
             case 6:
             case 9:
             case 11: 
                 return intval($d[3].$d[4]) <= 30;
                 
            }
 
         } else{
             return false;
         }      
         //return $diareal;       
     }
//Verificando se o parâmetro Nome foi enviado pelo get_browser
if(isset($_POST['editar'])){
    //Limpa os dados de sql injection
    
    $Id_sessao = mysqli_real_escape_string($conn,$_POST['Id_sessao']);
    $Sessao_id = $Id_sessao;
    //SELECT s.Id_sessao AS Codigo, s.Id_sala AS Sala, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora FROM sessao s, filme f WHERE s.Id_filme = f.Id and s.Id_sessao = $Id_sessao;

    //Monta a query
	$sql = "SELECT * FROM sessao WHERE Id_sessao = $Id_sessao;";
    
    //Executa a query e guarda em $result
	$result = mysqli_query($conn,$sql);
    //echo $result;

    //Busca o resultado (uma linha) em forma de vetor
	$sessao = mysqli_fetch_assoc($result);

    $Sala = $sessao['Id_sala'];
    $Id_filme = $sessao['Id_filme'];
    $Dia = $sessao['Dia'];
    $Hora = $sessao['Hora'];


    
    
    mysqli_free_result($result);
    mysqli_close($conn);
    
}else{
    //echo 'Erro';
}

//Alterar sessao do banco de dados
if(isset($_POST['salvar'])){
    //Verificando sala
   if(empty($_POST['Sala'])){
    //echo 'Sala obrigatória';
    $erros['Sala'] = 'Sala obrigatória';
    }else{
     
     if(is_numeric($_POST['Sala'])){
        //echo 'Numerico';
        $sa = mysqli_real_escape_string($conn,$_POST['Sala']);
        $salasql = "SELECT * FROM sala WHERE Numero = $sa;"; 
        $res_sala = mysqli_query($conn,$salasql);        
        $salaTeste = mysqli_fetch_assoc($res_sala);
        //echo $salaTeste;
         if($salaTeste){
             //Há sala com PK com o valor de Id
             $Sala = $_POST['Sala'];
         }else{
             $erros['Sala'] = 'Digite sala válida';
             //echo 'Não há sala com esse id';
         } 
         mysqli_free_result($res_sala);
     }else{
         //echo 'Sala não numerica';
     }
    }

    //Verificando hora
    if(empty($_POST['Hora'])){
        //echo 'Hora obrigatória';
        $erros['Hora'] = 'Hora obrigatória';
    }else{
     //echo $_POST['Hora'];   
     $horario = mysqli_real_escape_string($conn,$_POST['Hora']); 
      
     
     //$horario = date('h:i');
     //var_dump($horario instanceof DateTime);
     
     if(validarHora(strval($horario))){
         //Hora está certa
         $Hora = $horario;
         //echo 'Hora certa';
     }else{
         $erros['Hora'] = 'Hora errada';
         //echo 'Hora errada';
     }
 
    }
 
    //Validando dia
    if(empty($_POST['Dia'])){
      //echo 'Dia obrigatório';
      $erros['Dia'] = 'Dia obrigatório';
    }else{
        $dd = mysqli_real_escape_string($conn,$_POST['Dia']);
 
        if(validarDia(strval($dd))){
            $Dia = $dd;
            //echo 'Dia certo';
        } else{
            $erros['Dia'] = 'Dia errado';
        }
    }

    //Verificando id_filme
    if(empty($_POST['Id_filme'])){
        //echo 'Código do filme obrigatória';
        $erros['Id_filme'] = 'Código do filme obrigatório';
    }else{
        
        if(is_numeric($_POST['Id_filme'])){
        //echo 'Numerico';
        $idfi = mysqli_real_escape_string($conn,$_POST['Id_filme']);
        $idfisql = "SELECT * FROM filme WHERE Id = $idfi AND Status_filme = 'Em cartaz';"; 
        $res_filme = mysqli_query($conn,$idfisql);        
        $idfiTeste = mysqli_fetch_assoc($res_filme);
        //echo $salaTeste;
            if($idfiTeste){
                //Há sala com PK com o valor de Id
                $Id_filme = $_POST['Id_filme'];
            }else{
                $erros['Id_filme'] = 'Digite código de filme válido';
                //echo 'Filme invalido';
            } 
            mysqli_free_result($res_filme);
        }else{
            //echo 'Código de filme não numerica';
            $erros['Id_filme'] = 'Digite código numérico';
        }
    }

    if(array_filter($erros)){
        //echo 'Erro no formulário <br/>';
    }else{
        $Id_sessao = mysqli_real_escape_string($conn,$_POST['Id_sessao']);
        $Sala = mysqli_real_escape_string($conn,$_POST['Sala']);
        $Id_filme = mysqli_real_escape_string($conn,$_POST['Id_filme']);
        $Dia = mysqli_real_escape_string($conn,$_POST['Dia']);
        $data = strval(date('Y')).'-'.strval($Dia);
        $Hora = mysqli_real_escape_string($conn,$_POST['Hora']);

        //Criando a Query
        $sql = "UPDATE sessao SET Id_sala = $Sala, Id_filme = $Id_filme, Dia = '$data', Hora = '$Hora' WHERE Id_sessao = $Id_sessao;";
          
        //Salva no banco de dados
        if (mysqli_query($conn, $sql)){
            //Sucesso
            header('Location: sessao_adm.php?Id_sessao='.$Id_sessao); 
        } else{
            //echo 'query error'.mysqli_error($conn);
        }

    }

 
 }

 if(isset($_POST['cancelar'])){
    $Id_sessao = mysqli_real_escape_string($conn,$_POST['Id_sessao']);
    header('Location: sessao_adm.php?Id_sessao='.$Id_sessao); 
 }

 
 
 

?>

<!DOCTYPE html>

<?php include('templates/header.php'); ?>
<?php //echo $Id_sessao?>
<section class="container grey-text">
		<h4 class="center blue-text">Editar</h4>
        <form class="white" action="editar_sessao.php" method="POST" style="padding: 20px;">
        <input type="hidden" name="Id_sessao" value="<?php echo $Id ?>">
        <label>Sala</label>
		<input type="text" name="Sala" value="<?php echo $Sala?>">
		<div class="red-text"><?php echo $erros['Sala'].'<br/>'?> </div>

        <label>Id_filme</label>
		<input type="text" name="Id_filme" value="<?php echo $Id_filme?>">
		<div class="red-text"><?php echo $erros['Id_filme'].'<br/>'?> </div>

		<label>Dia (mes-dia)</label>
		<input type="text" name="Dia" value="<?php echo $Dia?>">
		<div class="red-text"><?php echo $erros['Dia'].'<br/>'?> </div>

		<label>Hora (hora:minutos)</label>
		<input type="text" name="Hora" value="<?php echo $Hora?>">
		<div class="red-text"><?php echo $erros['Hora'].'<br/>'?> </div>

		
        <div class="center">
            <!--Botão de salvar para editar filme-->
            <div class="center" style="margin-top: 10px solid; display: inline-block;">
            <input type="hidden" name="Id_sessao" value="<?php echo $Id_sessao ?>">
            <input type="submit" name="salvar" value="Salvar" class="btn brand z-depth-0">
            </div>
            <!--Botão de cancelar edição-->
            <div class="center" style="margin-top: 10px solid; display: inline-block;">
            <!--input type="hidden" name="Id" value="<?php echo $Id ?>">-->
            <input type="hidden" name="Id_sessao" value="<?php echo $Id_sessao ?>">
            <input type="submit" name="cancelar" value="Cancelar" class="btn brand z-depth-0">
            </div>
        </div>
        
        
		</form>
          

	</section>






<?php include('templates/footer.php'); ?>

</html>