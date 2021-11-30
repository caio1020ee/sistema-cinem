<!DOCTYPE html>
<link rel="stylesheet" href="estilos/estilo.css">

<style>
    .item{
        color:black; width:300px; height:45px; border: 1px solid; border-color:black;
    }
</style>
<?php include('templates/header.php'); ?>

<h3 class="center-align" style="color: red;">Administração</h3>

<!--Lista de filmes-->
<div class="center-align">
   
    <a href="listafilmesadm.php">
       <div  class="center-align btn yellow" style="color:black; width:300px; height:45px; border: 1px solid; border-color:black; ">Lista de filmes</div>
    </a>

</div>

<!--Lista de sessões-->
<div class="center-align">
   
    <a href="listadesessoes.php">
       <div  class="center-align btn yellow" style="color:black; width:300px; height:45px; border: 1px solid; border-color:black; ">Lista de sessões</div>
    </a>

</div>

<!--Lista de salas-->
<div class="center-align">
   
    <a href="lista_salas_adm.php">
       <div  class="center-align btn yellow" style="color:black; width:300px; height:45px; border: 1px solid; border-color:black; ">Lista de salas</div>
    </a>

</div>


 

<?php include('templates/footer.php'); ?>

</html>