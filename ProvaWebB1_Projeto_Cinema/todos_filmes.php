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

  //print_r($pizzas);
  //print_r($filmes[0]['Nome']);
  # Mesma finalidade do comando split
  


?>



<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>
	
	<h4 class="center blue-text">Todos os Filmes</h4>
  
   <?php if($filmes): ?>
    <div class="container" >
      <div class="column">
         
        <!--class="card z-depth-0" -->
        <?php foreach($filmes as $filme) {?>
         <div  style="border: 2px solid; color:black;     background-color:white">
            <div class="row" style="display:flex">
                
                <div class="column" style="padding: 3px;" >
                
                <img src="posteres/<?php echo htmlspecialchars($filme['Poster']) ?>" alt="poster" style="width: 150px;height:200px">
              

              
                </div>
               <!--Segunda coluna--> 
                <div class="column card-content" style="font-size: 15px; color: black ;padding: 10px;">
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
           <div class="card-action center-align" style="font-size: 30px; background-color:lightyellow; border-top:red; border: 10px">
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