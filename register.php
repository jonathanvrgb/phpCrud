<?php

// Set the response header to indicate JSON content
header("Content-Type: application/json");

// Check if all required parameters are set and not empty
if (isset($_GET['username'], $_GET['email'], $_GET['password'], $_GET['gender'], $_GET['name'], $_GET['zap'])
    && $_GET['username'] !== '' && $_GET['email'] !== '' && $_GET['password'] !== ''
    && $_GET['gender'] !== '' && $_GET['name'] !== '' && $_GET['zap'] !== '') 
{
    // Include the database connection file
    include 'Dbconnect.php';

    // Get the values of the parameters
    $nome = $_GET['name'];
    $username = $_GET['username'];
    $email = $_GET['email'];
    $password = $_GET['password'];
    $gender = $_GET['gender'];
    $zap = $_GET['zap'];

    // Check if the email already exists in the database
    $stmt = $DBcon->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $emailExists = $stmt->num_rows > 0;
    $stmt->close();

    // Check if the username already exists in the database
    $stmt = $DBcon->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $usernameExists = $stmt->num_rows > 0;
    $stmt->close();

    // Handle email and username existence cases
    if ($emailExists) 
    {
        response("sem id", "Email already exists");
    } 
    elseif ($usernameExists) 
    {
        response("sem id", "Username already exists");
    } 
    else 
    {
        // Insert a new user into the database
        $stmt = $DBcon->prepare("INSERT INTO usuarios(usuario, email, senha, aluno, genero, whatsapp, mensalidade, statusmensalidade, diapagamento) VALUES(?, ?, ?, ?, ?, ?, '60', 'Pendente', '10')");

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind the parameters to the prepared statement
        $stmt->bind_param('ssssss', $username, $email, $hashedPassword, $nome, $gender, $zap);
        $stmt->execute();
        $stmt->close();

        // Get the ID of the inserted user
        $newid = $DBcon->insert_id;

        // Send a success response
        response($newid, "registerok");

        // Close the database connection
        mysqli_close($DBcon);
    }
} 
else 
{
    // Handle missing parameters or empty values
    $msg = "error";
    response("sem id", $msg);
}

// Function to generate and send the response in JSON format
function response($newid, $msg)
{
    $response = [
        'user_id' => $newid,
        'msg' => $msg
    ];

    $json_response = json_encode($response);
    echo $json_response;
}
?>
