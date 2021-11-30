<?php

    include('config/conexao.php');

    $erros = array('Nome' => '' , 'Diretor' => '','Estudio'=> '','Duracao' => '','Protagonista'=>'','Sinopse'=>'','Genero' => '','Status_filme' => '' );
    $Nome = $Diretor = $Estudio = $Duracao = $Protagonista = $Sinopse = $Status_filme = $Genero='';

    if(isset($_POST['editar'])){
      
        //Limpa os dados de sql injection
        $Id =  mysqli_real_escape_string($conn,$_POST['Id']);
       
        //Monta query
        $sql = "SELECT * FROM filme WHERE Id = $Id;";

        //Executa a query e guarda em $result
        $result = mysqli_query($conn,$sql);
        
        //Busca o resultado em forma de vetor
        $filme = mysqli_fetch_assoc($result);

        $Nome = $filme['Nome'];
        $Diretor = $filme['Diretor'];
        $Estudio = $filme['Estudio'];
        $Duracao = $filme['Duracao'];
        $Protagonista = $filme['Protagonista'];
        $Sinopse = $filme['Sinopse'];
        $Genero = $filme['Genero'];
        $Status_filme = $filme['Status_filme'];

        mysqli_free_result($result);
        
        mysqli_close($conn);
    }

    if(isset($_POST['salvar'])){
        //Verificar status
        if(empty($_POST['Status_filme'])){
            $erros['Status_filme'] = 'Status obrigatório <br/>';
        }else{
            $st = array('Em cartaz','Fora de cartaz');

            if(in_array($_POST['Status_filme'],$st)){
                $Status_filme = $_POST['Status_filme'];
            }else{
                $erros['Status_filme'] = "Status inválido";
            }
        }

        //Verificar se nome está vazio
        if(empty($_POST['Nome'])){
        $erros['Nome'] = 'Nome obrigatório <br/>';
        }else{
        $Nome = $_POST['Nome'];
        
        }

        //Verificar se diretor está vazio
        if(empty($_POST['Diretor'])){
        $erros['Diretor'] = 'Diretor obrigatório <br/>';
        }else{
            $Diretor = $_POST['Diretor'];
            if(!preg_match('/^[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+$/',$Diretor)){
                $erros['Diretor'] = 'Digite diretor válido';
                $Diretor = '';
            }
        }

        //Verificar se genero está vazio
        if(empty($_POST['Genero'])){
        $erros['Genero'] = 'Genero obrigatório <br/>';
        }else{
        $Genero = $_POST['Genero'];
        if(!preg_match('/^[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+$/',$Diretor)){
            $erros['Genero'] = 'Digite genero válido';
            $Diretor = '';
        }else{
            
        }
    }
        //Verificar se estudio está vazio
        if(empty($_POST['Estudio'])){
            $erros['Estudio']= 'Estudio obrigatório <br/>';
        }else{
            $Estudio = $_POST['Estudio'];
            if(!preg_match('/^[0-9a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+$/',$Estudio)  ){
                $erros['Estudio'] = 'Digite Estudio válido';
                $Estudio = '';
            }
        }

        //Verificar se duração está vazio
        if(empty($_POST['Duracao'])){
            $erros['Duracao'] =  'Duração obrigatório <br/>';
        }else{
            $Duracao = $_POST['Duracao'];    
        }  

        //Verificar se protagonista está vazio
        if(empty($_POST['Protagonista'])){
            $erros['Protagonista'] = 'Protagonista obrigatório <br/>';
        }else{
            $Protagonista = $_POST['Protagonista'];
            if(!preg_match('/^[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+$/',$Protagonista)){
                    $erros['Protagonista'] = 'Digite Protagonista válido';
                    $Protagonista = '';
            }
        }

        //Verificar se sinopse está vazio
        if(empty($_POST['Sinopse'])){
        $erros['Sinopse'] = 'Sinopse obrigatório <br/>';
        }else{
            $Sinopse = $_POST['Sinopse'];
            
        }


        if (array_filter($erros)){
            //echo 'Erro no formulário <br/>';
        }else{
            //echo 'Formulário válido <br/>';
            //Alterar no BD
            $Id = mysqli_real_escape_string($conn,$_POST['Id']);
            $Nome = mysqli_real_escape_string($conn,$_POST['Nome']);
            $Diretor = mysqli_real_escape_string($conn,$_POST['Diretor']);
            $Genero = mysqli_real_escape_string($conn,$_POST['Genero']);
            $Estudio = mysqli_real_escape_string($conn,$_POST['Estudio']);
            $Duracao = mysqli_real_escape_string($conn,$_POST['Duracao']);
            $Protagonista = mysqli_real_escape_string($conn,$_POST['Protagonista']);
            $Sinopse = mysqli_real_escape_string($conn,$_POST['Sinopse']);  
            $Status_filme= mysqli_real_escape_string($conn,$_POST['Status_filme']); 
        
            //Criando a Query
            $sql = "UPDATE filme SET Nome='$Nome',Diretor='$Diretor',Genero='$Genero',Estudio='$Estudio',Duracao=$Duracao,Protagonista='$Protagonista',Sinopse='$Sinopse',Status_filme ='$Status_filme', Ano=2021 WHERE Id = $Id;";
        
            //Salva no banco de dados
            if (mysqli_query($conn, $sql)){
                //Sucesso 
                header('Location: filme_adm.php?Id='.$Id); 
            } else{
                echo 'Edição de filme query error'.mysqli_error($conn);
            }
            
        
        }   
    }

    if(isset($_POST['cancelar'])){
        $Id = mysqli_real_escape_string($conn,$_POST['Id']);
        header('Location: filme_adm.php?Id='.$Id); 
    }  

 
?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>
	
	<section class="container grey-text">
		<h4 class="center blue-text">Editar</h4>
        <form class="white" action="editar_filme.php" method="POST" style="padding: 20px;">
        <input type="hidden" name="Id" value="<?php echo $Id ?>">
        <label>Nome</label>
		<input type="text" name="Nome" value="<?php echo $Nome?>">
		<div class="red-text"><?php echo $erros['Nome'].'<br/>'?> </div>

        <label>Diretor</label>
		<input type="text" name="Diretor" value="<?php echo $Diretor?>">
		<div class="red-text"><?php echo $erros['Diretor'].'<br/>'?> </div>

		<label>Genêro</label>
		<input type="text" name="Genero" value="<?php echo $Genero?>">
		<div class="red-text"><?php echo $erros['Genero'].'<br/>'?> </div>

		<label>Estúdio</label>
		<input type="text" name="Estudio" value="<?php echo $Estudio?>">
		<div class="red-text"><?php echo $erros['Estudio'].'<br/>'?> </div>

		<label>Duração</label>
		<input type="text" name="Duracao" value="<?php echo $Duracao?>">
		<div class="red-text"><?php echo $erros['Duracao'].'<br/>'?> </div>

		<label>Protagonista</label>
		<input type="text" name="Protagonista" value="<?php echo $Protagonista?>">
		<div class="red-text"><?php echo $erros['Protagonista'].'<br/>'?> </div>

		<label>Sinopse</label>
		<input type="text" name="Sinopse" value="<?php echo $Sinopse?>">
		<div class="red-text"><?php echo $erros['Sinopse'].'<br/>'?> </div>
        <div class="center">

        <label>Status</label>
		<input type="text" name="Status_filme" value="<?php echo $Status_filme?>">
		<div class="red-text"><?php echo $erros['Status_filme'].'<br/>'?> </div>
        <div class="center">

            <div class="btns">
                <!--Botão de salvar para editar filme-->
               
                  <input type="submit" name="salvar" value="Salvar" class="btn brand z-depth-0">
              
                <!--Botão de cancelar edição-->
              
                <input type="hidden" name="Id" value="<?php echo $Id ?>">
                <input type="submit" name="cancelar" value="Cancelar" class="btn brand z-depth-0">
             
            </div>
        </div>
        
        
		</form>
          

	</section>
	

	
	<?php include('templates/footer.php'); ?>

</html>