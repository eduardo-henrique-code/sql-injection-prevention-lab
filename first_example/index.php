<?php

include '../connection/database_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$conn = ConexaoBanco();

$email = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';
$email = is_string($email) ? $email : '';
$senha = is_string($senha) ? $senha : '';

$query = "SELECT * FROM Usuario WHERE email = '$email' AND senha = '$senha'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    session_regenerate_id(true);
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['telefone'] = $row['telefone'];
    $_SESSION['senha_status'] = 'Texto puro — vulnerável';
    $_SESSION['modelo'] = 1;
    unset($_SESSION['senha']);
    header('Location: ../user/user.php');
    exit;
}

header('Location: index.html?erro=credenciais');
exit;
