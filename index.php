<?php
if (
    $_SERVER[ 'REQUEST_METHOD' ] === 'POST' &&
    isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&
    strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) === 'xmlhttprequest'
) {
    header( 'Content-Type: application/json; charset=utf-8' );
    $response = [ 'success' => false, 'message' => '' ];

    // 1. Recoger y sanitizar
    $name = htmlspecialchars( $_POST[ 'name' ] );
    $email = htmlspecialchars( $_POST[ 'email' ] );
    $company = htmlspecialchars( $_POST[ 'company' ] );
    $service = htmlspecialchars( $_POST[ 'service' ] );
    $message = htmlspecialchars( $_POST[ 'message' ] );

    // 2. Verificar reCAPTCHA
    $secret = '6LdVehwrAAAAABiZJfd-4t17EqugRlTsbxrnq8NL';
    $captcha = $_POST[ 'g-recaptcha-response' ] ?? '';
    $verify = file_get_contents(
        'https://www.google.com/recaptcha/api/siteverify'
        . '?secret=' . $secret
        . '&response=' . $captcha
    );
    $valid = json_decode( $verify )->success ?? false;

    if ( !$valid ) {
        $response[ 'message' ] = 'Por favor, verifica que no eres un robot.';
    } else {
        // 3. Enviar correo
        $to = 'technomoon1@gmail.com';
        $subject = "Nuevo mensaje de contacto de $name";
        $body = "Nombre: $name\nEmail: $email\nEmpresa: $company\n"
            . "Servicio: $service\nMensaje:\n$message";

        if ( mail( $to, $subject, $body ) ) {
            $response[ 'success' ] = true;
            $response[ 'message' ] = '¡Mensaje enviado exitosamente!';
        } else {
            $response[ 'message' ] = 'Hubo un error al enviar el mensaje.';
        }
    }

    echo json_encode( $response );
    exit; // importante: no envíes más HTML
}

// 3.2 Cargar idiomas disponibles

// 3.1 Conexión PDO
$conn = new PDO(
    "mysql:host=localhost;dbname=technomo_techno-moon;charset=utf8",
    "root", "", [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
);

// 3.2 Idiomas disponibles
$langStmt = $conn->query( "SELECT code, name, flag_path FROM languages ORDER BY code" );
$languages = $langStmt->fetchAll( PDO::FETCH_ASSOC );
$langCodes = array_column( $languages, 'code' ); // e.g. ['es','en']

// 3.3 Traducciones: columnas dinámicas según $langCodes
$cols = array_map( fn( $c ) => "content_$c", $langCodes );
$sql = "SELECT `key`, " . implode( ",", $cols ) . " FROM translations";
$stmt = $conn->query( $sql );

$translations = [];
while ( $r = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
    foreach ( $langCodes as $c ) {
        $translations[ $r[ 'key' ] ][ $c ] = $r[ "content_$c" ];
    }
}

// 3.4 Elegir idioma activo: GET → Cookie → default 'es'
if ( isset( $_GET[ 'lang' ] ) && in_array( $_GET[ 'lang' ], $langCodes, true ) ) {
    $lang = $_GET[ 'lang' ];
} elseif ( isset( $_COOKIE[ 'lang' ] ) && in_array( $_COOKIE[ 'lang' ], $langCodes, true ) ) {
        $lang = $_COOKIE[ 'lang' ];
    } else {
        $lang = 'es';
    }
    // actualizar cookie 30 días
setcookie( 'lang', $lang, [
    'expires' => time() + 30 * 24 * 3600,
    'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax'
] );

// 3.5 Helper para extraer y escapar
function t( string $key, string $lc = null ): string {
    global $translations, $lang;
    $l = $lc ?? $lang;
    $txt = $translations[ $key ][ $l ] ??
        $translations[ $key ][ 'es' ] // fallback
        ??
        '';
    return htmlspecialchars( $txt, ENT_QUOTES, 'UTF-8' );
}

// Ejemplo del array de códigos de idioma:
$langCodes = [ 'es', 'en' , 'fr'];

// Mapea cada key de tu tabla translations al fragmento de URL correspondiente
$navItems = [
    'menu-servicios' => 'servicios',
    'menu-sobre-nosotros' => 'sobre-nosotros',
    'menu-casos-exito' => 'casos',
    'menu-contacto' => 'contacto',
];

$aboutCards = [
    [ 'icon' => 'fa-eye', 'titleKey' => 'about_vision_title', 'textKey' => 'about_vision_text' ],
    [ 'icon' => 'fa-bullseye', 'titleKey' => 'about_mission_title', 'textKey' => 'about_mission_text' ],
    [ 'icon' => 'fa-star', 'titleKey' => 'about_values_title', 'textKey' => 'about_values_text' ],
];

$sectionAnchors = [
    'services_section_title' => 'nuestros-servicios',
    'cases_section_title' => 'casos',
];
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
<a href="#main-content" class="skip-link">Saltar al contenido principal</a> 

<!-- Header con menú adaptable y logo -->
<header class="main-header"> 
  <!-- Contenedor para partículas -->
  <div id="particles-js"></div>
  <nav class="navbar" role="navigation"> <a href="#" class="logo"> <img src="img/logo.png" alt="Logo de Techno-moon" class="logo-img"> </a>
    <div class="mobile-menu" id="mobile-menu" aria-expanded="false">☰</div>
    <ul class="nav-links" id="nav-links">
      <?php foreach ($navItems as $key => $anchor): ?>
      <li> <a href="#<?= htmlspecialchars($anchor, ENT_QUOTES) ?>"
         class="nav-link"
         <?php foreach ($langCodes as $code): ?>
           data-<?= $code ?>="<?= t($key, $code) ?>"
         <?php endforeach; ?>
      >
        <?= t($key) ?>
        </a> </li>
      <?php endforeach; ?>
    </ul>
    <div class="language-selector">
      <?php foreach($languages as $l): ?>
      <button
				  id="lang-<?= htmlspecialchars($l['code'],ENT_QUOTES) ?>"
				  onclick="changeLanguage('<?= htmlspecialchars($l['code'],ENT_QUOTES) ?>')"
				  aria-label="Cambiar a <?= htmlspecialchars($l['name'],ENT_QUOTES) ?>"> <img
					src="<?= htmlspecialchars($l['flag_path'],ENT_QUOTES) ?>"
					alt="<?= htmlspecialchars($l['name'],ENT_QUOTES) ?>"
					class="flag-icon" loading="lazy">
      <?= strtoupper(htmlspecialchars($l['code'],ENT_QUOTES)) ?>
      </button>
      <?php endforeach; ?>
    </div>
    
    <!--<div class="language-selector">
                <button id="lang-en" onclick="changeLanguage('en')" aria-label="Cambiar a inglés">
                    <img src="img/Idioma/en.png" alt="English" class="flag-icon"> EN
                </button>
                <button id="lang-es" onclick="changeLanguage('es')" aria-label="Cambiar a Español">
                    <img src="img/Idioma/es.png" alt="Español" class="flag-icon"> ES
                </button>
             </div>--> 
  </nav>
  <div class="header-content">
    <h1
			<?php foreach ($langCodes as $code): ?>
			  data-<?= $code ?>="<?= t('header_title', $code) ?>"
			<?php endforeach; ?>
		  >
      <?= t('header_title') ?>
    </h1>
    <p
			<?php foreach ($langCodes as $code): ?>
			  data-<?= $code ?>="<?= t('header_subtitle', $code) ?>"
			<?php endforeach; ?>
		  >
      <?= nl2br(t('header_subtitle')) ?>
    </p>
    <br>
    <a href="#servicios"
			 class="btn"
			 <?php foreach ($langCodes as $code): ?>
			   data-<?= $code ?>="<?= t('header_button', $code) ?>"
			 <?php endforeach; ?>
		  >
    <?= t('header_button') ?>
    </a> </div>
</header>
<!-- Sección Sobre Nosotros -->
<section id="sobre-nosotros" class="about-section">
  <div class="container"> 
    
    <!-- Título -->
    <h2
      <?php foreach ($langCodes as $c): ?>
        data-<?= $c ?>="<?= t('about_section_title', $c) ?>"
      <?php endforeach; ?>
    >
      <?= t('about_section_title') ?>
    </h2>
    
    <!-- Párrafo -->
    <p
      <?php foreach ($langCodes as $c): ?>
        data-<?= $c ?>="<?= t('about_section_paragraph', $c) ?>"
      <?php endforeach; ?>
    >
      <?= nl2br(t('about_section_paragraph')) ?>
    </p>
    
    <!-- Cards dinámicas -->
    <div class="about-grid">
      <?php foreach ($aboutCards as $card): ?>
      <div class="about-card"> <i class="fas <?= $card['icon'] ?> about-icon"></i>
        <h3
            <?php foreach ($langCodes as $c): ?>
              data-<?= $c ?>="<?= t($card['titleKey'], $c) ?>"
            <?php endforeach; ?>
          >
          <?= t($card['titleKey']) ?>
        </h3>
        <p
            <?php foreach ($langCodes as $c): ?>
              data-<?= $c ?>="<?= t($card['textKey'], $c) ?>"
            <?php endforeach; ?>
          >
          <?= nl2br(t($card['textKey'])) ?>
        </p>
      </div>
      <?php endforeach; ?>
    </div>
    
    <!-- Botón “Ver más” --> 
    <br>
    <br>
    <a href="#sobre-nosotros" class="btn"
      <?php foreach ($langCodes as $c): ?>
        data-<?= $c ?>="<?= t('about_readmore', $c) ?>"
      <?php endforeach; ?>
    >
    <?= t('about_readmore') ?>
    </a> </div>
</section>

<!-- Sección Servicios -->
<section id="nuestros-servicios" class="services-section">
  <div class="container"> 
    
    <!-- Título dinámico -->
    <h2
      <?php foreach ($langCodes as $c): ?>
        data-<?= $c ?>="<?= t('services_section_title', $c) ?>"
      <?php endforeach; ?>
    >
      <?= t('services_section_title') ?>
    </h2>
    <div id="servicios" class="services-grid"> 
      <!-- (Aquí tu JS o PHP cargará dinámicamente cada servicio) --> 
    </div>
  </div>
</section>

<!-- Sección de Casos de Estudio -->
<section id="casos" class="casos"> 
  
  <!-- Título dinámico -->
  <h2
    <?php foreach ($langCodes as $c): ?>
      data-<?= $c ?>="<?= t('cases_section_title', $c) ?>"
    <?php endforeach; ?>
  >
    <?= t('cases_section_title') ?>
  </h2>
  <div id="casos_estudio" class="grid-container"> 
    <!-- (Aquí tu JS o PHP insertará cada caso de estudio) --> 
  </div>
</section>

<!--Seccion de clientes-->
<div>
  <h2
		<?php foreach ($langCodes as $code): ?>
		  data-<?= $code ?>="<?= t('clients_section_title', $code) ?>"
		<?php endforeach; ?>
	  >
    <?= t('clients_section_title') ?>
  </h2>
</div>
<section id="clientes">
  <?php
  $host = 'localhost';
  $dbname = 'technomo_techno-moon';
  $username = 'root';
  $password = '';

  try {
      $conn = new PDO( "mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password );
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  } catch ( PDOException $e ) {
      echo "Error de conexión: " . $e->getMessage();
      exit();
  }
  $sql = "SELECT codigo, empresa, nombre, puesto, correo, telefono, img FROM clientes ORDER BY id_clientes DESC";
  $stmt = $conn->prepare( $sql );
  $stmt->execute();
  $clientes = $stmt->fetchAll( PDO::FETCH_ASSOC );
  foreach ( $clientes as $cliente ) {
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
      <h2
        <?php foreach ($langCodes as $c): ?>
          data-<?= $c ?>="<?= t('contact_title', $c) ?>"
        <?php endforeach; ?>
      >
        <?= t('contact_title') ?>
      </h2>
      <p
        <?php foreach ($langCodes as $c): ?>
          data-<?= $c ?>="<?= t('contact_subtitle', $c) ?>"
        <?php endforeach; ?>
      >
        <?= t('contact_subtitle') ?>
      </p>
    </div>
    <div id="formMessage"></div>
    <form id="contactForm" action="contact.php" method="POST" class="contact-form">
      <div class="input-group">
        <input
          type="text" id="name" name="name" required
          <?php foreach ($langCodes as $c): ?>
            data-<?= $c ?>="<?= t('contact_placeholder_name', $c) ?>"
            placeholder="<?= t('contact_placeholder_name', $c) ?>"
          <?php endforeach; ?>
        >
      </div>
      <div class="input-group">
        <input
          type="email" id="email" name="email" required
          <?php foreach ($langCodes as $c): ?>
            data-<?= $c ?>="<?= t('contact_placeholder_email', $c) ?>"
            placeholder="<?= t('contact_placeholder_email', $c) ?>"
          <?php endforeach; ?>
        >
      </div>
      <div class="input-group">
        <input
          type="text" id="company" name="company" required
          <?php foreach ($langCodes as $c): ?>
            data-<?= $c ?>="<?= t('contact_placeholder_company', $c) ?>"
            placeholder="<?= t('contact_placeholder_company', $c) ?>"
          <?php endforeach; ?>
        >
      </div>
      <div class="input-group">
        <select id="service" name="service" required>
          <option value="" disabled selected
            <?php foreach ($langCodes as $c): ?>
              data-<?= $c ?>="<?= t('contact_option_servicedesk', $c) ?>"
            <?php endforeach; ?>
          >
          <?= t('contact_option_servicedesk') ?>
          </option>
          <?php
          // define un array de value => key para las opciones
          $opts = [
              'servicedesk' => 'contact_option_servicedesk',
              'sitio' => 'contact_option_sitio',
              'cctv' => 'contact_option_cctv',
              'cableado' => 'contact_option_cableado',
              'fibra' => 'contact_option_fibra',
              'servidores' => 'contact_option_servidores',
              'web' => 'contact_option_web',
              'otro' => 'contact_option_otro',
          ];
          foreach ( $opts as $value => $keyOpt ):
              ?>
          <option value="<?= htmlspecialchars($value,ENT_QUOTES) ?>"
              <?php foreach ($langCodes as $c): ?>
                data-<?= $c ?>="<?= t($keyOpt, $c) ?>"
              <?php endforeach; ?>
            >
          <?= t($keyOpt) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="input-group">
        <textarea id="message" name="message" required
          <?php foreach ($langCodes as $c): ?>
            data-<?= $c ?>="<?= t('contact_placeholder_message', $c) ?>"
            placeholder="<?= t('contact_placeholder_message', $c) ?>"
          <?php endforeach; ?>
        ></textarea>
      </div>
      <div class="g-recaptcha" data-sitekey="6LdVehwrAAAAADfcpPeAE4GcaquI6kxGO-0ahehW"></div>
      <button type="submit" class="btn-submit"
        <?php foreach ($langCodes as $c): ?>
          data-<?= $c ?>="<?= t('contact_button', $c) ?>"
        <?php endforeach; ?>
      >
      <?= t('contact_button') ?>
      </button>
    </form>
  </div>
</section>

<!-- Footer -->
<?php
include( "footer.php" );
?>

<!-- Botón de Subir --> 
<a href="#" id="btn-subir" class="btn-subir" aria-label="Subir al inicio"> <span>&#9650;</span> <!-- Flecha hacia arriba --> 
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
