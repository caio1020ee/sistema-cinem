<?php 


    $sql = "SELECT l.Id_lugar as Id_lugar,L.Id_sessao AS Id_sessao,l.Id_sala as Id_sala,l.Linha as Linha, l.Coluna as Coluna,l.Ocupado as Ocupado,sa.Colunas as Total_colunas, sa.Linhas as Total_linhas FROM lugar l, sala sa WHERE Id_sessao = $Id_sessao AND L.Id_sala = sa.Numero;";
    //echo $sql;   
    $result =  mysqli_query($conn,$sql);
    $lugares = mysqli_fetch_all($result, MYSQLI_ASSOC);

    
    //limpa a memoria de result
    mysqli_free_result($result);

    
    //Sessão
	$sql3 = "SELECT s.Id_sessao AS Codigo, s.Id_sala AS Sala, f.Nome AS Filme, s.Dia AS Dia , s.Hora AS Hora FROM sessao s, filme f WHERE s.Id_filme = f.Id and s.Id_sessao = $Id_sessao;";
	$result3 = mysqli_query($conn,$sql3);
	$sessao = mysqli_fetch_assoc($result3);
    $id_sessao = $sessao['Codigo'];

    $sl = intval($sessao['Sala']);
    

    //Limites de linha e coluna
    $sql2 = "SELECT sala.Colunas as Colunas, sala.Linhas as Linhas FROM sessao, sala WHERE sessao.Id_sala = sala.Numero AND sessao.Id_sala =$sl;";
    $result2 = mysqli_query($conn,$sql2);
    $lc = mysqli_fetch_assoc($result2);
 
    mysqli_free_result($result2);


    
    //mysqli_free_result($result3);
    //fecha conexão
   
























?>