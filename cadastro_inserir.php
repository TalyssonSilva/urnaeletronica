<?php


session_start();
$pagina1 = $_SESSION['numero'];
$pagina2 = $_GET['sessao'];
include_once 'conexao.php';

    $nome = strtoupper($_POST['name']);
    $numero = $_POST['numero'];
    $funcao = strtoupper($_POST['funcao']);

if(!isset ($nome) == true || $nome == '' || !isset ($numero) == true || $numero == '' ||  !isset ($funcao ) == true || $funcao == '' ) {
	
    $num = $_GET['f'];
    $voto = $_GET['id'];
    $eleicao = $_GET['elei'];
    if($num == 1  ){
        
    $buscacandidato = mysqli_query($link, "SELECT count(*) FROM tb_eleicand as a where a.td_candidatosid = '$voto' and a.td_eleicaoid = '$eleicao' and a.td_status = 'I' ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscacandidato)) {
       $verificacao = $dados[0]; 
    }

    if($verificacao == 1){
        $buscacandidato = mysqli_query($link, "UPDATE tb_eleicand SET td_status = 'A' WHERE td_candidatosid = '$voto' and td_eleicaoid = '$eleicao'", MYSQLI_USE_RESULT);
    }
    else{
        $buscacandidato = mysqli_query($link, "INSERT INTO tb_eleicand (td_candidatosid,td_eleicaoid) VALUES ('$voto','$eleicao' );", MYSQLI_USE_RESULT);
        $votar = mysqli_query($link, "INSERT INTO tb_votacao (td_candidatos,td_eleicao,td_voto) VALUES ('$voto','$eleicao','0');", MYSQLI_USE_RESULT);
    }

        


    }
    else if($num == 2 ){
        $buscacandidato = mysqli_query($link, "UPDATE tb_eleicand SET td_status = 'I' WHERE td_candidatosid = '$voto' and td_eleicaoid = '$eleicao'", MYSQLI_USE_RESULT);
    } 
    header('Location: ./cadastro.php'); 
}

else{
    

    $buscacandidato = mysqli_query($link, "SELECT count(a.td_id)  FROM tb_candidatos as a where a.td_id_voto = '$numero' ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscacandidato)) {
       $verificacao = $dados[0]; 
    }


    if( $verificacao == '1' && $pagina1 == $pagina2){
      
       header('Location: ./cadastro.php?r=falhadesessao'); 
        
    }
    else{
        if(isset($_FILES['imagem']['name'])){

            $extensao = strtolower(substr($_FILES['imagem']['name'], -4)); //pega a extensao do arquivo
            $novo_nome = $numero . $extensao; //define o nome do arquivo
            $diretorio = "./img/candidatos/"; //define o diretorio para onde enviaremos o arquivo
           
         
         
        
            move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome); //efetua o upload
            header('Location: ./cadastro.php?r=sucesso'); 
            
            $buscacandidato = mysqli_query($link, "INSERT INTO tb_candidatos (td_id_voto,td_nome, td_funcao) VALUES ('$numero','$nome', '$funcao' );", MYSQLI_USE_RESULT);


        }
        else{
            header('Location: ./cadastro.php?r=falhaaomover'); 
        }
    }
}


?>