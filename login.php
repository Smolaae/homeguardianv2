<?php if (isset($_GET['error'])): ?>
<div class="max-w-md mx-auto mt-6">
    <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-lg text-sm text-center">
        Identifiants incorrects
    </div>
</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - HomeGuardian</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 20% 20%, #1e3a8a, #0a0a0a 50%);
            color: white;
        }

        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        <!-- LOGO -->
        <div class="text-center mb-8">
            <img src="./assets/img/logo-white.png" class="h-12 mx-auto mb-3">
            <h1 class="text-2xl font-bold">Connexion</h1>
            <p class="text-gray-400 text-sm">Accédez à votre espace HomeGuardian</p>
        </div>

        <!-- CARD -->
        <div class="glass rounded-2xl p-8 shadow-xl">
            <form method="POST" action="./api/auth/login.php">

                <!-- EMAIL -->
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Mot de passe" required
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <!-- OPTIONS -->
                <div class="flex justify-between items-center text-sm text-gray-400 mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="accent-blue-500">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="reset_password.php" class="text-blue-400 hover:underline">Mot de passe oublié ?</a>
                </div>

                <!-- BUTTON -->
                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition transform hover:scale-[1.02] shadow-lg">
                    Se connecter
                </button>

                <!-- DIVIDER -->
                <div class="text-center text-gray-500 text-sm my-6">ou</div>

                <!-- SOCIAL -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" class="border border-white/10 py-2 rounded-lg hover:bg-white/10 transition">
                        Google
                    </button>
                    <button type="button" class="border border-white/10 py-2 rounded-lg hover:bg-white/10 transition">
                        Apple
                    </button>
                </div>

                <!-- REGISTER -->
                <p class="text-center text-sm text-gray-400 mt-6">
                    Pas encore de compte ?
                    <a href="register.php" class="text-blue-400 hover:underline">Créer un compte</a>
                </p>

            </form>
        </div>

        <!-- FOOTER -->
        <p class="text-center text-xs text-gray-500 mt-6">© 2026 HomeGuardian</p>

    </div>
</body>
</html>
