<?php
error_reporting(0);
ini_set('display_errors', 0 );
include_once 'conexao.php';

$num_eleicao = $_GET['E'];

if(!isset ($num_eleicao) == true ){
    $buscaeleicao = mysqli_query($link, "SELECT count(a.td_id),a.td_id, a.td_nome  FROM tb_eleicao as a where a.td_status = 'A' ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscaeleicao)) {
       $verificacao = $dados[0]; 
       $id_eleicao = $dados[1]; 
       $nome_eleicao = $dados[2];
       
       $tab_status = "and c.td_status ='A'";
       $tab_eleicao = "";
    }
}
else{
    $buscaeleicao = mysqli_query($link, "SELECT count(a.td_id),a.td_id, a.td_nome  FROM tb_eleicao as a where a.td_id = '$num_eleicao' ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscaeleicao)) {
       $verificacao = $dados[0]; 
       $id_eleicao = $dados[1]; 
       $nome_eleicao = $dados[2];

       $tab_status = "";
       $tab_eleicao = "and c.td_id = ' $id_eleicao'";
    }
}
    

    $Numsessao = rand(100, 150);
    
    session_start();
    
        $_SESSION['numero'] = $Numsessao;

    
?>
<html>
<script src="./js/highcharts.js"></script>
<script src="./js/data.js"></script>
<script src="./js/drilldown.js"></script>
<script src="./js/exporting.js"></script>
<script src="./js/export-data.js"></script>
<script src="./js/accessibility.js"></script>

<link href="./css/bootstrap5.css" rel="stylesheet" >
<link href="./css/style.css" rel="stylesheet" >
<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

#containera {
    height: 400px;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

		</style>
<body>
<figure class="highcharts-figure">
    <div id="container">

    <script>
        Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        align: 'left',
       <?php echo "text: 'RESULTADO DA VOTACAO $nome_eleicao, ".date('Y')."'"; ?>
    },
    subtitle: {
        align: 'left',
        text: '<a href="./" target="_blank">Pagina de votacao</a>'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total de votos'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> votos<br/>'
    },

    series: [
        {
            name: "Votos",
            colorByPoint: true,
            data: [
                <?php

                    

                    $buscacandidato = mysqli_query($link, "SELECT a.td_id_voto, a.td_nome, a.td_funcao ,SUM(b.td_voto), c.td_id FROM tb_candidatos as a, tb_votacao as b, tb_eleicao as c, tb_eleicand as d where a.td_id_voto = b.td_candidatos $tab_status  and c.td_id=b.td_eleicao $tab_eleicao and d.td_eleicaoid = c.td_id and d.td_candidatosid = a.td_id_voto and d.td_status = 'A' GROUP by a.td_id_voto;", MYSQLI_USE_RESULT);

                    while($dados = mysqli_fetch_array($buscacandidato)) {
                      
                    
                    echo " {
                        name: '$dados[0] - ".substr($dados[1], 0, 10)." ',
                        y: $dados[3],
                        
                    },";
                    
                    }

                    
                ?>
               
            ]
        }
    ]
});

</script>
    </div>
    
</figure>

<table align='center' >
    <tr>
<td><a link href='./admin.php' style="text-decoration:none"><div class="card text-dark bg-info mb-3" style="max-width: 18rem;">
  <div class="card-header"><b>Voltar</b></div>
 
</div></a></td>
<td><div class="card text-dark bg-info mb-3" style="max-width: 18rem;">
<div class="card-header"><select class="form-select" aria-label="Default select example" onchange="location = this.value;" >
  <option selected><?php echo $nome_eleicao;?></option>
    <?php
    
    $buscaeleicaoselec = mysqli_query($link, "SELECT a.td_id, a.td_nome  FROM tb_eleicao as a ", MYSQLI_USE_RESULT);

    while($dados = mysqli_fetch_array($buscaeleicaoselec)) {
       
       echo "<option value='resultado.php?E=$dados[0]'>$dados[1]</a></option>";
       
    }


    ?>
</select></div></div></td>
<td><div class="card-header"><a link <?php echo "href='./encerrar_votacao.php?sessao=$Numsessao&f=1&enc=$id_eleicao'";?> style="text-decoration:none"><div class="card text-dark bg-info mb-3" style="max-width: 18rem;">

  <div class="card-header"><b> ENCERRAR VOTACAO</div></div></b></div>
 
</div></a></td></tr>
</table>
</body>
</html>