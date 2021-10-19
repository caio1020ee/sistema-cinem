<?php
include('config/conexao.php');



//Verificando se o parâmetro Nome foi enviado pelo get_browser
if(isset($_GET['Id_ingresso'])){
    //Limpa os dados de sql injection
    
    $Id_ingresso = mysqli_real_escape_string($conn,$_GET['Id_ingresso']);


    //Monta a query
	$sql = "SELECT i.Id_ingresso AS Ingresso, s.Id_sessao AS Sessao, s.Id_sala AS Sala, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora, i.Preco as Preco, i.Tipo as Tipo FROM sessao s, filme f,ingresso i WHERE s.Id_filme = f.Id and s.Id_sessao = i.Id_sessao and i.Id_ingresso  = $Id_ingresso;";
    
    //Executa a query e guarda em $result
	$result = mysqli_query($conn,$sql);
    //echo $result;

    //Busca o resultado (uma linha) em forma de vetor
	$ingresso = mysqli_fetch_assoc($result);

    //-------------------------------------------
   


    
    
    mysqli_free_result($result);
    mysqli_close($conn);
    
}else{
    //echo 'Erro';
}



?>

<!DOCTYPE html>

<?php include('templates/header.php'); ?>

<div style="padding-left: 50px; padding-right: 50px;  padding-top:30px">
<div class="center-align"style="padding-left: 50px; padding-right:50px">
   
   <a href="#">
       <div  class=" column card-content left-align blue" style="background-color:red;  border: 1px solid; border-color:black;  ">
<pre style="color: black;">
Ingresso: <?php echo htmlspecialchars($ingresso['Ingresso'])?>   
Tipo: <?php echo htmlspecialchars($ingresso['Tipo'])?> 
Preço: <?php echo htmlspecialchars($ingresso['Preco'])?> 
Sessão: <?php echo htmlspecialchars($ingresso['Sessao'])?>  
Sala <?php echo htmlspecialchars($ingresso['Sala'])?> 
Filme: <?php echo htmlspecialchars($ingresso['Filme'])?> 
Dia: <?php echo htmlspecialchars($ingresso['Dia'])?> 
Hora: <?php echo htmlspecialchars($ingresso['Hora'])?> 
</pre>            

      
       </div>
   </a>

   </div>
<br>

<!--Botôes-->
<div class="center-align"><a href="index.php" class="btn brand z-depth-0">Certo</a>  </div>
 
</div>




<?php include('templates/footer.php'); ?>

</html>