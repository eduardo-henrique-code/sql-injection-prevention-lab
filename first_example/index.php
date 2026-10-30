<?php

include '../connection/database_connection.php';
session_start();

$conn = ConexaoBanco();

$email = $_POST['usuario'];
$senha = $_POST['senha'];

$stmt = "SELECT * FROM Usuario WHERE email = '$email' AND senha = '$senha'";
$result = mysqli_query($conn, $stmt);
$row = mysqli_fetch_assoc($result);

if($row){

    $_SESSION['nome'] = $row['name'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['cpf'] = $row['cpf'];
    $_SESSION['senha'] = $row['password'];
    header('Location: usuario.php');
} else{
    header('Location: index.html');
}

