<?php


session_start();
$pagina1 = $_SESSION['numero'];
$pagina2 = $_GET['sessao'];
include_once 'conexao.php';

    $id = $_GET['ID'];

if(!isset ($_GET['ID']) == true || $_GET['ID'] == '' ) {
	header('Location: ./'); 
}

else{
    
    $id = $_GET['ID'];

    $buscacandidato = mysqli_query($link, "SELECT count(a.td_id)  FROM tb_candidatos as a where a.td_id_voto = '$id' ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscacandidato)) {
       $verificacao = $dados[0]; 
    }

    $buscaeleicao = mysqli_query($link, "SELECT count(a.td_id),a.td_id, a.td_nome  FROM tb_eleicao as a where a.td_status = 'A' ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscaeleicao)) {
       $verificacao = $dados[0]; 
       $id_eleicao = $dados[1]; 
       $nome_eleicao = $dados[2];
    }



    if( $verificacao == '1' && $pagina1 == $pagina2){
        $votar = mysqli_query($link, "INSERT INTO tb_votacao (td_candidatos,td_eleicao) VALUES ('$id','$id_eleicao');", MYSQLI_USE_RESULT);
        header('Location: ./?sucesso=1'); 
       
    }
    else{
        
        header('Location: ./'); 
    }
}


?>