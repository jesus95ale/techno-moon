<!DOCTYPE html>
<html lang="es">
<head>
    <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Techno-Moon - Servicios de TI y telecomunicaciones para empresas, incluyendo redes, cableado estructurado y soporte técnico.">
	<meta name="keywords" content="Techno-Moon, TI, telecomunicaciones, soporte técnico, redes, cableado estructurado">
	<meta name="author" content="Techno-Moon">
	<meta property="og:title" content="Techno-Moon - Soluciones en TI y Telecomunicaciones">
	<meta property="og:description" content="Redes, cableado estructurado y soporte técnico para empresas.">
	<meta property="og:image" content="img/logo.png">
	<meta property="og:url" content="https://technomoon.com">
	<meta name="twitter:card" content="summary_large_image">
    <title>Techno-moon</title>
    <link rel="stylesheet" href="styles.css">
	<link rel="preload" href="styles.css" as="style">
	<link rel="preload" href="https://fonts.googleapis.com/css?family=Poppins&display=swap" as="style">
	<link rel="preload" href="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js" as="script">
	<link rel="preload" href="img/logo.png" as="image">
	<link rel="icon" href="img/logo.png" type="image/x-icon">
	<link rel="icon" sizes="32x32" href="img/favicon-32x32.png" type="image/png">
	<link rel="apple-touch-icon" href="img/favicon-apple.png">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <script defer src="scripts.js"></script>
</head>
    <style>
        /* Variables de color */
        :root {
            --color-primario: #669999;
            --color-secundario: #333333;
            --color-fondo: #F2F2F2;
            --color-hover: #336666;
            --color-advertencia: #FF6600;
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: var(--color-secundario);
            background-color: var(--color-fondo);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: var(--color-primario);
        }

        a:hover {
            color: var(--color-hover);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('service-desk-banner.jpg') no-repeat center center/cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
        }

        .hero a {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--color-primario);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .hero a:hover {
            background-color: var(--color-hover);
        }

        /* Section */
        .section {
            padding: 50px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--color-primario);
            font-size: 2rem;
        }

        .section p {
            text-align: center;
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: var(--color-secundario);
        }

        /* Benefits Section */
        .benefits {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .benefit-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1 1 calc(33.333% - 40px);
            text-align: center;
            transition: transform 0.3s;
        }

        .benefit-card:hover {
            transform: translateY(-5px);
        }

        .benefit-card h3 {
            color: var(--color-primario);
            margin-bottom: 10px;
        }

        /* Advertencia */
        .alert {
            background-color: var(--color-advertencia);
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }

        /* Footer */
        footer {
            background-color: var(--color-primario);
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: white;
            text-decoration: underline;
        }

        footer a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
	    <!-- Header con menú adaptable y logo -->
		<header class="main-header">
			<!-- Contenedor para partículas -->
			<div id="particles-js"></div>
			<nav class="navbar" role="navigation">
				<a href="index.php" class="logo">
					<img src="img/logo.png" alt="Logo de Techno-moon" class="logo-img">
				</a>
				 <div class="mobile-menu" id="mobile-menu" aria-expanded="false">☰</div>
				<ul class="nav-links" id="nav-links">
					<li><a href="#servicios" class="nav-link" data-es="Servicios" data-en="Services">Servicios</a></li>
					<li><a href="#sobre-nosotros" class="nav-link" data-es="Sobre Nosotros" data-en="About Us">Sobre Nosotros</a></li>
					<li><a href="#casos" class="nav-link" data-es="Casos de Exito" data-en="Success Stories">Casos de Exito</a></li>
					<li><a href="#contacto" class="nav-link" data-es="Contacto" data-en="Contact">Contacto</a></li>
					<li><a href="/desk/index.php" class="nav-link" target="_blank" rel="noopener noreferrer" aria-label="desk">
							<img src="img/user.png" alt="Service Desk" width="10%">
						</a>
					</li>
				</ul>
				<div class="language-selector">
					<button id="lang-en" onclick="changeLanguage('en')" aria-label="Cambiar a inglés">
						<img src="img/Idioma/en.png" alt="English" class="flag-icon"> EN
					</button>
					<button id="lang-es" onclick="changeLanguage('es')" aria-label="Cambiar a Español">
						<img src="img/Idioma/es.png" alt="Español" class="flag-icon"> ES
					</button>
				</div>
			</nav>
			<div class="header-content">
				<h1>Service Desk</h1>
        <p>Brindamos soporte técnico remoto para resolver problemas rápidamente y garantizar la continuidad operativa de tu empresa.</p><br>
				<a href="#benefits" class="btn" data-es="Conoce Nuestros Servicios" data-en="Discover Our Services">Explorar Beneficios</a>
    </div>

   
		</header>
    <!-- Descripción -->
    <div class="section">
        <h2>¿Qué es Service Desk?</h2>
        <p>El servicio de Service Desk está diseñado para gestionar y solucionar incidentes de TI, ofreciendo soporte técnico personalizado 24/7 para empresas de todos los tamaños.</p>
    </div>

    <!-- Beneficios -->
    <div id="benefits" class="section">
        <h2>Beneficios</h2>
        <div class="benefits">
            <div class="benefit-card">
                <h3>Soporte 24/7</h3>
                <p>Disponibilidad continua para resolver problemas críticos cuando más lo necesites.</p>
            </div>
            <div class="benefit-card">
                <h3>Resolución Rápida</h3>
                <p>Reducción significativa del tiempo de inactividad con soluciones ágiles.</p>
            </div>
            <div class="benefit-card">
                <h3>Seguimiento Eficiente</h3>
                <p>Monitoreo detallado de cada incidencia para ofrecer un soporte integral.</p>
            </div>
        </div>
    </div>

    <!-- Casos de Uso -->
    <div class="section">
        <h2>Casos de Uso</h2>
        <p>Algunos ejemplos de cómo nuestro servicio de Service Desk puede ayudarte:</p>
        <ul style="list-style: none; padding: 0; text-align: center; margin-top: 20px;">
            <li style="margin-bottom: 15px;">✔ Recuperación de contraseñas rápidamente</li>
            <li style="margin-bottom: 15px;">✔ Resolución de problemas con software empresarial</li>
            <li style="margin-bottom: 15px;">✔ Configuración inicial de dispositivos nuevos</li>
        </ul>
    </div>

    <!-- Advertencia -->
    <div class="alert">
        Atención: Este servicio está diseñado para empresas que necesitan soporte continuo y confiable.
    </div>

    <!-- Footer -->
       <?php
			include("footer.php");
		?>
	<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</body>
</html>
