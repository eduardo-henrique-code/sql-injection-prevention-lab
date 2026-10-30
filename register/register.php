<?php 

include '../connection/database_connection.php';
session_start();
$conn = ConexaoBanco();

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$tel = $_POST['telefone'] ?? '';
$nome = $_POST['usuario'] ?? '';
$motivo = $_POST['motivo'] ?? '';
$gerarHash = ['secondModel', 'thrirdModel'];


$result = mysqli_query($conn, "SELECT * FROM Usuario WHERE email = '$email'");
$row = mysqli_fetch_assoc($result);

if ($row){
    header('Location: register.html');
}

if(in_array($motivo, $gerarHash)){
    $senha = password_hash($senha, PASSWORD_DEFAULT);
}

$stmt = mysqli_prepare($conn, "INSERT INTO Usuario (nome, email, senha, telefone) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $senha, $tel);
mysqli_stmt_execute($stmt);


header('Location: ../index.php');
exit();
