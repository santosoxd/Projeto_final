<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Sobre Nós</title>
    <link rel="stylesheet" href="../Nav_Footer.css">
    <link rel="stylesheet" href="About.css">
</head>

<nav class="nav">
    <div class="topnav">
        <a href="../Home/Home.php">Home</a>
        <a href="../About/About.php">Sobre</a>
        <a href="../Contacto/Contactos.php">Contact</a>
        <a href="../Home/test/mapa.php">Map</a>
        <div class="topnav-right">
            <?php
            session_start();
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

    <div class="about-hero">
        <h1 class="about-title">Quem Somos</h1>
        <p class="hero-subtitle">Inovação e Sustentabilidade na EPBJC</p>
    </div>

    <div class="about-grid">

        <div class="about-card">
            <h3>Sobre a Equipa</h3>
            <p>Somos alunos do 12º ano do curso Profissional de Técnico de Gestão e Programação de Sistemas
                Informáticos. Este projeto reflete o nosso compromisso com a tecnologia ao serviço da comunidade.</p>
            <div class="mission-box">
                "A tecnologia não deve apenas facilitar a vida, mas também proteger o mundo onde vivemos."
            </div>
        </div>

        <div class="about-card">
            <h3>Visão do Projeto</h3>
            <p>Integrado na disciplina de Área de Integração e Programação, este projeto visa responder ao problema do
                descarte ilegal de equipamentos.</p>
            <ul>
                <li>📍 <strong>Mapeamento:</strong> Localização precisa de ecocentros.</li>
                <li>📚 <strong>Educação:</strong> Informação clara sobre reciclagem.</li>
                <li>🤝 <strong>Comunidade:</strong> Envolver a população de Lisboa.</li>
            </ul>
        </div>

        <div class="about-card full-width">
            <h3>A Nossa Equipa</h3>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">💻</div>
                    <div class="member-name">Dev Team</div>
                    <div class="member-role">Programação & Design</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">🌍</div>
                    <div class="member-name">Eco Team</div>
                    <div class="member-role">Investigação & Conteúdo</div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>