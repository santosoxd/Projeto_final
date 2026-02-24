<?php
session_start();
require_once "../BD/DB_Conection.php";
$erroLogin = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT id, senha, tipo_user FROM users WHERE email = :email";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && password_verify($senha, $cliente['senha'])) {

        $_SESSION['usuario_id'] = $cliente['id'];
        $_SESSION['utilizador'] = $cliente['tipo_user'];
        $_SESSION['tipo'] = $cliente['tipo_user'];

        if ($cliente['utilizador'] === 'admin') {
            header("Location: ../Admin/Home.php");
        } else {
            header("Location: ../Home/Home.php");
        }
        exit;

    } else {
        $erroLogin = "Email ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="../Nav_Footer.css">
    <link rel="stylesheet" href="../Home/Home.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 100px auto;
            text-align: center;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            box-sizing: border-box;

        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 242, 96, 0.3);
        }

        .erro {
            color: var(--accent-warning);
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .link {
            display: block;
            margin-top: 20px;
            color: var(--text-secondary);
        }

        .link a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>


<nav class="nav">
    <div class="topnav">
        <a href="../Home/Home.php">Home</a>
        <a href="../About/About.php">Sobre</a>
        <a href="../Contacto/Contactos.php">Contact</a>
        <a href="../Home/test/mapa.php">Map</a>
        <div class="topnav-right">
            <a href="Login.php" class="active">Login</a>
        </div>
    </div>
</nav>

<body>

    <div class="home-container">
        <div class="info-card login-box">
            <h2 style="color: var(--primary-color); margin-bottom: 30px;">Bem-vindo de Volta</h2>

            <?php if ($erroLogin): ?>
                <p class="erro"><?= $erroLogin ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>

                <button type="submit" class="btn">Entrar</button>
            </form>

            <p class="link">
                Não tem conta?
                <a href="registar.php">Registe-se aqui</a>
            </p>
        </div>
    </div>

</body>

</html>