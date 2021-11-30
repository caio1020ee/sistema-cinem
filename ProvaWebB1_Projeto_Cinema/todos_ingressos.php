<?php
  
  include('config/conexao.php');

  //Query para buscar
  $sql = 'SELECT i.Id_ingresso AS Ingresso, s.Id_sessao AS Sessao, s.Id_sala AS Sala, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora, i.Preco as Preco, i.Tipo as Tipo FROM sessao s, filme f,ingresso i WHERE s.Id_filme = f.Id and s.Id_sessao = i.Id_sessao;';
  
  //resultado como um conjunto de linhas
  $result = mysqli_query($conn,$sql);

  // busca a query
  $ingressos = mysqli_fetch_all($result, MYSQLI_ASSOC);

  //limpa a memoria de result
  mysqli_free_result($result);

  //fecha conexão
  mysqli_close($conn);


  


?>



<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="estilos/estilo.css">
	<?php include('templates/header.php'); ?>
	
	<h4 class="center blue-text">Todos os ingressos</h4>
  
   <?php if($ingressos): ?>
    <div class="container" >
      <div class="column">
         

        <?php foreach($ingressos as $ingresso) {?>
         <div  >
            <div class="row caixa_ingresso">
                
                
               <!--Segunda coluna--> 
                <div class="column card-content info_ingresso">
                   <p>Ingresso: <?php echo htmlspecialchars($ingresso['Ingresso'])?> </p>
                   <p>Tipo: <?php echo htmlspecialchars($ingresso['Tipo'])?></p>
                   <p>Preço: <?php echo htmlspecialchars($ingresso['Preco'])?></p>
                   <p>Sessão: <?php echo htmlspecialchars($ingresso['Sessao'])?> </p>
                   <p>Sala <?php echo htmlspecialchars($ingresso['Sala'])?></p>
                   <p>Filme: <?php echo htmlspecialchars($ingresso['Filme'])?></p>
                   <p>Dia: <?php echo htmlspecialchars($ingresso['Dia'])?></p>
                   <p>Hora: <?php echo htmlspecialchars($ingresso['Hora'])?></p>
                </div> 
                
                

           
           
 
         </div>
         
        <?php } ?>
         






      </div>
    </div>

    <?php else: ?>    
        <h1 class="center-align">Não há ingressos cadastrados.</h1>  
    <?php endif ?>
 
	
	
	<?php include('templates/footer.php'); ?>

</html>