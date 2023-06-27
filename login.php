<?php

header("Content-Type: application/json");

if (isset($_GET['username'], $_GET['password']) && $_GET['username'] !== '' && $_GET['password'] !== '') {
    include 'Dbconnect.php';

    $username = strip_tags($_GET['username']);
    $password = strip_tags($_GET['password']);

    $username = $DBcon->real_escape_string($username);
    $password = $DBcon->real_escape_string($password);

    $query = "SELECT id, usuario, senha, aluno, PIC, idade, peso, altura, 7PASS, 7PASSusado, mensalidade, statusmensalidade, diapagamento, linkavaliacao, dataavaliacao, profavaliacao FROM usuarios WHERE usuario='$username'";
    $result = mysqli_query($DBcon, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
        $user = $row['usuario'];
        $senha = $row['senha'];
        $nome = $row['aluno'];
        $pic = $row['PIC'];
        $idade = $row['idade'];
        $peso = $row['peso'];
        $altura = $row['altura'];
        $sevenpass = $row['7PASS'];
        $sevenpassusado = $row['7PASSusado'];
        $mensalidade = $row['mensalidade'];
        $statusm = $row['statusmensalidade'];
        $diapagamento = $row['diapagamento'];
        $linkavaliacao = $row['linkavaliacao'];
        $dataavaliacao = $row['dataavaliacao'];
        $professor = $row['profavaliacao'];

        if (password_verify($password, $senha)) {
            $msg = "loggedin";
            response($user_id, $user, $nome, $pic, $idade, $peso, $altura, $sevenpass, $sevenpassusado, $mensalidade, $statusm, $diapagamento, $linkavaliacao, $dataavaliacao, $professor, $msg);
        } else {
            $msg = "error";
            response("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $msg);
        }

        mysqli_free_result($result);
    } else {
        $msg = "error";
        response("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $msg);
    }

    mysqli_close($DBcon);
} else {
    $msg = "error";
    response("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $msg);
}

function response($user_id, $user, $nome, $pic, $idade, $peso, $altura, $sevenpass, $sevenpassusado, $mensalidade, $statusm, $diapagamento, $linkavaliacao, $dataavaliacao, $professor, $msg)
{
    $response = [
        'user_id' => $user_id,
        'user' => $user,
        'name' => $nome,
        'pic' => $pic,
        'idade' => $idade,
        'peso' => $peso,
        'altura' => $altura,
        'sevenpass' => $sevenpass,
        'sevenpassusado' => $sevenpassusado,
        'mensalidade' => $mensalidade,
        'status' => $statusm,
        'diapg' => $diapagamento,
        'link' => $linkavaliacao,
        'data' => $dataavaliacao,
        'professor' => $professor,
        'msg' => $msg
    ];

    $json_response = json_encode($response);
    echo $json_response;
}
