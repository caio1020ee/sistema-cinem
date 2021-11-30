<?php
include('config/conexao.php');



//Verificando se o parâmetro Nome foi enviado pelo get_browser
if(isset($_GET['Id_sessao'])){
    //Limpa os dados de sql injection
    
    $Id_sessao = mysqli_real_escape_string($conn,$_GET['Id_sessao']);


    //Monta a query
	$sql = "SELECT s.Id_sessao AS Codigo, s.Id_sala AS Sala, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora FROM sessao s, filme f WHERE s.Id_filme = f.Id and s.Id_sessao = $Id_sessao;";
    
    //Executa a query e guarda em $result
	$result = mysqli_query($conn,$sql);
    

    //Busca o resultado (uma linha) em forma de vetor
	$sessao = mysqli_fetch_assoc($result);

    //-------------------------------------------
   


    
    
    mysqli_free_result($result);
    mysqli_close($conn);
    
}else{
    //echo 'Erro';
}

//Deletar sessao do banco de dados
if(isset($_POST['deletar'])){
    //Limpando a query
    $Id_sessao = mysqli_real_escape_string($conn,$_POST['Id_sessao']);
 
    //Montando a query
    $sql = "DELETE FROM sessao WHERE Id_sessao = $Id_sessao";
    $del_lugares = "DELETE FROM lugar WHERE Id_sessao = $Id_sessao;";
    
 
    //Removendo do BD
    if(mysqli_query($conn,$del_lugares)){
    if(mysqli_query($conn,$sql) ){
        //Sucesso
        header('Location: listadesessoes.php');
    }else{
        //echo 'query error Deletar sessões'.mysqli_error($conn);
    }
    }else{
        //echo'No deletar de lugares';
    }
 
 }

?>

<!DOCTYPE html>
<link rel="stylesheet" href="estilos/estilo.css">
<?php include('templates/header.php'); ?>

<div style="padding-left: 50px; padding-right: 50px;  padding-top:30px">
<div class="center-align"style="padding-left: 50px; padding-right:50px">
   

       <div  class=" column card-content left-align red sessao" >
<pre style="color: black;">
Id: <?php echo htmlspecialchars($sessao['Codigo'])?>   
Sala <?php echo htmlspecialchars($sessao['Sala'])?> 
Filme: <?php echo htmlspecialchars($sessao['Filme'])?> 
Dia: <?php echo htmlspecialchars($sessao['Dia'])?> 
Hora: <?php echo htmlspecialchars($sessao['Hora'])?> 
</pre>            

      
       </div>


   </div>
<br>

<!--Botôes-->
<div class="center-align flexea"  >            
        
<!--Botão de editar-->
    <form action="editar_sessao.php" method="POST" class="center" >
       <input type="hidden" name="Id_sessao" value = "<?php echo $sessao['Codigo'];?>">
       <input type = "submit" name ="editar" value = "Editar" class="btn green  z-depth-0"> 
            
    </form> 

    <!--Botão de excluir -->
    <form action="sessao_adm.php" method="POST" class="center" >
        <input type="hidden" name="Id_sessao" value = "<?php echo $sessao['Codigo'];?>">
        <input type = "submit" name ="deletar" value = "Deletar" class="btn red z-depth-0"> 
    </form>  
</div>  
</div>




<?php include('templates/footer.php'); ?>

</html>