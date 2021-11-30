<?php
  
  include('config/conexao.php');

  //Query para buscar
  $sql = 'SELECT * FROM filme;';
  
  //resultado como um conjunto de linhas
  $result = mysqli_query($conn,$sql);

  // busca a query
  $filmes = mysqli_fetch_all($result, MYSQLI_ASSOC);

  //limpa a memoria de result
  mysqli_free_result($result);

  //fecha conexão
  mysqli_close($conn);


  


?>



<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="estilos/estilo_novo.css">
	<?php include('templates/header.php'); ?>

	<ul id="nav-mobile" class="center-align">
			<li><a href="adicionar_filme.php" class="btn brand z-depth-0">Adicionar Filme</a></li>
	</ul>

	<h4 class="center blue-text">Todos os Filmes</h4>
    
  
   <?php if($filmes): ?>
    <div class="container" >
      <div class="column">
         

        
        <?php foreach($filmes as $filme) {?>

         
           
                <div class="row">
                  <div class="left-align"style="padding-left: 50px; ">
                
                  <a class="#" href="filme_adm.php?Id=<?php echo $filme['Id']?>">
                  <div  class="center-align yellow item_lst_filme"><?php echo '- '.htmlspecialchars($filme['Nome']) ?> </div>
                  </a>
                
                  </div>

                </div>
          
          
            
         
        <?php } ?>
         


        



      </div>
    </div>

    <?php else: ?>    
        <h1 class="center-align">Não há filmes cadastrados.</h1>  
    <?php endif ?>
 
	
	
	<?php include('templates/footer.php'); ?>

</html>