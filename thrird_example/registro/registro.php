<?php 
include '../../connection/database_connection.php';
session_start();

$conn = ConexaoBanco();

$email = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';
$tel = $_POST['telefone'] ?? '';
$nome = $_POST['nome'] ?? '';

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row){
    header('Location: registro.html');
}
else{
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (nome, email, senha, telefone) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $senha_hash, $tel);
    mysqli_stmt_execute($stmt);

    header('Location: ../index.php');
    exit();
}

