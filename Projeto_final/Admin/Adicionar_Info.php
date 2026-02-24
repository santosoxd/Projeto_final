<?php
require_once "../BD/DB_Conection.php";
session_start();

$erroRegistro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['registar_info'])) {

    $titulo = $_POST["titulo"];
    $info = trim($_POST['info']);
    $tipo_texto = $_POST['tipo_texto'];

    if ($stmt->rowCount() > 0) {
        $erroRegistro = "Esse email já está registado!";
    } else {

        $sqlInsert = "INSERT INTO users (titulo, info, tipo_texto) VALUES (:titulo, :info, :tipo_texto)";

        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':titulo', $titulo);
        $stmtInsert->bindParam(':info', $info);
        $stmtInsert->bindParam(':tipo_texto', $tipo_texto);
        $stmtInsert->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_POST['confirmar_edicao'])) {

    $titulo = $_POST['titulo'];
    $info = $_POST['info'];
    $email = $_POST['email'];
    $tipo_texto = $_POST['tipo_texto'];

    $sql = "UPDATE users 
            SET nome = :titulo, info = :info, tipo_texto = :tipo_texto 
            WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':info', $info);
    $stmt->bindParam(':tipo_texto', $tipo_texto);
    $stmt->bindParam(':id', var: $id);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$sql = "SELECT * FROM info_home";
$users_select = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Gerir Utilizadores</title>
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

        select.form-control {
            cursor: pointer;
        }

        option {
            background: #0f2027;
            color: white;
        }
    </style>
</head>

<body>

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


    <div class="hero-section" style="padding-bottom: 20px;">
        <h1 class="hero-title">Gerir Informação</h1>
    </div>

    <div class="home-container">


        <div class="info-card">
            <h2>Registar De Informação</h2>

            <?php if ($erroRegistro): ?>
                <p style="color:var(--accent-warning); margin-bottom: 15px;"><?= $erroRegistro ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="titulo" class="form-control" placeholder="titulo" required>
                <input type="text" name="info" class="form-control" placeholder="info" required>

                <select name="tipo_texto" class="form-control" required>
                    <option value="" disabled selected>Selecionar Tipo</option>
                    <option value="Informacao">Informacao</option>
                    <option value="Noticia">Noticia</option>
                </select>

                <button type="submit" name="registar" class="btn">Registar</button>
            </form>
        </div>
    </div>

</body>

</html>