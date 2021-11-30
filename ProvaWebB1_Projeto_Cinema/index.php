<?php
  
  include('config/conexao.php');

  //Query para buscar
  $sql = 'SELECT * FROM filme';
  
  //resultado como um conjunto de linhas
  $result = mysqli_query($conn,$sql);

  // busca a query
  $filmes = mysqli_fetch_all($result, MYSQLI_ASSOC);

  //limpa a memoria de result
  mysqli_free_result($result);



  //------------------------------
  
  //------------------------------

  //fecha conexão
  mysqli_close($conn);

  


?>



<!DOCTYPE html>
<html>
  <link rel="stylesheet" href="estilos/estilo.css">
	
	<?php include('templates/header.php'); ?>
	
	<h4 class="center blue-text">Filmes em cartaz</h4>
  
    <div class="container" >
      <div class="column">
         
        <?php foreach($filmes as $filme) {?>
        <?php if ($filme['Status_filme'] == 'Em cartaz') {?>    

        <div class="caixa_filme" >
            <div class="row" style=" display:flex">
                
                <div class="column" style="padding: 3px;">
                
                <img src="posteres/<?php echo htmlspecialchars($filme['Poster']) ?>" alt="poster" class="poster">
              

              
                </div>
               <!--Segunda coluna--> 
                <div class="column card-content info_filme" >
                    <p>Nome: <?php echo htmlspecialchars($filme['Nome']) ?></p>
                    <p>Ano: <?php echo htmlspecialchars($filme['Ano']) ?> </p>
                    <p>Diretor: <?php echo htmlspecialchars($filme['Diretor']) ?></p>
                    <p>Genêro: <?php echo htmlspecialchars($filme['Genero']) ?> </p>
                    <p>Estúdio: <?php echo htmlspecialchars($filme['Estudio']) ?></p>
                    <p>Duração: <?php echo htmlspecialchars($filme['Duracao']) ?> minutos</p>
                    <p>Protagonista: <?php echo htmlspecialchars($filme['Protagonista']) ?></p>
                    <p>Sinopse: <?php echo htmlspecialchars($filme['Sinopse']) ?></p>
                    <p>Status: <?php echo htmlspecialchars($filme['Status_filme']) ?></p>
                </div>  
                
                

            </div>
            <!--Botão das sessões ; -->
            <div class="card-action center-align btn_sessoes" >
                <a class="brand-text" href="sessoes.php?Id=<?php echo $filme['Id']?>">Sessões</a>
            </div>
              
        </div>
           <br>
         <?php } ?>
        <?php } ?>
         






      </div>
    </div>

    

    <div class="center-align"><a href="todos_filmes.php" class="btn brand z-depth-0">Todos os Filmes</a>  </div>
    <br>
    <div class="center-align"><a href="todos_ingressos.php" class="btn brand z-depth-0">Todos os Ingressos</a>  </div>
	
	
	<?php include('templates/footer.php'); ?>

</html>