<!doctype html>
<html lang="es">
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

<body>
	<!-- Header con menú adaptable y logo -->
    <header class="main-header1" >
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
	</header>
	<!--<section id="timeline" class="timeline">
		<h2>Línea del Tiempo de Servicios de IT</h2>
		<div class="timeline-container" id="timeline-container">
		</div>
	</section>-->
	 
	<section class="why_section layout_padding">
		<h2></h2>
				<div class="timeline">
					<ul>
					   <?php
						$host = "localhost";
						$db = "technomo_techno-moon";
						$user = "root";
						$pass = "";
						$puerto = "3306";
						// Conexión a la base de datos
						$conn = new mysqli($host, $user, $pass, $db, $puerto);
						$resultado=mysqli_query($conn, "SELECT * FROM tiempo");
						while($filas=mysqli_fetch_assoc($resultado))
						  { 
					   ?>
					<li>
						<div class="content">
							<?php
								echo "<h3>"; echo $filas['nombre']; echo "</h3>"; 
								echo "<p>"; echo $filas['descripcion']; echo "</p>";
							?>
						</div>
						<div class="time">
							<?php
								echo "<h4>"; echo $filas['fecha']; echo "</h4>";
							 ?>
						</div>
						</li>
							<?php
							   } 
							?>
					</ul>
					<ul>
						<div style="clear:both;"></div>
					</ul>
			   </div>
			</section>
	<?php
        include("footer.php");
    ?>
	
	
<script>	
document.addEventListener('DOMContentLoaded', () => {
    const timelineContainer = document.getElementById('timeline-container');

    if (!timelineContainer) {
        console.error("El contenedor de la línea del tiempo no se encontró.");
        return;
    }

    fetch('getTimelineData.php')
        .then(response => response.json())
        .then(data => {
            data.forEach((event, index) => {
                const eventDiv = document.createElement('div');
                const side = index % 2 === 0 ? 'event-left' : 'event-right';
                eventDiv.classList.add('event', side);

                // Crear el punto
                const point = document.createElement('div');
                point.classList.add('point');
                point.style.top = `${index * 120}px`; // Ajusta el espaciado dinámico
                point.style.backgroundColor = getColorByDate(event.fecha);

                // Añadir contenido del evento
                eventDiv.innerHTML = `
                    <h3>${event.nombre}</h3>
                    <p>${event.descripcion}</p>
                    <small>${event.fecha}</small>
                `;

                // Agregar el punto y el evento al contenedor
                timelineContainer.appendChild(point);
                timelineContainer.appendChild(eventDiv);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});

// Función para asignar colores según la fecha
function getColorByDate(fecha) {
    const year = new Date(fecha).getFullYear();
    switch (year) {
        case 2018: return '#28a745'; // Verde
        case 2019: return '#ffc107'; // Amarillo
        case 2020: return '#17a2b8'; // Aqua
        case 2021: return '#dc3545'; // Rojo
        default: return '#007bff'; // Azul por defecto
    }
}



</script>
	<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</body>
</html>