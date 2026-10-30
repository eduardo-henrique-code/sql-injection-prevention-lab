<?php

include '../connection/database_connection.php';
session_start();

$conn = ConexaoBanco();

$email = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

$stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE email = ?');
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_assoc($result);

if($result && password_verify($senha, $result['password'])){

    $_SESSION['nome'] = $result['name'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['cpf'] = $result['cpf'];
    $_SESSION['endereco'] = $result['address'];

    header('Location: usuario.php');
} else{
    header('Location: index.html');
}
