<?php   
header("Content-Type:application/json");
if (isset($_GET['username']) && $_GET['username'] != '' && isset($_GET['email']) && $_GET['email'] != '' && isset($_GET['password']) && $_GET['password'] != '' && isset($_GET['gender']) && $_GET['gender'] != '' && isset($_GET['name']) && $_GET['name'] != '' && isset($_GET['zap']) && $_GET['zap'] != '') 
{
 include('Dbconnect.php');
 $nome = strip_tags($_GET['name']);
 $username =  strip_tags($_GET['username']);
 $email =  strip_tags($_GET['email']);
 $password =  strip_tags($_GET['password']);
 $gender =  strip_tags($_GET['gender']);
 $zap = strip_tags($_GET['zap']);
 $sevenpass = strip_tags($_GET['sevenpass']);

 $nome = $DBcon->real_escape_string($nome);
 $username = $DBcon->real_escape_string($username);
 $email = $DBcon->real_escape_string($email);
 $password = $DBcon->real_escape_string($password);
 $gender = $DBcon->real_escape_string($gender);
 $zap = $DBcon->real_escape_string($zap);
 $hashed_password = password_hash($password, PASSWORD_DEFAULT);

 $check_email = $DBcon->query("SELECT EMAIL FROM usuarios WHERE email='$email'");
 $count=$check_email->num_rows;
    
 $check_uname = $DBcon->query("SELECT USUARIO FROM usuarios WHERE usuario='$username'");
 $count2=$check_uname->num_rows;

if($count>0)
{
   response("sem id", "email já existe");
}
else
{
   if($count2>0)
   {
      response("sem id", "usuário já existe");
   }

   else
   {
       
      $sevenpasscode =  "7".strtoupper(substr(md5(rand()), 0, 6));
      $queries = [
         "INSERT INTO usuarios(usuario,email,senha,aluno,genero,whatsapp,7PASS,mensalidade,statusmensalidade,diapagamento) VALUES('$username','$email','$hashed_password','$nome','$gender','$zap','$sevenpasscode','60','Pendente','10')",
         "SELECT id FROM usuarios WHERE usuario=?"
       ];
       
       foreach ($queries as $query) 
       {
        $stmt = $DBcon->prepare($query);
        if(!$stmt)
        {
         $msg = $DBcon->error;
         response($msg);
        }
        
   $stmt->bind_param('s',$username);

   /* execute query */
   $stmt->execute();

   /* Store the result (to get properties) */
   $stmt->store_result();

   /* Get the number of rows */
   $num_of_rows = $stmt->num_rows;

   /* Bind the result to variables */
   $stmt->bind_result($newid);

   while ($stmt->fetch()) 
   {
      $user_id = $newid;
      $msg = "registerok";
   }
   /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
       }
      response($newid,$msg);
      mysqli_close($DBcon);
   }
}

}
 
function response($newid,$msg)
{
 $response['user_id'] = $newid;
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
 
}
?>