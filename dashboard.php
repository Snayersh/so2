<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/security.php';

// Validar que exista la sesión del usuario
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$correo = $_SESSION['user_email'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Secure Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="min-h-screen text-gray-200">

    <!-- Navegación -->
    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">SecureDashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-400">Autenticado como: <span class="text-white font-medium"><?php echo e($correo); ?></span></span>
                    <a href="logout.php" class="text-sm text-red-400 hover:text-red-300 transition-colors bg-red-400/10 px-3 py-1.5 rounded-md border border-red-400/20">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="glass-card rounded-2xl p-8 shadow-xl border-l-4 border-l-cyan-500">
            <h2 class="text-3xl font-bold text-white mb-2">Bienvenido a tu panel de control</h2>
            <p class="text-gray-400 mb-8">Has iniciado sesión correctamente bajo un protocolo seguro. Tu conexión está protegida contra OWASP Top 10 vulnerabilidades.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-cyan-500/50 transition-colors">
                    <div class="text-cyan-400 mb-2">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Seguridad Activa</h3>
                    <p class="text-sm text-gray-400 mt-1">Protección contra XSS, CSRF, Inyecciones SQL y Fuerza Bruta garantizada.</p>
                </div>
                
                <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-blue-500/50 transition-colors">
                    <div class="text-blue-400 mb-2">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Sesión Segura</h3>
                    <p class="text-sm text-gray-400 mt-1">Cookies con banderas Strict, HttpOnly y Secure activadas correctamente.</p>
                </div>

                <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-purple-500/50 transition-colors">
                    <div class="text-purple-400 mb-2">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Rendimiento</h3>
                    <p class="text-sm text-gray-400 mt-1">Consultas optimizadas y seguras usando Eloquent ORM.</p>
                </div>
            </div>

            <!-- Botón Siguiente -->
            <div class="mt-8 pt-6 border-t border-gray-700/50 flex justify-end">
                <a href="reportes.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-cyan-600 hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-gray-900 transition-all">
                    Siguiente: Ver Reportes
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

        </div>
    </main>

</body>
</html>
