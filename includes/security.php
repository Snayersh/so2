<?php
/**
 * Funciones Auxiliares de Seguridad
 */

/**
 * Previene XSS: Escapa variables antes de imprimirlas en HTML.
 * @param string|null $string La cadena a escapar.
 * @return string La cadena sanitizada.
 */
function e(?string $string): string {
    if ($string === null) {
        return '';
    }
    // ENT_QUOTES: Convierte comillas dobles y simples.
    // ENT_HTML5: Asegura compatibilidad con HTML5.
    return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Genera y almacena un token CSRF seguro.
 * @return string El token generado.
 */
function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        // Genera 32 bytes aleatorios criptográficamente seguros y los codifica en hexadecimal
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valida un token CSRF provisto.
 * @param string $token El token a validar.
 * @return bool True si es válido, False de lo contrario.
 */
function validate_csrf_token(string $token): bool {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    // hash_equals mitiga ataques de Timing
    return hash_equals($_SESSION['csrf_token'], $token);
}
