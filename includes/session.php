<?php
// Prevención estricta de Session Fixation y Session Hijacking

// Forzar que PHP use solo cookies para las sesiones (previene Session Fixation vía URL)
ini_set('session.use_only_cookies', 1);

// Evitar que PHP acepte un ID de sesión no inicializado por el servidor
ini_set('session.use_strict_mode', 1);

// Parámetros de la Cookie de Sesión
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

session_set_cookie_params([
    'lifetime' => 0, // Hasta que se cierre el navegador
    'path' => '/',
    'domain' => '', // Dominio actual
    'secure' => $isHttps, // Solo enviar por HTTPS si está disponible
    'httponly' => true, // Prevenir acceso por JavaScript (XSS prevention)
    'samesite' => 'Strict' // Prevenir envío en peticiones cross-site (CSRF defense-in-depth)
]);

// Nombre personalizado para ocultar la tecnología subyacente (PHPSESSID por defecto)
session_name('APP_SECURE_SESSION');

session_start();
