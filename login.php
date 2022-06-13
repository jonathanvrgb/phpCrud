<?php   
header("Content-Type:application/json");
if (isset($_GET['username']) && $_GET['username'] != '' && isset($_GET['password']) && $_GET['password'] != '') 
{
 include('Dbconnect.php');
 $username =  strip_tags($_GET['username']);
 $password =  strip_tags($_GET['password']);

$username = $DBcon->real_escape_string($username);
$password = $DBcon->real_escape_string($password);

 $result = mysqli_query($DBcon,"SELECT id, usuario, senha,aluno,PIC,idade,peso,altura,7PASS,7PASSusado,mensalidade,statusmensalidade,diapagamento,linkavaliacao,dataavaliacao,profavaliacao FROM usuarios WHERE usuario='$username'");

 if(mysqli_num_rows($result)>0)
 {
 $row = mysqli_fetch_array($result);
 $user_id = $row['id'];
 $user = $row['usuario'];
 $senha = $row['senha'];
 $nome = $row['aluno'];
 $pic = $row['PIC'];
 $idade = $row['idade'];
 $peso = $row['peso'];
 $altura = $row['altura'];
 $sevenpass = $row['7PASS'];
 $sevenpusado = $row['7PASSusado'];
 $mensalidade = $row['mensalidade'];
 $statusm = $row['statusmensalidade'];
 $diapagamento = $row['diapagamento'];
 $linkavaliacao = $row['linkavaliacao'];
 $dataavaliacao = $row['dataavaliacao'];
 $professor = $row['profavaliacao'];

    if (password_verify($password, $senha)) 
    {
    $msg = "loggedin";
    response($user_id,$user,$nome,$pic,$idade,$peso,$altura,$sevenpass,$sevenpassusado,$mensalidade,$statusm,$diapagamento,$linkavaliacao,$dataavaliacao,$professor,$msg);
    mysqli_close($DBcon);
    }
    else
    {
 $user_id = "";
 $user = "";
 $senha = "";
 $nome ="";
 $pic = "";
 $idade ="";
 $peso = "";
 $altura = "";
 $sevenpass = "";
 $sevenpusado = "";
 $mensalidade = "";
 $statusm = "";
 $diapagamento = "";
 $linkavaliacao = "";
 $dataavaliacao = "";
 $professor = "";
$msg = "error";
response($user_id,$user,$nome,$pic,$idade,$peso,$altura,$sevenpass,$sevenpassusado,$mensalidade,$statusm,$diapagamento,$linkavaliacao,$dataavaliacao,$professor,$msg);

    }
 }
 else
 {
 $user_id = "";
 $user = "";
 $senha = "";
 $nome ="";
 $pic = "";
 $idade ="";
 $peso = "";
 $altura = "";
 $sevenpass = "";
 $sevenpusado = "";
 $mensalidade = "";
 $statusm = "";
 $diapagamento = "";
 $linkavaliacao = "";
 $dataavaliacao = "";
 $professor = "";
$msg = "error";
response($user_id,$user,$nome,$pic,$idade,$peso,$altura,$sevenpass,$sevenpassusado,$mensalidade,$statusm,$diapagamento,$linkavaliacao,$dataavaliacao,$professor,$msg);

 }

 }
else
{
 $user_id = "";
 $user = "";
 $senha = "";
 $nome ="";
 $pic = "";
 $idade ="";
 $peso = "";
 $altura = "";
 $sevenpass = "";
 $sevenpusado = "";
 $mensalidade = "";
 $statusm = "";
 $diapagamento = "";
 $linkavaliacao = "";
 $dataavaliacao = "";
 $professor = "";
$msg = "error";
response($user_id,$user,$nome,$pic,$idade,$peso,$altura,$sevenpass,$sevenpassusado,$mensalidade,$statusm,$diapagamento,$linkavaliacao,$dataavaliacao,$professor,$msg);
}
 
function response($user_id,$user,$nome,$pic,$idade,$peso,$altura,$sevenpass,$sevenpassusado,$mensalidade,$statusm,$diapagamento,$linkavaliacao,$dataavaliacao,$professor,$msg)
{
 $response['user_id'] = $user_id;
 $response['user'] = $user;
 $response['name'] = $nome;
 $response['pic'] = $pic;
 $response['idade'] = $idade;
 $response['peso'] = $peso;
 $response['altura'] = $altura;
 $response['sevenpass'] = $sevenpass;
 $response['sevenpassusado'] = $sevenpassusado;
 $response['mensalidade'] = $mensalidade;
 $response['status'] = $statusm;
 $response['diapg'] = $diapagamento;
 $response['link'] = $linkavaliacao;
 $response['data'] = $dataavaliacao;
 $response['professor'] = $professor;
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
}
?>