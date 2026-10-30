<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f5ef">
    <meta name="description" content="Laboratório didático para comparar abordagens de autenticação e prevenção de SQL Injection.">
    <title>SQL Lab — Laboratório de autenticação</title>
    <link rel="icon" type="image/svg+xml" href="assets/icons/sql-lab.svg">
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <a class="brand" href="index.php" aria-label="SQL Lab, página inicial">
                <span class="brand-mark" aria-hidden="true">&lt;/&gt;</span>
                <span>
                    <span class="brand-name">SQL Lab</span>
                    <span class="brand-caption">Segurança em aplicações</span>
                </span>
            </a>
            <span class="header-note">Projeto educacional · PHP &amp; MySQL</span>
        </header>

        <main class="home-main">
            <section class="hero" aria-labelledby="page-title">
                <p class="eyebrow">Laboratório de autenticação</p>
                <h1 id="page-title">Segurança se aprende comparando.</h1>
                <p class="hero-copy">
                    Explore três implementações de login e observe como consultas SQL e armazenamento
                    de senhas afetam a segurança de uma aplicação.
                </p>
            </section>

            <section aria-label="Modelos de autenticação">
                <div class="model-grid">
                    <a class="model-card" href="first_example/index.html">
                        <div class="card-topline">
                            <span class="model-number">MODELO 01</span>
                            <span class="status-pill status-danger">Vulnerável</span>
                        </div>
                        <h2>Consulta insegura</h2>
                        <p>Exemplo didático de consulta vulnerável e senha armazenada sem hash.</p>
                        <span class="card-link">Abrir modelo <span aria-hidden="true">→</span></span>
                    </a>

                    <a class="model-card" href="second_example/index.html">
                        <div class="card-topline">
                            <span class="model-number">MODELO 02</span>
                            <span class="status-pill status-warning">Proteção parcial</span>
                        </div>
                        <h2>Senha com hash</h2>
                        <p>O hash protege a senha armazenada, mas não corrige a consulta vulnerável.</p>
                        <span class="card-link">Abrir modelo <span aria-hidden="true">→</span></span>
                    </a>

                    <a class="model-card" href="third_example/index.html">
                        <div class="card-topline">
                            <span class="model-number">MODELO 03</span>
                            <span class="status-pill status-success">Protegido</span>
                        </div>
                        <h2>Consulta preparada</h2>
                        <p>Parâmetros vinculados e verificação de senha com hash em uma implementação protegida.</p>
                        <span class="card-link">Abrir modelo <span aria-hidden="true">→</span></span>
                    </a>
                </div>

                <aside class="safety-note">
                    <span aria-hidden="true">!</span>
                    <span><strong>Uso responsável:</strong> os modelos vulneráveis devem ser executados apenas
                    em ambiente local e controlado, para fins de estudo.</span>
                </aside>
            </section>
        </main>

        <footer class="site-footer">
            SQL Lab · Projeto educacional de segurança de aplicações
        </footer>
    </div>
</body>
</html>
