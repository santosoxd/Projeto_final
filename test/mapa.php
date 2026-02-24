<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Mapa de Pontos de Recolha</title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />
    <link rel="stylesheet" href="../../Nav_Footer.css">

    <style>
        #map {
            height: 100vh;
            width: 100%;
            
        }
    </style>
</head>

<nav class="nav">
    <div class="topnav">
        <a href="../../Home/Home.php">Home</a>
        <a href="../../About/About.php">Sobre</a>
        <a href="../../Contacto/Contactos.php">Contact</a>
        <a href="../../Home/test/mapa.php">Map</a>
        <div class="topnav-right">

            <?php
            session_start();
            if (isset($_SESSION['tipo'])) {
                echo '<a href="../../Login_Registar/logout.php">Logout</a>'; 
            
                if ($_SESSION['tipo'] === 'Admin') {
                    echo '
                    <div class="dropdown">
                        <button class="dropbtn">☰</button>
                        <div class="dropdown-content">
                            <a href="../../Admin/Adicionar_User.php">Adicionar User</a>
                            <a href="../../Admin/Adicionar_User.php">Editar Home Info</a>
                            <a href="../../Admin/Adicionar_User.php">Editar About Info</a>
                        </div>
                    </div>';
                }
            } else {
                echo '<a href="../../Login_Registar/Login.php">Login</a>';
            }
            ?>

        </div>
    </div>
</nav>

<body>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([38.7223, -9.1393], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    fetch('api/pontos.php')
        .then(res => res.json())
        .then(pontos => {
            pontos.forEach(ponto => {
                L.marker([ponto.latitude, ponto.longitude])
                    .addTo(map)
                    .bindPopup(`
                        <strong>${ponto.nome}</strong><br>
                        ${ponto.morada}<br>
                        ${ponto.freguesia ?? ""}<br>
                        <em>${ponto.tipo_local}</em><br>
                        ${ponto.horario ?? "Horário não disponível"}
                    `);
            });
        })
        .catch(err => {
            console.error("Erro ao carregar pontos:", err);
        });
</script>

</body>
</html>
