<?php
include('config/conexao.php');

//Verificando se o parâmetro Nome foi enviado pelo get_browser

    
    
    //Monta a query
	$sql = "SELECT * FROM sala ;";
    //echo $sql;

    //Executa a query e guarda em $result
	$result = mysqli_query($conn,$sql);

		
	//Busca o resultado em forma de vetor
	$salas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);
		
	


    if(isset($_POST['deletar'])){
    //echo 'Chega';    
    //Limpando a query
    $ns= mysqli_real_escape_string($conn,$_POST['Numero_sala']);
    
    
    //Montando a query
    $del_sessoes = "DELETE FROM sessao WHERE Id_sala =$ns;";
    $sql = "DELETE FROM sala WHERE Numero = $ns";
    $del_lugares = "DELETE FROM lugar WHERE Id_sala = $ns;";
    
    //Removendo do BD
    if(mysqli_query($conn,$del_sessoes)){
    if(mysqli_query($conn,$del_lugares)){
    if(mysqli_query($conn,$sql)){
        //Sucesso
        header('Location: lista_salas_adm.php');
    }else{
        //echo 'Deletar sala query error'.mysqli_error($conn);
    }
    }else{
        //echo 'Erro no deletar dos lugares';
    }
    }
    
    }

    mysqli_close($conn);


?>

<!DOCTYPE html>

<?php include('templates/header.php'); ?>

<h2 class="center">Lista de salas</h2>

<?php if($salas): ?>

<?php foreach ($salas as $sala) {?>
    <div class="center-align">
        <div class="center-align"style="padding-left: 50px; padding-right:50px; display: inline-block;">
        <a href="lugares.php">
            <div  class="center-align btn red" style="background-color:red;  border: 1px solid; border-color:black; ">Sala <?php echo htmlspecialchars($sala['Numero'])?>  Linhas: <?php echo htmlspecialchars($sala['Linhas'])?> Colunas: <?php echo htmlspecialchars($sala['Colunas']) ?> Assentos: <?php echo htmlspecialchars($sala['Assentos']) ?>  </div>
        </a>
        </div>
        <form action="lista_salas_adm.php" method="POST" class="center" style="display: inline-block;">
            <input type="hidden" name="Numero_sala" value = "<?php echo $sala['Numero'];?>">
            <input type = "submit" name ="deletar" value = "Deletar" class="btn red z-depth-0">
        </form>
    </div>

    <hr>


<?php } ?>    
 

<?php else: ?>

<div class="center-align"style="padding-left: 50px; padding-right:50px">

    <div  class="center-align btn red" style="background-color:red; width:300px; height:45px; border: 1px solid; border-color:black; ">Não há salas!</div>

</div>

<?php endif ?>   


<?php include('templates/footer.php'); ?>

</html>