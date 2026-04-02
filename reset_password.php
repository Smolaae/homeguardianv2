<?php if (isset($_GET['success'])): ?>
    <div class="max-w-md mx-auto mt-6">
        <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded-lg text-sm text-center">
            Email envoyé avec succès
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="max-w-md mx-auto mt-6">
        <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-lg text-sm text-center">
            Une erreur est survenue
        </div>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Réinitialiser mot de passe - HomeGuardian</title>
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
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.1);
            }
        </style>
    </head>

    <body class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            <!-- LOGO -->
            <div class="text-center mb-8">
                <img src="./assets/img/logo-white.png" class="h-12 mx-auto mb-3">
                <h1 class="text-2xl font-bold">Mot de passe oublié</h1>
                <p class="text-gray-400 text-sm">
                    Entrez votre email pour recevoir un lien de réinitialisation
                </p>
            </div>

            <!-- CARD -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <form method="POST" action="./api/auth/reset_password.php">

                    <!-- EMAIL -->
                    <div class="mb-6">
                        <input
                            type="email"
                            name="email"
                            placeholder="Votre email"
                            required
                            class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        />
                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition transform hover:scale-[1.02] shadow-lg"
                    >
                        Envoyer le lien
                    </button>

                    <!-- BACK -->
                    <p class="text-center text-sm text-gray-400 mt-6">
                        Retour à la connexion ?
                        <a href="login.php" class="text-blue-400 hover:underline">Se connecter</a>
                    </p>

                </form>
            </div>

            <!-- FOOTER -->
            <p class="text-center text-xs text-gray-500 mt-6">
                © 2026 HomeGuardian
            </p>

        </div>
    </body>
</html>
