<?php
    include('config/conexao.php');

    $erros = array('Sala' => '' , 'Dia' => '','Hora'=> '');
    $Sala = $Hora = $Dia = ''; 
    $id_filme = 0;
    $nome_filme = '';

    //Verificando se o parâmetro Nome foi enviado pelo get_browser
    if(isset($_POST['adses'])){
   
        //Limpa os dados de sql injection
        $Id =  mysqli_real_escape_string($conn,$_POST['Id']);
        
        //Monta query
        $sql = "SELECT * FROM filme WHERE Id = $Id;";

        //Executa a query e guarda em $result
        $result = mysqli_query($conn,$sql);
        
        //Busca o resultado em forma de vetor
        $filme = mysqli_fetch_assoc($result);

        $id_filme = $filme['Id'];
        $nome_filme = $filme['Nome'];

        $Nome = $filme['Nome'];
        $Diretor = $filme['Diretor'];
        $Estudio = $filme['Estudio'];
        $Duracao = $filme['Duracao'];
        $Protagonista = $filme['Protagonista'];
        $Sinopse = $filme['Sinopse'];
        $Genero = $filme['Genero'];

        mysqli_free_result($result);
        
        mysqli_close($conn);
    }else{
        //echo 'Erro na captura dos dados';
    }

    //Para salvar sessão
    if(isset($_POST['enviar'])){
    //Limpando a query

    
    $Id = mysqli_real_escape_string($conn,$_POST['Id']);
    $id_filme = $Id;
    //Esse $_POST['Id]  tras o Id do filme
    //echo $Id; 

    //Verificando sala
    if(empty($_POST['Sala'])){
      
        $erros['Sala'] = 'Sala obrigatória';
    }else{
            
            if(is_numeric($_POST['Sala'])){
         
            $sa = mysqli_real_escape_string($conn,$_POST['Sala']);
            $salasql = "SELECT * FROM sala WHERE Numero = $sa;"; 
            $res_sala = mysqli_query($conn,$salasql);        
            $salaTeste = mysqli_fetch_assoc($res_sala);
       
                if($salaTeste){
                    //Há sala com PK com o valor de Id
                    $Sala = $_POST['Sala'];
                }else{
                    $erros['Sala'] = 'Digite sala válida';
                  
                } 
                mysqli_free_result($res_sala);
            }else{
                //echo 'Sala não numerica';
            }

            
    }
        
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
    
    //Verificando hora
    if(empty($_POST['Hora'])){
       
        $erros['Hora'] = 'Hora obrigatória';
    }else{
        
        $horario = mysqli_real_escape_string($conn,$_POST['Hora']); 
        
        
   
        
        if(validarHora(strval($horario))){
            //Hora está certa
            $Hora = $horario;
          
        }else{
            $erros['Hora'] = 'Hora errada';
           
        }

    }

    //Validando dia
    if(empty($_POST['Dia'])){
  
        $erros['Dia'] = 'Dia obrigatório';
    }else{
        $dd = mysqli_real_escape_string($conn,$_POST['Dia']);

        if(validarDia(strval($dd))){
            $Dia = $dd;
        
        } else{
            $erros['Dia'] = 'Dia errado';
        }
    }

    if (array_filter($erros)){
        //echo 'Erro no formulário <br/>';
    }else{
        //Formulário válido
        $Sala = mysqli_real_escape_string($conn,$_POST['Sala']);
        $Dia = mysqli_real_escape_string($conn,$_POST['Dia']);
        $Hora = mysqli_real_escape_string($conn,$_POST['Hora']);
        $data = strval(date('Y')).'-'.strval($Dia);
    
        //Criando a query
        $sql = "INSERT INTO sessao(Id_sala,Id_filme,Dia,Hora) VALUES($Sala,$id_filme,'$data','$Hora');";
            
        if(mysqli_query($conn, $sql)){
            //Sucesso
            
            $sql2 = "SELECT MAX(Id_sessao) AS Ultimo FROM sessao;";
            $result2 = mysqli_query($conn,$sql2);
            $resposta = mysqli_fetch_assoc($result2);

          
            $ultimo = mysqli_real_escape_string($conn,$resposta['Ultimo']);
        

            //-------------------------------------------

            $sql3 = "SELECT s.Id_sessao AS Codigo, s.Id_sala AS Sala, sa.Colunas AS Colunas,sa.Linhas AS Linhas, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora FROM sessao s, filme f,sala sa WHERE s.Id_filme = f.Id and s.Id_sessao = $ultimo;";  
            $result3 = mysqli_query($conn,$sql3);
            $lin = mysqli_fetch_assoc($result3);


    
            $ses = mysqli_real_escape_string($conn,$lin['Codigo']);
            $ses = intval($ses);
            $sala =  mysqli_real_escape_string($conn,$lin['Sala']);
            $li =  mysqli_real_escape_string($conn,$lin['Linhas']);
            $co = mysqli_real_escape_string($conn,$lin['Colunas']);
          

            for($l = 1;$l <= intval($li);$l++){
                for($c = 1;$c <= intval($co);$c++){
                    $lugar = intval("$sala"."$c"."$l");


                  
                    $sql4 = "INSERT INTO lugar(Id_lugar, Id_sessao, Id_sala, Linha, Coluna, Ocupado) VALUES ($lugar,$ses,$sala,$l,$c,False);";
                    if(mysqli_query($conn, $sql4)){
                        //Sucesso
                       
                    } else{
                        //echo 'query error'.mysqli_error($conn);
                    }

                }
            }
      
    
    //-------------------------------------------
            header('Location: sessoes.php?Id='.$id_filme); 



        } else{
            echo 'query error'.mysqli_error($conn);
        }
    } 

   

    }


 

?>

<!DOCTYPE html>

<?php include('templates/header.php'); ?>

<?php ?>
<section class="container grey-text">
		<h4 class="center blue-text">Adicionar nova sessão</h4>
        <form class="white" action="addsessao.php" method="POST" style="padding: 20px;">
        <label>Sala</label>
		<input type="text" name="Sala" value="<?php echo $Sala?>">
		<div class="red-text"><?php echo $erros['Sala'].'<br/>'?> </div>

        <label>Dia (mes-dia)</label>
		<input type="text" name="Dia" value="<?php echo $Dia?>">
		<div class="red-text"><?php echo $erros['Dia'].'<br/>'?> </div>

		<label>Hora (hora:minuto)</label>
		<input type="text" name="Hora" value="<?php echo $Hora?>">
		<div class="red-text"><?php echo $erros['Hora'].'<br/>'?> </div>

		

		<div class="center" style="margin-top: 10px;">
           <input type="hidden" name="Id" value = "<?php echo $id_filme;?>">
		   <input type="submit" name="enviar" value="Enviar" class="btn brand z-depth-0"> 

		</div>

		</form>


	</section>


<?php include('templates/footer.php'); ?>

</html>