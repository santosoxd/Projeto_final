<?php
require_once "../BD/DB_Conection.php";
session_start();

$erroRegistro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['registar'])) {

    $nome = $_POST["nome"];
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipos = $_POST['tipos'];

    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $erroRegistro = "Esse email já está registado!";
    } else {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sqlInsert = "INSERT INTO users (nome, email, senha, tipo_user)
                      VALUES (:nome, :email, :senha, :tipo)";

        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':nome', $nome);
        $stmtInsert->bindParam(':email', $email);
        $stmtInsert->bindParam(':senha', $senhaHash);
        $stmtInsert->bindParam(':tipo', $tipos);
        $stmtInsert->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_POST['confirmar_edicao'])) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo_user'];

    $sql = "UPDATE users 
            SET nome = :nome, email = :email, tipo_user = :tipo 
            WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$sql = "SELECT * FROM users";
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
        <h1 class="hero-title">Gerir Utilizadores</h1>
    </div>

    <div class="home-container">


        <div class="info-card">
            <h2>Registar Novo Utilizador</h2>

            <?php if ($erroRegistro): ?>
                <p style="color:var(--accent-warning); margin-bottom: 15px;"><?= $erroRegistro ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>

                <select name="tipos" class="form-control" required>
                    <option value="" disabled selected>Selecionar Tipo</option>
                    <option value="Cliente">Cliente</option>
                    <option value="Admin">Admin</option>
                </select>

                <button type="submit" name="registar" class="btn">Registar</button>
            </form>
        </div>


        <div class="info-card">
            <h2>Lista de Utilizadores</h2>
            <div style="overflow-x: auto;">
                <table border="0" cellpadding="8">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Tipo</th>
                        <th>Conta Criada</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>

                    <?php foreach ($users_select as $us): ?>
                        <tr>
                            <form method="POST">
                                <td><?= $us['id'] ?></td>

                                <?php if (isset($_GET['editar']) && $_GET['editar'] == $us['id']): ?>


                                    <td><input type="text" name="nome" value="<?= $us['nome'] ?>" class="form-control"
                                            style="margin:0; padding: 5px;" required></td>
                                    <td><input type="email" name="email" value="<?= $us['email'] ?>" class="form-control"
                                            style="margin:0; padding: 5px;" required></td>
                                    <td>••••••</td>
                                    <td>
                                        <?php if ($us['id'] == $_SESSION['usuario_id']): ?>

                                            <input type="hidden" name="tipo_user" value="<?= $us['tipo_user'] ?>">
                                            <span style="color: var(--text-secondary);"><?= $us['tipo_user'] ?></span>
                                        <?php else: ?>

                                            <select name="tipo_user" class="form-control" style="margin:0; padding: 5px;">
                                                <option value="Cliente" <?= $us['tipo_user'] == "Cliente" ? 'selected' : '' ?>>Cliente
                                                </option>
                                                <option value="Admin" <?= $us['tipo_user'] == "Admin" ? 'selected' : '' ?>>Admin
                                                </option>
                                            </select>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $us['created_at'] ?></td>
                                    <td>
                                        <input type="hidden" name="id" value="<?= $us['id'] ?>">
                                        <button type="submit" name="confirmar_edicao" class="btn"
                                            style="padding: 5px 10px; font-size: 0.8rem;">Confirmar</button>
                                    </td>
                                    <td>
                                        <a href="<?= $_SERVER['PHP_SELF'] ?>" style="color: var(--accent-warning);">Cancelar</a>
                                    </td>

                                <?php else: ?>


                                    <td><?= $us['nome'] ?></td>
                                    <td><?= $us['email'] ?></td>
                                    <td>••••••</td>
                                    <td><?= $us['tipo_user'] ?></td>
                                    <td><?= $us['created_at'] ?></td>

                                    <td>
                                        <a href="?editar=<?= $us['id'] ?>" style="color: var(--primary-color);">
                                            <?= ($us['id'] == $_SESSION['usuario_id']) ? 'Editar' : 'Editar' ?>
                                        </a>
                                    </td>

                                    <td>
                                        <?php if ($us['id'] == $_SESSION['usuario_id']): ?>
                                            <span style="color: var(--text-secondary);">Você</span>
                                        <?php else: ?>
                                            <a href="Eliminar_User.php?id=<?= $us['id'] ?>"
                                                onclick="return confirm('Tem certeza que deseja eliminar este utilizador?')"
                                                style="color: var(--accent-warning);">
                                                Eliminar
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

    </div>

</body>

</html>