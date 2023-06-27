<?php

header("Content-Type: application/json");

include 'Dbconnect.php';

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = strip_tags($_GET['id']);
    $id = $DBcon->real_escape_string($id);

    $query = "SELECT nivel, aluno, idade, peso, altura, 7PASS, 7PASSusado, mensalidade, statusmensalidade, diapagamento, linkavaliacao, dataavaliacao, profavaliacao, PIC FROM usuarios WHERE id = '$id'";
    $result = mysqli_query($DBcon, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $nivel = $row['nivel'];
        $name = $row['aluno'];
        $idade = $row['idade'];
        $peso = $row['peso'];
        $altura = $row['altura'];
        $sevenpass = $row['7PASS'];
        $sevenpassusado = $row['7PASSusado'];
        $mensalidade = $row['mensalidade'];
        $statusmensalidade = $row['statusmensalidade'];
        $diapagamento = $row['diapagamento'];
        $linkavaliacao = $row['linkavaliacao'];
        $dataavaliacao = $row['dataavaliacao'];
        $profavaliacao = $row['profavaliacao'];
        $mypic = "avalunos/" . $row['PIC'];

        response($nivel, $name, $idade, $peso, $altura, $sevenpass, $sevenpassusado, $mensalidade, $statusmensalidade, $diapagamento, $linkavaliacao, $dataavaliacao, $profavaliacao, $mypic);

        mysqli_free_result($result);
    } else {
        $msg = "error";
        response($msg);
    }

    mysqli_close($DBcon);
}

function response($nivel, $name, $idade, $peso, $altura, $sevenpass, $sevenpassusado, $mensalidade, $statusmensalidade, $diapagamento, $linkavaliacao, $dataavaliacao, $profavaliacao, $mypic)
{
    $response = [
        'nivel' => $nivel,
        'name' => $name,
        'idade' => $idade,
        'peso' => $peso,
        'altura' => $altura,
        'sevenpass' => $sevenpass,
        'sevenpassusado' => $sevenpassusado,
        'mensalidade' => $mensalidade,
        'statusmensalidade' => $statusmensalidade,
        'diapagamento' => $diapagamento,
        'linkavaliacao' => $linkavaliacao,
        'dataavaliacao' => $dataavaliacao,
        'profavaliacao' => $profavaliacao,
        'pic' => $mypic,
    ];

    $json_response = json_encode($response);
    echo $json_response;
}