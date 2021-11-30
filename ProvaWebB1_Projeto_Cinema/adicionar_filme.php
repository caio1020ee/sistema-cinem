<?php
   include('config/conexao.php');

   $erros = array('Nome' => '' , 'Diretor' => '','Estudio'=> '','Duracao' => '','Protagonista'=>'','Sinopse'=>'','Genero' => '','Poster'=>'' );
   $Nome = $Diretor = $Estudio = $Duracao = $Protagonista = $Sinopse = $Genero= $Poster ='';

    if(isset($_POST['enviar'])){
	  //Verificar se nome está vazio
      if(empty($_POST['Nome'])){
		
		 $erros['Nome'] = 'Nome obrigatório';
	  }else{
         $Nome = $_POST['Nome'];
	     
	  }

	   //Verificar se diretor está vazio
	   if(empty($_POST['Diretor'])){
	     $erros['Diretor'] = 'Diretor obrigatório <br/>';
	   }else{
	      $Diretor = $_POST['Diretor'];
	      if(!preg_match('/^[a-zA-ZÀ-ú\s]+$/',$Diretor)){
		      $erros['Diretor'] = 'Digite diretor válido';
		      $Diretor = '';
	      }else{
		    
	      }
	  }

	   //Verificar se genero está vazio
	   if(empty($_POST['Genero'])){
		$erros['Genero'] = 'Genero obrigatório <br/>';
	  }else{
		 $Genero = $_POST['Genero'];
		 if(!preg_match('/^[a-zA-ZÀ-ú\s]+$/',$Diretor)){
			 $erros['Genero'] = 'Digite genero válido';
			 $Diretor = '';
		 }else{
			
		 }
	 }
	   //Verificar se estudio está vazio
       if(empty($_POST['Estudio'])){
		  $erros['Estudio'] = 'Estudio obrigatório <br/>';
	   }else{
	       $Estudio = $_POST['Estudio'];
	       if(!preg_match('/^[0-9a-zA-ZÀ-ú\s]+$/',$Estudio)  ){
		       $erros['Estudio'] = 'Digite Estudio válido';
		       $Estudio = '';
	       }
	   }

	   //Verificar se duração está vazio
	   if(empty($_POST['Duracao'])){
		  $erros['Duracao']= 'Duração obrigatório <br/>';
	   }else{
	       $Duracao = $_POST['Duracao'];	        
 	    }  
	    //Verificar se protagonista está vazio
	    if(empty($_POST['Protagonista'])){
		    $erros['Protagonista'] =  'Protagonista obrigatório <br/>';
	    }else{
	         $Protagonista = $_POST['Protagonista'];
	         if(!preg_match('/^[a-zA-ZÀ-ú\s]+$/',$Protagonista)){
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
			 $Nome = mysqli_real_escape_string($conn,$_POST['Nome']);
			 $Diretor = mysqli_real_escape_string($conn,$_POST['Diretor']);
			 $Genero = mysqli_real_escape_string($conn,$_POST['Genero']);
			 $Estudio = mysqli_real_escape_string($conn,$_POST['Estudio']);
			 $Duracao = mysqli_real_escape_string($conn,$_POST['Duracao']);
			 $Protagonista = mysqli_real_escape_string($conn,$_POST['Protagonista']);
			 $Sinopse = mysqli_real_escape_string($conn,$_POST['Sinopse']);  

		
			 //Criando a Query
			 $sql = "INSERT INTO filme (Nome,Diretor,Genero,Estudio,Duracao,Protagonista,Sinopse,Status_filme, Ano) VALUES('$Nome','$Diretor','$Genero','$Estudio',$Duracao,'$Protagonista','$Sinopse','Em cartaz',2021)";
		
			 //Salva no banco de dados
			 if (mysqli_query($conn, $sql)){
				//Sucesso
				$ssql = "SELECT MAX(Id) AS Ultimo FROM filme;";
				$result = mysqli_query($conn,$ssql);
			

				//Busca o resultado (uma linha) em forma de vetor
				$f = mysqli_fetch_assoc($result);
				$fi = mysqli_real_escape_string($conn,$f['Ultimo']);

				header('Location: ad_imagem.php?Id='.$fi); 
			} else{
				//echo 'query error1'.mysqli_error($conn);
			}
		
		}   
    }

	
    
 




?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>
	
	<section class="white container grey-text">
		<h4 class=" center blue-text">Adicionar novo filme</h4>
        <form class="white" action="adicionar_filme.php" method="POST" style="padding: 20px;">
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
        
		

		

        

		<div class="center" style="margin-top: 10px;">
		   <input type="submit" name="enviar" value="Enviar" class="btn brand z-depth-0"> 

		</div>

		</form>

		


	</section>
	

	
	<?php include('templates/footer.php'); ?>

</html>