<?php

include '../connection/database_connection.php';
session_start();

$conn = ConexaoBanco();

$email = $_POST['usuario'];
$senha = $_POST['senha'];

$senha_hash = hash('sha256', $senha);

$stmt = "SELECT * FROM users WHERE email = '$email' AND password = '$senha_hash'";
$result = mysqli_query($conn, $stmt);
$row = mysqli_fetch_assoc($result);

if($row){

    $_SESSION['nome'] = $row['name'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['cpf'] = $row['cpf'];
    $_SESSION['endereco'] = $row['address'];
    $_SESSION['senha'] = $row['password'];
    header('Location: usuario.php');
} else{
    header('Location: index.html');
}

