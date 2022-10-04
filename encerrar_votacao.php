<?php $link = mysqli_connect("localhost", "root", "", "eleicao"); 


session_start();
$pagina1 = $_SESSION['numero'];
$pagina2 = $_GET['sessao'];
$eleicao = $_GET['enc'];
$verificacao = $_GET['f'];
include_once 'conexao.php';


if( $verificacao == '1' && $pagina1 == $pagina2){
    $votar = mysqli_query($link, "UPDATE tb_eleicao SET td_status = 'I' WHERE td_id = '$eleicao';", MYSQLI_USE_RESULT);
    header('Location: ./resultado.php?sucesso=1'); 
   
}
else{
    header('Location: ./resultado.php'); 
}

?> 
