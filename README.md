# SQL Lab

Laboratório educacional para comparar três fluxos de autenticação em PHP e MySQL: senha em texto puro, consulta vulnerável com senhas em hash e consulta preparada com verificação de hash.

> **Aviso:** os modelos 1 e 2 contêm vulnerabilidades intencionais. Execute o projeto apenas em ambiente local, com dados fictícios e um banco descartável. Não o exponha à internet nem use credenciais reais.

## O que cada modelo faz

| Modelo | Consulta de login | Armazenamento no cadastro | Resultado normal |
|---|---|---|---|
| 1 — vulnerável | Concatena e-mail e senha na consulta SQL. | Senha em texto puro. | Uma conta criada no modelo 1 pode entrar com o e-mail e a senha correspondentes. A tela de sessão mostra o valor salvo na coluna `senha`, que é a senha em texto puro. |
| 2 — vulnerável, hash parcial | Também concatena e-mail e senha na consulta; não usa `password_verify`. | Senha com `password_hash`. | O login compara o texto digitado diretamente com o valor armazenado. Por isso, senhas cadastradas com hash nos modelos 2 e 3 não passam pelo login normal do modelo 2. Uma conta criada no modelo 1 pode passar com a senha correta, pois ela está armazenada em texto puro. |
| 3 — protegido contra SQL Injection no login | Usa consulta preparada para localizar o e-mail e `password_verify` para validar a senha. | Senha com `password_hash`. | Contas criadas nos modelos 2 e 3 podem entrar com as credenciais corretas. Contas criadas no modelo 1 não passam pela verificação de hash sem uma migração da senha. |

Os três modelos usam a mesma tabela `Usuario`. Assim, uma conta criada em um modelo também fica visível aos outros modelos, mas o login depende do formato em que a senha foi armazenada e de como cada modelo a valida. O registro de e-mail duplicado também é compartilhado.

## O que a tela de sessão exibe

Após um login aceito, a página de sessão mostra nome, e-mail, telefone, tipo de armazenamento e o conteúdo atual da coluna `senha` para a conta associada à sessão:

- Modelo 1: exibe a senha em texto puro, pois esse é o valor armazenado.
- Modelos 2 e 3: exibem o hash salvo no banco, não a senha original. Um hash não pode ser usado como se fosse a senha original no fluxo normal de autenticação.

Essa exibição existe apenas para demonstrar o conteúdo do banco neste laboratório. Em aplicações reais, não se deve exibir senhas ou hashes a usuários.

## Comportamento e risco do modelo 2

O modelo 2 interpola os campos de entrada diretamente na consulta SQL. Uma entrada maliciosa pode alterar a condição da consulta e fazer com que o login selecione um registro diferente daquele cujas credenciais foram digitadas. Se uma linha for retornada, o código cria uma sessão com os dados dessa linha; a tela de sessão também consulta e mostra o valor armazenado em `senha` para o e-mail associado.

O código atual usa a primeira linha retornada pela consulta, mas não define `ORDER BY`. Portanto, **não é garantido** que essa linha seja o primeiro usuário cadastrado: a ordem depende do banco e do plano de execução. O modelo também não garante que qualquer conta criada no modelo 3 passe pelo login normal do modelo 2; senhas com hash não correspondem ao texto digitado na comparação direta. Esses detalhes são importantes para interpretar a demonstração sem confundir o comportamento observado com uma garantia do SQL.

## Executar localmente

1. Instale PHP com `mysqli`, MySQL e as dependências Composer do projeto.
2. Copie os valores de referência de `.env.exemple` para um `.env` local e configure `DB_HOST`, `DB_USER`, `DB_PASSWORD` e `DB_NAME`.
3. No banco configurado, crie a tabela usada pelo projeto:

   ```sql
   CREATE TABLE Usuario (
       id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(255) NOT NULL,
       email VARCHAR(255) NOT NULL UNIQUE,
       senha VARCHAR(255) NOT NULL,
       telefone VARCHAR(50) NOT NULL
   );
   ```

4. A partir da raiz do projeto, inicie o servidor local:

   ```sh
   php -S 127.0.0.1:8000
   ```

5. Acesse <http://127.0.0.1:8000>.

Use somente contas e dados fictícios. Apague o banco descartável ao terminar os testes.
