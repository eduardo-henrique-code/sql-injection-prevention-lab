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

$stmt = mysqli_prepare($conn, 'SELECT * FROM Usuario WHERE email = ?');
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($row && password_verify($senha, $row['senha'])) {
    session_regenerate_id(true);
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['telefone'] = $row['telefone'];
    $_SESSION['senha_status'] = 'Hash de senha (password_hash)';
    $_SESSION['modelo'] = 3;
    unset($_SESSION['senha']);
    header('Location: ../user/user.php');
    exit;
}

header('Location: index.html?erro=credenciais');
exit;
