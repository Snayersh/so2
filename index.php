<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/security.php';

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$csrfToken = generate_csrf_token();
$errorMsg = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']); // Limpiar error tras mostrarlo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureLogin | Premium Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-white p-4">

    <div class="glass-panel rounded-2xl p-8 max-w-md w-full shadow-2xl transition-all duration-300 hover:shadow-cyan-500/10">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">
                Secure Portal
            </h1>
            <p class="text-gray-400 text-sm mt-2">Acceso protegido mediante altos estándares OWASP</p>
        </div>

        <?php if ($errorMsg): ?>
        <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg relative mb-6 text-sm" role="alert">
            <span class="block sm:inline"><?php echo e($errorMsg); ?></span>
        </div>
        <?php endif; ?>

        <form action="login_process.php" method="POST" class="space-y-6">
            <!-- CSRF Token Estricto -->
            <input type="hidden" name="csrf_token" value="<?php echo e($csrfToken); ?>">

            <div>
                <label for="correo" class="block text-sm font-medium text-gray-300">Correo Electrónico</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" name="correo" id="correo" required
                           class="block w-full pl-10 bg-gray-900/50 border border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm text-white py-2.5 transition-colors"
                           placeholder="usuario@empresa.com">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" required
                           class="block w-full pl-10 bg-gray-900/50 border border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm text-white py-2.5 transition-colors"
                           placeholder="••••••••">
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-gray-900 transition-all">
                    Iniciar Sesión Segura
                </button>
            </div>
        </form>
    </div>

</body>
</html>
