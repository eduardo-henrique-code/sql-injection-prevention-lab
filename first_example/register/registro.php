<?php

include '../../connection/database_connection.php';
session_start();

$conn = ConexaoBanco();

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$tel = $_POST['telefone'] ?? '';
$nome = $_POST['usuario'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM Usuario WHERE email = '$email'");
$row = mysqli_fetch_assoc($result);

if ($row){
    header('Location: registro.html');
}
else{
    $stmt = mysqli_prepare($conn, "INSERT INTO Usuario (nome, email, senha, telefone) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $senha, $tel);
    mysqli_stmt_execute($stmt);

    header('Location: ../index.php');
    exit();
}

