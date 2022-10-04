<?php

session_start();
$pagina1 = $_SESSION['numero'];
$pagina2 = $_GET['sessao'];
include_once 'conexao.php';

    $nome = strtoupper($_POST['name']);

if(!isset ($nome) == true || $nome == '' ) {
	header('Location: ./cadastro.php'); 
}

else{
    
    if($pagina1 != $pagina2){
      
        header('Location: ./cadastro.php?r=falhadesessao'); 
         
     }
     else{
         
          
        $inserireleicao = mysqli_query($link, "INSERT INTO tb_eleicao (td_nome, td_status) VALUES ('$nome', 'A' );", MYSQLI_USE_RESULT);
        header('Location: ./cadastro.php?r=sucesso'); 
    }

}
    


    
?>