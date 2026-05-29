<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UjiBase Health Analytics</title>
    <link rel="stylesheet" href="<?= $basePath === '/' ? '' : $basePath ?>/public/css/output.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen antialiased">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border border-gray-200">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-teal-700">UjiBase Health</h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Analisis Tren Penyakit</p>
        </div>

        <form action="<?= $basePath ?>/login-process" method="POST" class="space-y-5">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 outline-none transition">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 outline-none transition">
            </div>
            <button type="submit" 
                class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md transition duration-200 shadow-sm">
                Masuk ke Sistem
            </button>
        </form>
        
        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; <?= date('Y') ?> UjiBase Health Analytics.
        </div>
    </div>

</body>
</html>