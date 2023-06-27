<?php

// Set the response header to indicate JSON content
header("Content-Type: application/json");

// Check if all required parameters are set and not empty
if (isset($_GET['userid'], $_GET['password'], $_GET['newpwd']) && $_GET['userid'] !== '' && $_GET['password'] !== '' && $_GET['newpwd'] !== '') 
{
    // Include the database connection file
    include 'Dbconnect.php';

    // Get the values of the parameters
    $username = $_GET['userid'];
    $password = $_GET['password'];
    $newpwd = $_GET['newpwd'];

    // Escape the user input to prevent SQL injection
    $username = $DBcon->escape_string($username);
    $password = $DBcon->escape_string($password);
    $newpwd = $DBcon->escape_string($newpwd);

    // Hash the new password for security
    $hashedPassword = password_hash($newpwd, PASSWORD_DEFAULT);

    // Prepare the statement to retrieve user information based on username
    $stmt = $DBcon->prepare("SELECT id, usuario, senha FROM usuarios WHERE id = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $user = $row['usuario'];
        $senha = $row['senha'];

        if (password_verify($password, $senha)) 
        {
            // Prepare the statement to update the password
            $stmt = $DBcon->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
            $stmt->bind_param('ss', $hashedPassword, $user_id);
            if ($stmt->execute())
            {
                $msg = "resetpwdok";
                response($msg);
                $stmt->close();
                mysqli_close($DBcon);
                exit;
            }
        } 
    }
    
    $msg = "error";
    response($msg);
    $stmt->close();
    mysqli_close($DBcon);
    exit;
}
 
function response($msg)
{
    $response['msg'] = $msg;
    $json_response = json_encode($response);
    echo $json_response;
}
?>
