<?php
include('config/conexao.php');


//Verificando se o parâmetro Nome foi enviado pelo get_browser
if(isset($_GET['Id'])){
    //Limpa os dados de sql injection
    
    $Id = mysqli_real_escape_string($conn,$_GET['Id']);
    
    //Monta a query
	$sql = "SELECT * FROM filme WHERE Id = $Id;";
    //Executa a query e guarda em $result
	$result = mysqli_query($conn,$sql);
 

	//Busca o resultado (uma linha) em forma de vetor
	$filme = mysqli_fetch_assoc($result);
    
    
    mysqli_free_result($result);

    //-------------------Testes-------------------
    $tam =  "SELECT COUNT(*) FROM sessao WHERE Id_filme = $Id;";
    $restam = mysqli_query($conn,$tam);
    $tamanho_sessoes =  mysqli_fetch_assoc($restam);
   

    //-----------------Sessões-------------------
    $se_sql = "SELECT * FROM sessao WHERE Id_filme = $Id;";
    $se_result = mysqli_query($conn,$se_sql);
    $sessoes =  mysqli_fetch_all($se_result, MYSQLI_ASSOC);//Mais de 1 linha
    mysqli_free_result($se_result);
    //-------------------------------------------
   
   
		
	mysqli_close($conn);
}else{
    //echo 'Erro no get id';
}

?>

<!DOCTYPE html>

<?php include('templates/header.php'); ?>


<h3 class="center-align"><?php echo htmlspecialchars($filme['Nome'])?></h3>

<!---------------------------->

<?php if($sessoes): ?>

    <?php foreach ($sessoes as $sessao) {?>
        <div class="center-align pad_e50_d50">
   
        <a href="lugares.php?Id_sessao=<?php echo $sessao['Id_sessao'] ?>">
            <div  class="center-align btn red" style="background-color:red;  border: 1px solid; border-color:black; ">Sala <?php echo htmlspecialchars($sessao['Id_sala'])?>  Dia <?php echo htmlspecialchars($sessao['Dia'])?> Hora <?php echo htmlspecialchars($sessao['Hora']) ?></div>
        </a>

        </div>


    <?php } ?>    
     

<?php else: ?>

    <div class="center-align pad_e50_d50">
   
        <div  class="center-align btn red" style="background-color:red; width:300px; height:45px; border: 1px solid; border-color:black; ">Não há sessões!</div>
    
    </div>

<?php endif ?>    

<?php include('templates/footer.php'); ?>

</html>