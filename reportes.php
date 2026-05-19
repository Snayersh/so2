<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/bootstrap.php'; // Carga Eloquent ORM
require_once __DIR__ . '/includes/seguridad_pagina.php';

use App\Models\Usuario;
// Obtener datos del usuario logueado usando Eloquent y cargar la relación del Rol
$usuario = Usuario::with('rol')->find($_SESSION['user_id']);

if (!$usuario) {
    // Caso extremo donde el usuario fue eliminado mientras estaba en sesión
    header("Location: logout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes | Secure Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
        }
    </style>
</head>
<body class="min-h-screen text-gray-200">

    <!-- Navegación -->
    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">Módulo de Reportes</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="logout.php" class="text-sm text-red-400 hover:text-red-300 transition-colors bg-red-400/10 px-3 py-1.5 rounded-md border border-red-400/20">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="bg-gray-800/40 border border-gray-700/50 rounded-2xl overflow-hidden shadow-2xl">
            
            <div class="p-6 border-b border-gray-700/50 bg-gray-900/30">
                <h3 class="text-lg font-medium text-white">Información Confidencial de Rol</h3>
                <p class="mt-1 text-sm text-gray-400">Datos mostrados en función a los permisos asignados a tu perfil.</p>
            </div>
            
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-400">Identificador de Usuario</dt>
                        <dd class="mt-1 text-sm text-white font-mono"><?php echo e($usuario->id_usuario); ?></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-400">Correo Electrónico</dt>
                        <dd class="mt-1 text-sm text-white"><?php echo e($usuario->correo); ?></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-400">Rol Asignado</dt>
                        <dd class="mt-1 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium bg-cyan-900 text-cyan-300">
                                <?php echo e($usuario->rol ? $usuario->rol->nombre_rol : 'Sin Rol'); ?>
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-400">Descripción del Rol</dt>
                        <dd class="mt-1 text-sm text-white"><?php echo e($usuario->rol ? $usuario->rol->descripcion : '-'); ?></dd>
                    </div>
                    <div class="sm:col-span-2 border-t border-gray-700/50 pt-6 mt-2">
                        <dt class="text-sm font-medium text-gray-400 mb-4">Ejemplo de Reporte Generado</dt>
                        <dd class="mt-1 text-sm text-white">
                            <div class="bg-gray-900/50 rounded-lg border border-gray-700/50 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Métrica</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Valor Seguro</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Inyecciones SQL Prevenidas</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">100% (Vía ORM)</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 text-green-300">Óptimo</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Ataques XSS Mitigados</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Sanitización Estricta</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 text-green-300">Óptimo</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Fuerza Bruta Bloqueada</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Bloqueo a 3 intentos</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 text-green-300">Activo</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

    </main>

</body>
</html>
