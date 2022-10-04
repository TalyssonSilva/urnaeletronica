<?php
		error_reporting(0);
		ini_set('display_errors', 0 );
		include_once "conexao.php";
		$Numsessao = rand(100, 150);
    
session_start();

    $_SESSION['numero'] = $Numsessao;

 ?>


<html>
	<head>
		<title>URNA</title>
	<!-- CSS only -->
    <link href="./css/bootstrap5.css" rel="stylesheet" >
    <link href="./css/style2.css" rel="stylesheet" >
	</head>

	<body>
    <?php 
    
    $buscaeleicao = mysqli_query($link, "SELECT count(a.td_id),a.td_id, a.td_nome  FROM tb_eleicao as a where a.td_status = 'A' ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscaeleicao)) {
       $verificacao = $dados[0]; 
       $id_eleicao = $dados[1]; 
       $nome_eleicao = $dados[2];
    }
    
    
    if($verificacao == 0){
      echo "<form action='./criar_eleicao.php?sessao=$Numsessao' method='POST' enctype='multipart/form-data'>
        
      <table align='center' >
      <tr><td  colspan='3' ><h5> CRIAR ELEICAO:</h5></td></tr>
      <tr> <td  colspan='3'>
          
          <div class='form-floating mb-3'>
        <input type='text' class='form-control' id='nome' name='name' maxlength='60' pattern='[A-Za-z 0-9]{4,20}' autofocus required>
        <label for='floatingInput'>Nome completo</label>
      </div>
      
      </tr>
      <tr  colspan='3'>
        <td align='left'><br><a link href='admin.php' class='btn btn-primary' value='' >VOLTAR</a></td>
        
        <td align='right'><br><input type='submit' class='btn btn-primary' value='CONFIRMAR ' ></td></tr>
      
      </table></form>";


    }
    else{
      echo "<div class='card text-center'>
      <div class='card-header'>
      LISTAGEM DE CANDIDATOS CADASTRADOS EM <font color='red'><b>$nome_eleicao</b></font> 
      </div>
      <div class='card-body' style='
      max-height: clamp(5em,50vh,400px);
      overflow: auto;'>
        
          <table class='table table-bordered table-striped table-hover ' align='center' >
      <thead class='bg-white'>"; #classe sticky-top para fixar
          
      echo "<tr>
          <th scope='col'>#</th>
          <th scope='col'>CODIGO</th>
          <th scope='col'>NOME</th>
          <th scope='col'>FUNCAO</th>
          <th scope='col'>#</th>
        </tr>
      </thead>
      <tbody>";
        
        
        $buscacandidato = mysqli_query($link, "SELECT a.td_id_voto, a.td_nome, a.td_funcao, c.td_candidatosid, b.td_id from tb_candidatos as a, tb_eleicao as b, tb_eleicand as c where a.td_id_voto = c.td_candidatosid and b.td_id = c.td_eleicaoid and b.td_status = 'A' and c.td_status = 'A' group by a.td_id_voto;", MYSQLI_USE_RESULT);
        $linha = 0;
        while($dados = mysqli_fetch_array($buscacandidato)) {
           $numerodovoto = $dados[0]; 
           $nome = $dados[1]; 
           $funcao = $dados[2]; 
           $eleicao = $dados[4]; 
    
          $linha = $linha + 1;
           echo "<tr>
           <th scope='row'>$linha</th>
           <td>$numerodovoto</td>
           <td>$nome </td>
           <td>$funcao</td>
           <td align='center'><b><a href='cadastro_inserir.php?id=$numerodovoto&f=2&elei=$id_eleicao' style='text-decoration:none; color:red;'>-</a></b></td>
         </tr>";
        }
    
      
     echo"  </tbody> 
     </table></div>
      <div class='card-footer text-muted'>
      <a link href='admin.php' class='btn btn-primary' value='' >VOLTAR</a>
      <a link href='#exampleModalToggle1' data-bs-toggle='modal' role='button' class='btn btn-primary' value='' >CANDIDATOS CADASTRADOS</a>
      <a link href='#exampleModalToggle' data-bs-toggle='modal' role='button' class='btn btn-primary' value='' >CADASTRAR</a>
      </div>
    </div>";
    }    
    ?>
    
 
 

<script>
  var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">LISTAGEM DE CANDIDATOS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        echo "<form action='./cadastro_inserir.php?sessao=$Numsessao' method='POST' enctype='multipart/form-data'>
        
        <table align='center' >
        <tr><td  colspan='3' ><h5> CADASTRO DE CANDIDATOS:</h5></td></tr>
        <tr> <td  colspan='3'>
            <div class='form-floating mb-3'>
            <input type='text' class='form-control' id='numero' name='numero' maxlength='3' pattern='[0-9]{3}' autofocus  required>
          <label for='floatingInput'>Numero</label>
        </div>
            <div class='form-floating mb-3'>
          <input type='text' class='form-control' id='nome' name='name' maxlength='60' pattern='[A-Za-z ]{10,60}' autofocus required>
          <label for='floatingInput'>Nome completo</label>
        </div>
        <div class='form-floating'>
          <input type='text' class='form-control' id='funcao' name='funcao' maxlength='25' pattern='[A-Za-z]+{2,25}' autofocus required>
          <label for='floatingPassword'>Função</label>
        </div>
        <div class='mb-3'>
          <br>
          <input class='form-control' type='file' id='imagem' name='imagem'  >
        </div>
        </td>
        </tr>
        <tr  colspan='3'>
          <td align='left'><br></td>
          <td align='center'><br></td>
          <td align='right'><br><input type='submit' class='btn btn-primary' value='CONFIRMAR ' ></td></tr>
        
        </table></form>";
        ?>

      
      </div>
      <div class="modal-footer">
        
      

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalToggle1" aria-hidden="true" aria-labelledby="exampleModalToggle1Label" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggle1Label">LISTAGEM DE CANDIDATOS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
       echo "
       <table class='table table-bordered table-striped table-hover ' align='center' >
       <thead class='bg-white'>"; #classe sticky-top para fixar
           
       echo "<tr>
           <th scope='col'>#</th>
           <th scope='col'>CODIGO</th>
           <th scope='col'>NOME</th>
           <th scope='col'>FUNCAO</th>
           <th scope='col'></th>
         </tr>
       </thead>
       <tbody>";
         
         
         $buscacandidato = mysqli_query($link, "SELECT a.td_id_voto, a.td_nome, a.td_funcao FROM tb_candidatos as a WHERE a.td_status = 'A' and a.td_id_voto NOT IN ( SELECT a.td_id_voto FROM tb_candidatos as a, tb_eleicao as b, tb_eleicand as c WHERE a.td_id_voto = c.td_candidatosid and b.td_id = c.td_eleicaoid and b.td_status = 'A' and c.td_status = 'A'  group by a.td_id_voto );", MYSQLI_USE_RESULT);
         $linha = 0;
         while($dados = mysqli_fetch_array($buscacandidato)) {
            $numerodovoto = $dados[0]; 
            $nome = $dados[1]; 
            $funcao = $dados[2]; 
     
           $linha = $linha + 1;
            echo "<tr>
            <th scope='row'>$linha</th>
            <td>$numerodovoto</td>
            <td>$nome </td>
            <td>$funcao</td>
            <td><a href='cadastro_inserir.php?id=$numerodovoto&f=1&elei=$id_eleicao' class='btn btn-primary' value=''>+</a></td>
          </tr>";
         }
     
       
      echo"  </tbody> 
      </table></div>";

        ?>

      
      </div>
   
    </div>
  </div>
</div>




	</body>
</html>