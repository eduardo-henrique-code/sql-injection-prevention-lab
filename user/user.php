<?php
require_once __DIR__ . '/../connection/database_connection.php';

session_start();

if (empty($_SESSION['nome']) || empty($_SESSION['email']) || empty($_SESSION['telefone'])) {
    header('Location: ../index.php');
    exit;
}

unset($_SESSION['senha']);

$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$telefone = $_SESSION['telefone'];
$senhaStatus = $_SESSION['senha_status'] ?? 'Informação indisponível';
$modelo = $_SESSION['modelo'] ?? null;
$senhaArmazenada = null;

if (in_array($modelo, [1, 2, 3], true)) {
    $conn = ConexaoBanco();
    $stmt = mysqli_prepare($conn, 'SELECT senha FROM Usuario WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    if ($row) {
        $senhaArmazenada = $row['senha'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f5ef">
    <title>Sessão do usuário — SQL Lab</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/sql-lab.svg">
    <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="auth-shell">
    <div class="page-shell">
        <header class="site-header">
            <a class="brand" href="../index.php" aria-label="SQL Lab, voltar ao início">
                <span class="brand-mark" aria-hidden="true">&lt;/&gt;</span>
                <span>
                    <span class="brand-name">SQL Lab</span>
                    <span class="brand-caption">Segurança em aplicações</span>
                </span>
            </a>
            <span class="header-note">Sessão autenticada</span>
        </header>
    </div>

    <main class="auth-main page-shell">
        <section class="profile-card" aria-labelledby="page-title">
            <div class="profile-heading">
                <span class="profile-mark" aria-hidden="true">SL</span>
                <div>
                    <p class="eyebrow">Área de demonstração</p>
                    <h1 id="page-title">Dados da sessão</h1>
                    <p>Informações da conta autenticada neste modelo.</p>
                </div>
            </div>

            <dl class="profile-list">
                <div class="profile-row">
                    <dt>Nome</dt>
                    <dd><?= htmlspecialchars($nome, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd>
                </div>
                <div class="profile-row">
                    <dt>E-mail</dt>
                    <dd><?= htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd>
                </div>
                <div class="profile-row">
                    <dt>Telefone</dt>
                    <dd><?= htmlspecialchars($telefone, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd>
                </div>
                <div class="profile-row">
                    <dt>Armazenamento da senha</dt>
                    <dd><?= htmlspecialchars($senhaStatus, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd>
                </div>
                <?php if ($senhaArmazenada !== null): ?>
                    <div class="profile-row">
                        <dt>Valor salvo no banco (campo senha)</dt>
                        <dd class="stored-password"><?= htmlspecialchars($senhaArmazenada, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd>
                    </div>
                <?php endif; ?>
            </dl>

            <div class="profile-actions">
                <a class="back-link" href="../index.php">← Voltar aos modelos</a>
                <a class="back-link" href="../logout.php">Encerrar sessão</a>
            </div>
        </section>
    </main>

    <footer class="site-footer page-shell">Valor exibido para fins didáticos; modelos 2 e 3 mostram o hash, não a senha original.</footer>
</body>
</html>
