<?php
session_start(); // Inicia la sesión

// Establece el idioma según el parámetro recibido
if (isset($_GET['lang'])) {
    $_SESSION['idioma'] = $_GET['lang'];
}
?>
