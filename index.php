<?php
		error_reporting(0);
		ini_set('display_errors', 0 );
		include_once "conexao.php";
		$id = $_POST['voto'];

    
  if(!isset ($_GET['sucesso']) == false || $_GET['sucesso'] != '' ) {
    header('refresh:5;url=./'); 
    }
  
    
    $Numsessao = rand(100, 150);
    
session_start();

    $_SESSION['numero'] = $Numsessao;

 ?>


<html>
	<head>
		<title>URNA</title>
	<!-- CSS only -->
<link href="./css/bootstrap5.css" rel="stylesheet" >
<link href="./css/style.css" rel="stylesheet" >
	</head>

	<body>
  
<table align='center'>
  <form action="./" method="POST">
  <?php 

$buscaeleicao = mysqli_query($link, "SELECT count(a.td_id),a.td_id  FROM tb_eleicao as a where a.td_status = 'A' ", MYSQLI_USE_RESULT);

while($dados = mysqli_fetch_array($buscaeleicao)) {
   $verificacao = $dados[0]; 
   $id_eleicao = $dados[1]; 
}


if($verificacao == 0){
  header('refresh:5;url=./'); 
  echo "<table align='center' >
  <tr><td>
      <div class='card text-dark mb-3' style='max-width: 18rem;'>
<div class='card-header'><b>VOTAÇÃO NÃO INICIADA OU ENCERRADA</b></div>
<div class='card-body'>
<img class='card-img-top' src='img/aguarde.gif' alt='NÃO ENCONTRADO' >
  <h5 class='card-title'></h5>
  <p class='card-text'></p>
</div>
</div>
</td>
</tr>
</table>";

  
}
else{
  if(!isset ($_GET['sucesso']) == true || $_GET['sucesso'] == '' ) {
    echo " <tr><td><input type='text' maxlength='3' id='voto' name='voto' pattern='[0-9]{3}' value='$result' autofocus>  <input type='submit' value=''><td></tr>
  <br>";

if(!isset ($id) == true || $id == ''){
  echo "<tr><td>PROCURANDO CANDIDATO...</td></tr>";
}
else{

  
$buscacandidato = mysqli_query($link, "SELECT count(a.td_id), a.* FROM tb_candidatos as a, tb_eleicao as b, tb_eleicand as c where c.td_candidatosid = '$id' and a.td_id_voto = c.td_candidatosid and b.td_id = c.td_eleicaoid and b.td_status = 'A' and a.td_status = 'A' and c.td_status= 'A'", MYSQLI_USE_RESULT);

while($dados = mysqli_fetch_array($buscacandidato)) {
 if($dados[0] == '1'){

  echo "
  <tr><td><div class='card border-success' style='width: 18rem;'>
<img class='card-img-top' src='img/candidatos/$dados[2].png' alt='PERFIL NÃO ENCONTRADO'>
<div class='card-body'>
<h5 class='card-title'>$dados[3]</h5>
<p class='card-text'>$dados[4]</p>

<table align='center'>
  <tr><td><a href='votar.php?ID=$dados[2]&sessao=".$_SESSION['numero']."  ' class='btn btn-primary' aling='center'>CONFIRMAR</a></td></tr>
</table>";

 }
 else{
 
  echo "<tr><td><div class='card border-success' style='width: 18rem;'>
  <div class='card-body'>
  <h5 class='card-title'>CANDIDATO NÃO ENCONTRADO...</h5>
  <p class='card-text'></p>
  ";
 }
}
 
}
  }
  else{
    echo "<tr><td align='center'><div class='card border-success'  style='width: 18rem;'>
    <div class='card-body'>
    <img class='card-img-top' src='img/obrigado.png' alt='NÃO ENCONTRADO' width>
    <h6 class='card-title'>OBRIGADO PELO SEU VOTO !!! </h6>
    <p class='card-text'></p>
    ";
    
  }
}
  
  
   ?> 
</form>
    
  </div>
</div></td></tr>
    </table>


    
	</body>
</html>