<?php

require_once '../../connection/database_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.html');
    exit;
}

$conn = ConexaoBanco();

$email = $_POST['email'] ?? null;
$senha = $_POST['senha'] ?? null;
$tel = $_POST['telefone'] ?? null;
$nome = $_POST['usuario'] ?? null;

if (!is_string($email) || !is_string($senha) || !is_string($tel) || !is_string($nome)) {
    header('Location: register.html?erro=dados');
    exit;
}

$email = trim($email);
$tel = trim($tel);
$nome = trim($nome);

if ($nome === '' || $tel === '' || $senha === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: register.html?erro=dados');
    exit;
}

$check = mysqli_prepare($conn, 'SELECT email FROM Usuario WHERE email = ?');
mysqli_stmt_bind_param($check, 's', $email);
mysqli_stmt_execute($check);
$exists = mysqli_stmt_get_result($check)->fetch_assoc();
mysqli_stmt_close($check);

if ($exists) {
    header('Location: register.html?cadastro=duplicado');
    exit;
}

$stmt = mysqli_prepare($conn, 'INSERT INTO Usuario (nome, email, senha, telefone) VALUES (?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'ssss', $nome, $email, $senha, $tel);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header('Location: ../index.html?cadastro=sucesso');
exit;
