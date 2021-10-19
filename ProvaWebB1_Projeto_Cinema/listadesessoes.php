<?php
include('config/conexao.php');

//Verificando se o parâmetro Nome foi enviado pelo get_browser



//-----------------Sessões-------------------
$se_sql = "SELECT s.Id_sessao AS Codigo, s.Id_sala AS Sala, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora FROM sessao s, filme f WHERE s.Id_filme = f.Id GROUP BY s.Id_sessao;";
$se_result = mysqli_query($conn,$se_sql);
$sessoes =  mysqli_fetch_all($se_result, MYSQLI_ASSOC);//Mais de 1 linha
mysqli_free_result($se_result);


//echo $sessoes;
    
mysqli_close($conn);


?>

<!DOCTYPE html>

<?php include('templates/header.php'); ?>

<!--Editar e excluir filme-->
<h3 class="center-align">Lista de sessões</h3>

<br>
<!---------------------------->

<?php if($sessoes): ?>

    <?php foreach ($sessoes as $sessao) {?>
        <div class="center-align"style="padding-left: 50px; padding-right:50px">
   
        <a href="sessao_adm.php?Id_sessao=<?php echo htmlspecialchars($sessao['Codigo'])?>">
            <div  class=" column card-content left-align red" style="background-color:red;  border: 1px solid; border-color:black;  ">
<pre style="color: black;">
 Id: <?php echo htmlspecialchars($sessao['Codigo'])?>   
 Sala <?php echo htmlspecialchars($sessao['Sala'])?> 
 Filme: <?php echo htmlspecialchars($sessao['Filme'])?> 
 Dia: <?php echo htmlspecialchars($sessao['Dia'])?> 
 Hora: <?php echo htmlspecialchars($sessao['Hora'])?> 
</pre>            

           
            </div>
        </a>

        </div>
        <br>

    <?php } ?>    
     

<?php else: ?>

    <div class="center-align"style="padding-left: 50px; padding-right:50px">
   
        <div  class="center-align btn red" style="background-color:red; width:300px; height:45px; border: 1px solid; border-color:black; ">Não há sessões!</div>
    
    </div>

<?php endif ?>    

<?php include('templates/footer.php'); ?>

</html>