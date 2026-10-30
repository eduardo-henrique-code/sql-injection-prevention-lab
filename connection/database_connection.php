<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function ConexaoBanco(): mysqli
{
      $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
      $Username = $_ENV['DB_USER'] ?? getenv('DB_USER');
      $Password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');
      $Name = $_ENV['DB_NAME'] ?? getenv('DB_NAME');

      return new mysqli(hostname: $host, username: $Username, password: $Password, database: $Name);
}

