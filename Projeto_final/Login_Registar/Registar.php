<?php
require_once "../BD/DB_Conection.php";

$erroRegistro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];


    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $erroRegistro = "Esse email já está registado!";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);


        $sqlInsert = "INSERT INTO Users (nome, email, senha, tipo_user) VALUES (:nome, :email, :senha, 'Cliente')";
        $stmtInsert = $conn->prepare($sqlInsert);

        $stmtInsert->bindParam(':nome', $nome);
        $stmtInsert->bindParam(':email', $email);
        $stmtInsert->bindParam(':senha', $senhaHash);
        $stmtInsert->execute();

        header("Location: Login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>

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
            <a href="Login.php">Login</a>
        </div>
    </div>
</nav>

<body>

    <div class="home-container">
        <div class="info-card login-box">
            <h2 style="color: var(--primary-color); margin-bottom: 30px;">Criar Conta</h2>

            <?php if ($erroRegistro): ?>
                <p class="erro"><?= $erroRegistro ?></p>
            <?php endif; ?>

            <form method="POST">

                <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>

                <button type="submit" class="btn">Registar</button>
            </form>

            <p class="link">
                Já tem conta?
                <a href="Login.php">Voltar ao login</a>
            </p>
        </div>
    </div>

</body>

</html>