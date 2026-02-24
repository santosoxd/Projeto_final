<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["mensagem"])) {

        $email = escapeshellarg($_POST["email"]);
        $mensagem = escapeshellarg($_POST["mensagem"]);

        $comando = "python Envio_Email.py $email $mensagem 2>&1";
        shell_exec($comando);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Contactos</title>
    <link rel="stylesheet" href="../Nav_Footer.css">
    <link rel="stylesheet" href="../Home/Home.css">
    <style>
        .form-control {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-secondary);
        }

        .btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 242, 96, 0.3);
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

            <?php
            if (isset($_SESSION['tipo'])) {
                echo '<a href="../Login_Registar/logout.php">Logout</a>';

                if ($_SESSION['tipo'] === 'Admin') {
                    echo '
                    <div class="dropdown">
                        <button class="dropbtn">☰</button>
                        <div class="dropdown-content">
                            <a href="../Admin/Adicionar_User.php">Adicionar User</a>
                            <a href="../Admin/Adicionar_User.php">Editar Home Info</a>
                            <a href="../Admin/Adicionar_User.php">Editar About Info</a>
                        </div>
                    </div>';
                }
            } else {
                echo '<a href="../Login_Registar/Login.php">Login</a>';
            }
            ?>

        </div>
    </div>
</nav>

<body>
    <div class="hero-section" style="padding-bottom: 40px;">
        <h1 class="hero-title">Fale Connosco</h1>
        <p class="hero-subtitle">Envie-nos as suas dúvidas ou sugestões</p>
    </div>

    <div class="home-container">
        <div class="info-card" style="max-width: 600px; margin: 0 auto;">
            <form method="POST" action="">
                <label for="email" class="label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>

                <label for="mensagem" class="label">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" class="form-control" rows="5" required></textarea>

                <button type="submit" class="btn">Enviar</button>
            </form>
        </div>
    </div>
</body>

</html>