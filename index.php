<?php
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
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Home</title>
    <link rel="stylesheet" href="../Nav_Footer.css">
    <link rel="stylesheet" href="Home.css">
    <script>
        function openModal(type, title, content) {
            document.getElementById('modal-title').innerText = title;
            const body = document.getElementById('modal-body');

            if (type === 'video') {
                body.innerHTML = '<iframe width="100%" height="400" src="' + content + '" frameborder="0" allowfullscreen></iframe>';
            } else {
                body.innerHTML = '<p>' + content + '</p>';
            }

            document.getElementById('news-modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('news-modal').style.display = 'none';
            document.getElementById('modal-body').innerHTML = '';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('news-modal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
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
    <div class="hero-section">
        <h1 class="hero-title">E-Lixo Zero Lisboa</h1>
        <p class="hero-subtitle">Liberdade, Saúde e Segurança na Era Digital</p>
    </div>

    <div class="home-container">

        <div class="info-card">
            <h3>O Nosso Tema: 2025/2026</h3>
            <p>Este ano, a Escola Profissional Bento de Jesus Caraça (EPBJC) dedica-se ao tema <strong>"Liberdade, Saúde
                    e Segurança na Era Digital"</strong>.</p>
            <p>Num mundo onde a tecnologia molda a nossa existência, é crucial refletir sobre como o descarte de
                equipamentos afeta a nossa <strong>Saúde</strong> (poluição), a nossa <strong>Segurança</strong>
                (proteção de dados em dispositivos velhos) e a nossa <strong>Liberdade</strong> (o direito a um ambiente
                limpo).</p>
        </div>


        <div class="info-card warning-card">
            <h3>⚠️ Alerta Ambiental em Portugal</h3>
            <p>Portugal enfrenta um desafio crítico na gestão de resíduos. Segundo dados alarmantes reportados pelo
                <em>Expresso</em> (09/10/2021), somos um dos países da UE com menor taxa de recolha de equipamentos
                eletrónicos.
            </p>
            <p>O lixo eletrónico (REEE) contém substâncias perigosas como mercúrio e chumbo, que, se não tratadas,
                contaminam solos e águas, colocando em risco a saúde pública.</p>

            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">63k</span>
                    <span class="stat-label">Toneladas de REEE (2017)</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">Baixa</span>
                    <span class="stat-label">Taxa de Recolha PT</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">Alto</span>
                    <span class="stat-label">Impacto Ambiental</span>
                </div>
            </div>
        </div>


        <div class="info-card">
            <h3>A Nossa Missão</h3>
            <p>O projeto <strong>E-Lixo Zero Lisboa</strong> nasce da necessidade urgente de agir.</p>
            <ul>
                <li><strong>Consciencializar:</strong> Informar sobre os perigos do "lixo digital".</li>
                <li><strong>Facilitar:</strong> Mapear pontos de recolha acessíveis em Lisboa.</li>
                <li><strong>Transformar:</strong> Promover a economia circular, transformando "lixo" em recursos.</li>
            </ul>
        </div>


        <div class="news-section">
            <h2 class="news-title">Últimas Notícias & Gravações</h2>
            <div class="news-grid">


                <div class="news-card">
                    <img src="https://placehold.co/600x400/0f2027/ffffff?text=Video+Reportagem" class="news-img"
                        alt="Video">
                    <div class="news-content">
                        <h4>Reportagem: Lixo Eletrónico</h4>
                        <p>Veja a reportagem sobre o lixo eletrónico em Portugal e as falhas na recolha.</p>
                        <button
                            onclick="openModal('video', 'Reportagem RTP', 'https://www.youtube.com/embed/vhpoMleN6sE')"
                            class="news-link-btn">Ver Gravação
                        </button>
                        <?php
                        if (isset($_SESSION['tipo'])) {

                            if ($_SESSION['tipo'] === 'Admin') {
                                echo "<button
                                class=news-link-btn>Editar
                            </button>";
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="news-card">
                    <img src="https://placehold.co/600x400/1f4037/ffffff?text=Comunicado+Oficial" class="news-img"
                        alt="Comunicado">
                    <div class="news-content">
                        <h4> gestão de REEE e incentivos legais</h4>
                        <p>Veja o alerta do governo sobre a novação de descarte eletrodomésticos.</p>
                        <button
                            onclick="openModal('text', 'Comunicado APA', 'Novo sistema de incentivos aprovado pelo Governo português — Em comunicado oficial após reunião do Conselho de Ministros (4 de dezembro de 2025), foi aprovado um novo sistema de incentivos aplicável à recolha de resíduos eletrónicos. Este modelo será obrigatório a partir de 31 de dezembro de 2026 e tem como objetivos aumentar as taxas de recolha, reforçar a economia circular e garantir uma melhor gestão dos resíduos eletrónicos em todo o país, incluindo Lisboa.')"
                            class="news-link-btn">Ler Comunicado</button>
                        <?php
                        if (isset($_SESSION['tipo'])) {

                            if ($_SESSION['tipo'] === 'Admin') {
                                echo "<button
                                class=news-link-btn>Editar
                            </button>";
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="news-card">
                    <img src="https://placehold.co/600x400/2c5364/ffffff?text=Lei+DL+152-D" class="news-img"
                        alt="Legislação">
                    <div class="news-content">
                        <h4>Decreto-Lei n.º 152-D/2017</h4>
                        <p>O quadro legal para a gestão de resíduos de fluxos específicos e deposição em aterro.</p>
                        <button
                            onclick="openModal('text', 'Decreto-Lei n.º 152-D/2017', 'Este decreto-lei unifica o regime da gestão de fluxos específicos de resíduos. Estabelece que os produtores são responsáveis pelo financiamento da recolha e tratamento, e define metas ambiciosas para a reciclagem até 2025.')"
                            class="news-link-btn">Ler Resumo Oficial</button>
                        <?php
                        if (isset($_SESSION['tipo'])) {

                            if ($_SESSION['tipo'] === 'Admin') {
                                echo "<button
                                class=news-link-btn>Editar
                            </button>";
                            }
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>

    </div>


    <div id="news-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modal-title" style="color: var(--primary-color); margin-top: 0;"></h2>
            <div id="modal-body"></div>
        </div>
    </div>

</body>

</html>