<?php
header("Content-Type: application/json");
require_once "../db.php";

$sql = "SELECT id, nome, morada, freguesia, latitude, longitude, horario, tipo_local 
        FROM pontos_recolha";

$stmt = $pdo->query($sql);
$pontos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($pontos);
