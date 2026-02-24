<?php
require_once "../BD/DB_Conection.php";
session_start();

if (!isset($_GET['id'])) {
    die("ID não recebido");
}

if (!isset($_SESSION['usuario_id'])) {
    die("Sessão sem id");
}

$id = $_GET['id'];

if ($id == $_SESSION['usuario_id']) {
    die("Não podes apagar a tua própria conta");
}

$sql = "DELETE FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    header("Location: Adicionar_User.php");
} else {
    echo "Erro ao eliminar";
}
exit;
?>