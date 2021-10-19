<?php
include('config/conexao.php');

//Verificando se o parâmetro Nome foi enviado pelo get_browser
if(isset($_GET['Nome'])){
    //Limpa os dados de sql injection
    $Nome = mysqli_real_escape_string($conn,$_GET['Nome']);
    
    //Monta a query
	$sql = "SELECT * FROM filme WHERE Nome = '$Nome';";
    //echo $sql;

    //Executa a query e guarda em $result
	$result = mysqli_query($conn,$sql);
		
	//Busca o resultado em forma de vetor
	$filme = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
		
	mysqli_close($conn);
}else{
    echo 'Erro get';
}

//Deletar filme do banco de dados
if(isset($_POST['deletar'])){
   //Limpando a query
   $Id = mysqli_real_escape_string($conn,$_POST['Id']);

   //Montando a query
   $sql = "DELETE FROM filme WHERE Id = $Id";

   //Removendo do BD
   if(mysqli_query($conn,$sql)){
       //Sucesso
       header('Location: index.php');
   }else{
       //echo 'query error'.mysqli_error($conn);
   }

}



?>

<!DOCTYPE html>

<?php include('templates/header.php'); ?>


<?php if($filme): ?>
<h2 class="center"><?php echo $filme['Nome']  ?></h2>

<!--Botão de editar-->
<form action="editar_filme.php" method="POST" class="center">
    <input type="hidden" name="Id" value = "<?php echo $filme['Id'];?>">
    <input type = "submit" name ="editar" value = "Editar" class="btn brand z-depth-0"> 
           
</form>

<br>
<!--Botão de excluir -->
<form action="adm.php" method="POST" class="center">
    <input type="hidden" name="Id" value = "<?php echo $filme['Id'];?>">
    <input type = "submit" name ="deletar" value = "Deletar" class="btn brand z-depth-0"> 
           
</form>
   
<br>
<!--Botão de adicionar sessão-->
<form action="addsessao.php" method="POST" class="center">
    <input type="hidden" name="Id" value = "<?php echo $filme['Id'];?>">
    <input type = "submit" name ="adses" value = "Adicionar sessão" class="btn brand z-depth-0"> 
           
</form>
 
<?php else: ?>
    <h5>Filme não encontrado. </h5>
<?php endif ?> 

<?php include('templates/footer.php'); ?>

</html>