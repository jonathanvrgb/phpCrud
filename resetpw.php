<?php   
header("Content-Type:application/json");
if (isset($_GET['userid']) && $_GET['userid'] != '' && isset($_GET['password']) && $_GET['password'] != '' && isset($_GET['newpwd']) && $_GET['newpwd'] != '') 
{
 include('Dbconnect.php');
 $username =  strip_tags($_GET['userid']);
 $password =  strip_tags($_GET['password']);
 $newpwd =  strip_tags($_GET['newpwd']);

$username = $DBcon->real_escape_string($username);
$password = $DBcon->real_escape_string($password);
$newpwd = $DBcon->real_escape_string($newpwd);
$hashed_password = password_hash($newpwd, PASSWORD_DEFAULT);

 $result = mysqli_query($DBcon,"SELECT id, usuario, senha FROM usuarios WHERE id='$username'");

 if(mysqli_num_rows($result)>0)
 {
 $row = mysqli_fetch_array($result);
 $user_id = $row['id'];
 $user = $row['usuario'];
 $senha = $row['senha'];

    if (password_verify($password, $senha)) 
    {
      //inicio update
      $query = "UPDATE usuarios SET senha='".$hashed_password."' WHERE id='".$user_id."'";

      if ($DBcon->query($query))
        {
         $msg = "resetpwdok";
         response($msg);
         mysqli_close($DBcon);
      }
      //fim update
    }
    else
    {
      $msg = "error";
    response($msg);
    }
 }
 else
 {
   $msg = "error";
   response($msg);
 }

 }
 
function response($msg)
{
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
}
?>