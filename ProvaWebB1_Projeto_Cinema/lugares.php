<?php
include('config/conexao.php');

$erros = array('Lugar' => '' , 'Tipo' => '','Preco'=> '');
$Lugar = $Tipo = $Preco = '';
$id_sessao = 0;

//Verificando se o parâmetro Nome foi enviado pelo get_browser
if(isset($_GET['Id_sessao'])){
    //echo 'Funcionou get';
    $Id = mysqli_real_escape_string($conn,$_GET['Id_sessao']);
    $sql = "SELECT l.Id_lugar as Id_lugar,L.Id_sessao AS Id_sessao,l.Id_sala as Id_sala,l.Linha as Linha, l.Coluna as Coluna,l.Ocupado as Ocupado,sa.Colunas as Total_colunas, sa.Linhas as Total_linhas FROM lugar l, sala sa WHERE Id_sessao = $Id AND L.Id_sala = sa.Numero;";
    //echo $sql;   
    $result =  mysqli_query($conn,$sql);
    $lugares = mysqli_fetch_all($result, MYSQLI_ASSOC);

    
    //limpa a memoria de result
    mysqli_free_result($result);

    
    //Sessão
	$sql3 = "SELECT s.Id_sessao AS Codigo, s.Id_sala AS Sala, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora FROM sessao s, filme f WHERE s.Id_filme = f.Id and s.Id_sessao = $Id;";
	$result3 = mysqli_query($conn,$sql3);
	$sessao = mysqli_fetch_assoc($result3);
    $id_sessao = $sessao['Codigo'];

    $sl = intval($sessao['Sala']);
    

    //Limites de linha e coluna
    $sql2 = "SELECT sala.Colunas as Colunas, sala.Linhas as Linhas FROM sessao, sala WHERE sessao.Id_sala = sala.Numero AND sessao.Id_sala =$sl;";
    $result2 = mysqli_query($conn,$sql2);
    $lc = mysqli_fetch_assoc($result2);
 
    mysqli_free_result($result2);


    
    //mysqli_free_result($result3);
    //fecha conexão
    mysqli_close($conn);

}else{
    //echo 'Erro get';
}

//Deletar filme do banco de dados
if(isset($_POST['comprar'])){
   //Limpando a query
   //echo 'Comprar';
   $Id_sessao =  mysqli_real_escape_string($conn,$_POST['Id_sessao']);
   //echo $Id_sessao;
   $lu =  mysqli_real_escape_string($conn,$_POST['Lugar']);

   //Verificando lugar
   

   if(empty($_POST['Lugar'])){
    //echo 'Lugar obrigatório <br/>';
    $erros['Lugar'] = "Lugar obrigatório";
   }else{

     if(!is_numeric($_POST['Lugar'])){
           $erros['Lugar'] = 'Digite lugar válido (numero)';
           $Lugar = '';
     }else{
          $sqllugar = "SELECT Id_lugar FROM lugar WHERE Id_lugar = $lu AND Id_sessao = $Id_sessao;";
          $rl = mysqli_query($conn,$sqllugar);
          $lug = intval(mysqli_fetch_assoc($rl));

          if($lug){
            $Lugar = $_POST['Lugar'];  
            //echo "Lugar funcionou";
          }else{
              $erros['Lugar'] = "Lugar não encontrado, digite outro.";
              //echo "Lugar não encontrado, digite outro.";  
          }
          
     }
    }

    //Verificando tipo

    if(empty($_POST['Tipo'])){
        //echo 'Tipo obrigatório <br/>';
        $erros['Tipo'] = "Tipo obrigatório";
    }else{
        $tp = array('Meia','Meia-entrada','Meia-Entrada','Meia Entrada','MEIA ENTRADA','meia entrada','meia-entrada','meia','MEIA-ENTRADA','Inteira','inteira','INTEIRA','Inteiro','inteiro','INTEIRO');
        
        if(in_array($_POST['Tipo'],$tp )){
            $Tipo = $_POST['Tipo'];
            //echo 'Tipo funcionou';
        }else{
            $erros['Tipo'] = "Digite tipo válido";
            //echo "Digite tipo válido";
        }

    }

    //Verificando preço
    if(empty($_POST['Preco'])){
        //echo 'Preço obrigatório <br/>';
        $erros['Tipo'] = "Preço obrigatório";
    }else{
        //$_POST['Preco']
        $tep = str_replace(',','.',strval($_POST['Preco']));
        if(!is_numeric(floatval($tep))){
          $erros['Preco'] = "Digite valor numero pro preço";
          //echo 'Digite valor numero pro preço';
        }else{
            $Preco = round(floatval($tep),2);
            //echo 'Preço funcionou';
        }
    }

    if (array_filter($erros)){
        //echo 'Erro no formulário <br/>';
    }else{
        //$Id_sessao =  mysqli_real_escape_string($conn,$_POST['Id_sessao']);

        

        //Adicionar ingresso
        $ading = "INSERT INTO ingresso(Id_sessao,Id_lugar,Preco,Tipo) VALUES ($Id_sessao,$Lugar,$Preco,'$Tipo');";

        if(mysqli_query($conn, $ading)){
            $ultimo = "SELECT MAX(Id_ingresso) as Ultimo FROM ingresso;";

            if(mysqli_query($conn,$ultimo)){
            $ring = mysqli_query($conn,$ultimo); 
            $ing = mysqli_fetch_assoc($ring);
            $ig = $ing['Ultimo'];   
            //Definir lugar ocupado
            $oc = "UPDATE lugar SET Ocupado = 1 WHERE Id_sessao = $Id_sessao and Id_lugar = $Lugar";
            if(mysqli_query($conn, $oc)){
              header('Location: ingresso_pronto.php?Id_ingresso='.$ig);
            }else{
                //echo 'query error: Na ocupação do lugar'.mysqli_error($conn);
            }
            }else{
                //echo 'query error: Na verificação do ultimo ingresso adicionado'.mysqli_error($conn);
            }
        }else{
           //echo 'query error: Na adição do ingresso'.mysqli_error($conn);
        }
        
    }


   

   
}

function cor_assento($ocu){
    
    if($ocu){
        return 'grey';
    }else{
        return 'greenyellow';
    }
    
}


?>

<!DOCTYPE html> 

<?php include('templates/header.php'); ?>

<h2 class="center">Sessão <?php echo $id_sessao?></h2>


<br>
    
    <?php //include('__lugares_falho.php'); ?>
    
<?php  for($c = 1;$c <= intval($lc['Colunas']) ;$c++){ ?>
    
    <div >
    <div >
        <?php foreach($lugares as $lugar){ ?>
        
         
            <?php if($lugar['Coluna'] == $c){ ?>
        <div  style="display: inline-block;  "  >
        
        <img src="assento.png" alt="assento" style="background-color:<?php echo cor_assento($lugar['Ocupado'])?>; width:40px; height:40px; ">
        <?php echo htmlspecialchars($lugar['Id_lugar'])?>
        <?php }?>
        
        
        
        </div>
        <?php }?>
    </div>  
    </div>   
    
<?php }?>
   
<hr>
   

<h3 class="center">Ingresso</h3>

<section class="container grey-text">
        <form class="white" action="lugares.php" method="POST" style="padding: 20px;">
        <p><?php echo htmlspecialchars($sessao['Filme'])?></p>
        <p>Sala <?php echo htmlspecialchars($sessao['Sala'])?></p>
        <p>Dia: <?php echo htmlspecialchars($sessao['Dia'])?></p>
        <p>Hora: <?php echo htmlspecialchars($sessao['Hora'])?></p>
        <label>Lugar (Assento)</label>
		<input type="text" name="Lugar" value="<?php echo $Lugar?>">
		<div class="red-text"><?php echo $erros['Lugar'].'<br/>'?> </div>

        <label>Tipo de ingresso</label>
		<input type="text" name="Tipo" value="<?php echo $Tipo?>">
		<div class="red-text"><?php echo $erros['Tipo'].'<br/>'?> </div>

		<label>Preço</label>
		<input type="text" name="Preco" value="<?php echo $Preco?>">
		<div class="red-text"><?php echo $erros['Preco'].'<br/>'?> </div>

		

		<div class="center" style="margin-top: 10px;">
           <input type="hidden" name="Id_sessao" value = "<?php echo $id_sessao;?>">
		   <input type="submit" name="comprar" value="Comprar" class="btn brand z-depth-0"> 

		</div>

		</form>


	</section>
    






<?php include('templates/footer.php'); ?>

</html>