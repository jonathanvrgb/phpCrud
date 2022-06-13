<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
 if (isset($_GET['id']) && $_GET['id'] != '') 
 {
      $id =  strip_tags($_GET['id']);
      $id = $DBcon->real_escape_string($id);

 $result3 = mysqli_query($DBcon,"SELECT nivel,aluno,idade,peso,altura,7PASS,7PASSusado,mensalidade,statusmensalidade,diapagamento,linkavaliacao,dataavaliacao,profavaliacao,PIC FROM usuarios WHERE id='".$id."'");
 if(mysqli_num_rows($result3)>0)
 {
 $row3 = mysqli_fetch_array($result3);

       $nivel = $row3['nivel'];
       $name = $row3['aluno'];
       $idade = $row3['idade'];
       $peso = $row3['peso'];
       $altura = $row3['altura'];
       $sevenpass = $row3['7PASS'];
       $sevenpassusado = $row3['7PASSusado'];
       $mensalidade = $row3['mensalidade'];
       $statusmensalidade = $row3['statusmensalidade'];
       $diapagamento = $row3['diapagamento'];
       $linkavaliacao = $row3['linkavaliacao'];
       $dataavaliacao = $row3['dataavaliacao'];
       $profavaliacao = $row3['profavaliacao'];
       $mypic = "avalunos/".$row3['PIC'];
       response($nivel,$name,$idade,$peso,$altura,$sevenpass,$sevenpassusado,$mensalidade,$statusmensalidade,$diapagamento,$linkavaliacao,$dataavaliacao,$profavaliacao,$mypic);
    mysqli_close($DBcon);
 }        
 else
 {
   $msg = "error";
    response($msg);
 }
}
 
function response($nivel,$name,$idade,$peso,$altura,$sevenpass,$sevenpassusado,$mensalidade,$statusmensalidade,$diapagamento,$linkavaliacao,$dataavaliacao,$profavaliacao,$mypic)
{
 $response['nivel'] = $nivel;
 $response['name'] = $name;
 $response['idade'] = $idade;
 $response['peso'] = $peso;
 $response['altura'] = $altura;
 $response['sevenpass'] = $sevenpass;
 $response['sevenpassusado'] = $sevenpassusado;
 $response['mensalidade'] = $mensalidade;
 $response['statusmensalidade'] = $statusmensalidade;
 $response['diapagamento'] = $diapagamento;
 $response['linkavaliacao'] = $linkavaliacao;
 $response['dataavaliacao'] = $dataavaliacao;
 $response['profavaliacao'] = $profavaliacao;
 $response['pic'] = $mypic;

 $json_response = json_encode($response);
 echo $json_response;
}
?>