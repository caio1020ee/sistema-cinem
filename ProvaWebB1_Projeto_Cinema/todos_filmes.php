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
	<link rel="stylesheet" href="estilos/estilo.css">
	<?php include('templates/header.php'); ?>
	
	<h4 class="center blue-text">Todos os Filmes</h4>
  
   <?php if($filmes): ?>
    <div class="container" >
      <div class="column">
         
      
        <?php foreach($filmes as $filme) {?>
         <div  class="caixa_filme">
            <div class="row" style="display:flex">
                
                <div class="column" style="padding: 3px;" >
                
                <img src="posteres/<?php echo htmlspecialchars($filme['Poster']) ?>" alt="poster" class="poster">
              

              
                </div>
               <!--Segunda coluna--> 
                <div class="column card-content info_filme">
                   <p>Nome: <?php echo htmlspecialchars($filme['Nome']) ?></p>
                   <p>Diretor: <?php echo htmlspecialchars($filme['Diretor']) ?></p>
                   <p>Genêro: <?php echo htmlspecialchars($filme['Genero']) ?></p>
                   <p>Estúdio: <?php echo htmlspecialchars($filme['Estudio']) ?></p>
                   <p>Duração: <?php echo htmlspecialchars($filme['Duracao']) ?> minutos</p>
                   <p>Protagonista: <?php echo htmlspecialchars($filme['Protagonista']) ?></p>
                   <p>Sinopse: <?php echo htmlspecialchars($filme['Sinopse']) ?></p>
                </div> 
                
                

           </div>
           <?php if($filme['Status_filme'] == 'Em cartaz'){?>
           <!--Botão das sessões-->
           <div class="card-action center-align btn_sessoes" >
							<a class="brand-text" href="sessoes.php?Nome=<?php echo $filme['Nome']?>">Sessões</a>
					 </div>
           <?php } ?>
 
         </div>
         <br>
        <?php } ?>
         






      </div>
    </div>

    <?php else: ?>    
        <h1 class="center-align">Não há filmes cadastrados.</h1>  
    <?php endif ?>
 
	
	
	<?php include('templates/footer.php'); ?>

</html>