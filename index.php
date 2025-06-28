<?php
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
) {
    header('Content-Type: application/json; charset=utf-8');
    $response = ['success' => false, 'message' => ''];

    // 1. Recoger y sanitizar
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $company = htmlspecialchars($_POST['company']);
    $service = htmlspecialchars($_POST['service']);
    $message = htmlspecialchars($_POST['message']);

    // 2. Verificar reCAPTCHA
    $secret  = '6LdVehwrAAAAABiZJfd-4t17EqugRlTsbxrnq8NL';
    $captcha = $_POST['g-recaptcha-response'] ?? '';
    $verify  = file_get_contents(
        'https://www.google.com/recaptcha/api/siteverify'
        . '?secret='  . $secret
        . '&response=' . $captcha
    );
    $valid = json_decode($verify)->success ?? false;

    if (!$valid) {
        $response['message'] = 'Por favor, verifica que no eres un robot.';
    } else {
        // 3. Enviar correo
        $to      = 'technomoon1@gmail.com';
        $subject = "Nuevo mensaje de contacto de $name";
        $body    = "Nombre: $name\nEmail: $email\nEmpresa: $company\n"
                 . "Servicio: $service\nMensaje:\n$message";

        if (mail($to, $subject, $body)) {
            $response['success'] = true;
            $response['message'] = '¡Mensaje enviado exitosamente!';
        } else {
            $response['message'] = 'Hubo un error al enviar el mensaje.';
        }
    }

    echo json_encode($response);
    exit; // importante: no envíes más HTML
}
?>

<!doctype html>
<html lang="es">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H3BT38L0EP"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-H3BT38L0EP');
    </script>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Techno-Moon - Servicios de TI y telecomunicaciones para empresas, incluyendo redes, cableado estructurado y soporte técnico.">
	<link rel="canonical" href="https://techno-moon.com<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
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
	<!-- Añade esto justo antes de </head> -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script defer src="scripts.js"></script>
</head>
<body>
    <!-- Header con menú adaptable y logo -->
    <header class="main-header">
        <!-- Contenedor para partículas -->
        <div id="particles-js"></div>
        <nav class="navbar" role="navigation">
            <a href="#" class="logo">
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
        <div class="header-content">
            <h1 data-es="Techno-moon: Soluciones en Tecnología y Telecomunicaciones" data-en="Solutions in Technology and Telecommunications">Techno-moon: Soluciones en Tecnología y Telecomunicaciones</h1>
            <p data-es="Redes, cableado estructurado y soporte técnico enfocados en optimizar la infraestructura tecnológica de tu negocio." data-en="Networks, structured cabling, and technical support focused on optimizing your business's technological infrastructure.">Redes, cableado estructurado y soporte técnico enfocados en optimizar la infraestructura tecnológica de tu negocio.</p>
            <br>
            <a href="#servicios" class="btn" data-es="Conoce Nuestros Servicios" data-en="Discover Our Services">Conoce Nuestros Servicios</a>
        </div>
    </header>
	<!-- Sección Sobre Nosotros -->
	<section id="sobre-nosotros" class="about-section">
		<div class="container">
			<h2 data-es="¿Quienes Somos?" data-en="About Us">¿Quienes somos?</h2>
			<p data-es="Techno-Moon es una empresa mexicana con sede en Saltillo, Coahuila Mexico, fundada por el Ing. Alejandro Salas. Nos especializamos en brindar soluciones integrales de infraestructura para diversos sectores, incluyendo la implementación de redes de cableado, soporte técnico para dispositivos y sistemas de CCTV. Nuestro compromiso es satisfacer y superar las expectativas de nuestros clientes mediante el uso de equipos, materiales y servicios de la más alta calidad." 
			   data-en="Techno-Moon is a Mexican company based in Saltillo, Coahuila, founded by Eng. Alejandro Salas. We specialize in providing comprehensive infrastructure solutions for various sectors, including structured cabling network implementation, technical support for devices, and CCTV systems. Our commitment is to meet and exceed our clients' expectations through the use of high-quality equipment, materials, and services.">
				Techno-Moon es una empresa mexicana con sede en Saltillo, Coahuila Mexico, fundada por el Ing. Alejandro Salas. Nos especializamos en brindar soluciones integrales de infraestructura para diversos sectores, incluyendo la implementación de redes de cableado, soporte técnico para dispositivos y sistemas de CCTV. Nuestro compromiso es satisfacer y superar las expectativas de nuestros clientes mediante el uso de equipos, materiales y servicios de la más alta calidad.
			</p>
			<div class="about-grid">
				<div class="about-card">
					<i class="fas fa-eye about-icon"></i>
					<h3 data-es="Visión" data-en="Vision">Visión</h3>
					<p data-es="Ser reconocidos como líderes en el sector tecnológico, ofreciendo soluciones innovadoras y adaptadas a las necesidades de nuestros clientes."
					   data-en="To be recognized as leaders in the technology sector, offering innovative solutions tailored to our clients' needs.">
						Ser reconocidos como líderes en el sector tecnológico, ofreciendo soluciones innovadoras y adaptadas a las necesidades de nuestros clientes.
					</p>
				</div>

				<div class="about-card">
					<i class="fas fa-bullseye about-icon"></i>
					<h3 data-es="Misión" data-en="Mission">Misión</h3>
					<p data-es="Proporcionar servicios tecnológicos de excelencia, garantizando la satisfacción del cliente y el desarrollo continuo de nuestro equipo."
					   data-en="To provide excellent technological services, ensuring customer satisfaction and the continuous development of our team.">
						Proporcionar servicios tecnológicos de excelencia, garantizando la satisfacción del cliente y el desarrollo continuo de nuestro equipo.
					</p>
				</div>

				<div class="about-card">
					<i class="fas fa-star about-icon"></i>
					<h3 data-es="Valores" data-en="Values">Valores</h3>
					<p data-es="Compromiso, Innovación y Trabajo en equipo son los pilares que guían nuestra labor diaria."
					   data-en="Commitment, Innovation, and Teamwork are the pillars that guide our daily work.">
						Compromiso, Innovación y Trabajo en equipo son los pilares que guían nuestra labor diaria.
					</p>
				</div>
			</div>
			<br><br>
			<a href="#sobre-nosotros" class="btn" data-es="Ver mas" data-en="Read more">Ver mas</a>
		</div>
	</section>
	
	<!-- Sección Servicios -->
	<section id="nuestros-servicios" class="services-section">
		<div class="container">
			<h2 data-es="Nuestros Servicios" data-en="Our Services">Nuestros Servicios</h2>
			<div id="servicios" class="services-grid">
				<!-- Los servicios se cargarán aquí de manera dinámica -->
				 
			</div>
		</div>
	</section>

	<!-- Sección de Casos de Estudio -->
	<section id="casos" class="casos">
		<h2 data-es="Casos de Exito" data-en="Success Stories">Casos de Exito</h2>
    	<div id="casos_estudio" class="grid-container"></div> <!-- Sección para casos de estudio -->
	</section>
	
	

	
	<!--Seccion de clientes-->
	<div><h2 data-es="Clientes" data-en="Customers">Clientes</h2></div>
	<section id="clientes">
        <?php
		  $host = 'localhost';
		  $dbname = 'technomo_techno-moon';
		  $username = 'technomo_techno-moon';
		  $password = 'ga#uyupreMefrer6';

			try {
				$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Error de conexión: " . $e->getMessage();
				exit();
			}
		$sql = "SELECT codigo, empresa, nombre, puesto, correo, telefono, img FROM clientes ORDER BY id_clientes DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($clientes as $cliente) {
            echo "
                <div class='cliente-card'>
                    <img src='logos/{$cliente['img']}' alt='{$cliente['empresa']}' class='cliente-logo'>
                </div>
            ";
        }
        ?>
    </section>

		
	 <!-- Sección de Contacto Moderna -->
	<section id="contacto" class="contact-modern">
		<div class="contact-container">
			<div class="contact-content">
				<h2 data-es="Conectemos para Impulsar tu Empresa" 
					data-en="Let's Connect to Boost Your Business">
					Conectemos para Impulsar tu Empresa
				</h2>
				<p data-es="Completa el formulario para conocer más sobre nuestros servicios de IT." 
				   data-en="Fill out the form to learn more about our IT services.">
				   Completa el formulario para conocer más sobre nuestros servicios de IT.
				</p>
			</div>
            
            <!-- justo antes del form -->
            <div id="formMessage"></div>
            
			<form id="contactForm" action="contact.php" method="POST" class="contact-form">
				<div class="input-group">
					<input data-es="Nombre Completo" data-en="Full Name" 
						   type="text" id="name" name="name" 
						   placeholder="Nombre Completo" required>
				</div>

				<div class="input-group">
					<input data-es="Correo Electrónico" data-en="Email Address" 
						   type="email" id="email" name="email" 
						   placeholder="Correo Electrónico" required>
				</div>

				<div class="input-group">
					<input data-es="Empresa" data-en="Company" 
						   type="text" id="company" name="company" 
						   placeholder="Empresa" required>
				</div>

				<div class="input-group">
					<select id="service" name="service" required>
						<option value="" disabled selected 
								data-es="Selecciona un Servicio" 
								data-en="Select a Service">
							Selecciona un Servicio
						</option>
						<option value="servicedesk" data-es="Services Desk" 
								data-en="Services Desk">
							Services Desk
						</option>
						<option value="sitio" data-es="Soporte en sitio" 
								data-en="On-site Support">
							Soporte en sitio
						</option>
						<option value="cctv" data-es="cctv" 
								data-en="cctv">
							cctv
						</option>
						<option value="cableado" data-es="Cableado Estructurado"
								data-en="Structured Cabling">
							Cableado Estructurado
						</option>
						<option value="fibra" data-es="fibra Optica"
								data-en="Fiber Optics">
							fibra Optica
						</option>
						<option value="servidores" data-es="Mantenimiento de Servidores"
								data-en="Server Maintenance">
							Mantenimiento de Servidores
						</option>
						<option value="web" data-es="Diseño Web" data-en="Web Design">
							Diseño Web
						</option>
						<option value="otro" data-es="Otro" data-en="Other">
							Otro
						</option>
					</select>
				</div>

				<div class="input-group">
					<textarea data-es="Mensaje" data-en="Message" 
							  id="message" name="message" 
							  placeholder="Mensaje" required></textarea>
				</div>
				  <!-- … tus otros campos … -->

				  <!-- widget de reCAPTCHA -->
				  <div class="g-recaptcha" data-sitekey="6LdVehwrAAAAADfcpPeAE4GcaquI6kxGO-0ahehW"></div>

				  <button type="submit" class="btn-submit"
						  data-es="Enviar" data-en="Send">
					Enviar
				  </button>
			</form>
		</div>
	</section>

    <!-- Footer -->
    <?php
        include("footer.php");
    ?>
	
	
	<!-- Botón de Subir -->
    <a href="#" id="btn-subir" class="btn-subir" aria-label="Subir al inicio">
        <span>&#9650;</span> <!-- Flecha hacia arriba -->
    </a>
    
	<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <!-- ► Al final de tu index.php, justo antes de </body> -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form      = document.getElementById('contactForm');
  const container = document.getElementById('formMessage');

  form.addEventListener('submit', e => {
    e.preventDefault();
    container.innerHTML = '';             // limpia mensajes previos
    const data = new FormData(form);
fetch(window.location.pathname, {
  method: 'POST',
  credentials: 'same-origin',
  headers: {
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  },
  body: new FormData(form)
})


    .then(response => response.json())    // parsea SIEMPRE el JSON
    .then(res => {
      // Aquí ya tienes res.success y res.message
      const toast = document.createElement('div');
      toast.classList.add(
        'alert',
        res.success ? 'alert-success' : 'alert-error'
      );

      const icon = res.success
        ? `<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
             <path d="M7.5 13.75L4.375 ... Z" fill="currentColor"/>
           </svg>`
        : `<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
             <path d="M11.414 10l4.95 ... 10z" fill="currentColor"/>
           </svg>`;

      toast.innerHTML = `${icon}<span>${res.message}</span>`;
      container.appendChild(toast);

      // si fue éxito, limpia el form y resetea CAPTCHA
      if (res.success) {
        form.reset();
        if (window.grecaptcha) grecaptcha.reset();
      }

      // desaparecer después de 10s
      setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => toast.remove(), 500);
      }, 10000);
    })
    .catch(err => {
      console.error('Fetch error:', err);
      // Muestra un toast de fallo genérico
      container.innerHTML = '';
      const toast = document.createElement('div');
      toast.classList.add('alert', 'alert-error');
      toast.innerHTML = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                           <path d="M11.414 10l4.95 ... 10z" fill="currentColor"/>
                         </svg>
                         <span>Error de red, inténtalo de nuevo.</span>`;
      container.appendChild(toast);
      setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => toast.remove(), 500);
      }, 10000);
    });
  });
});
</script>


        
</body>
</html>
