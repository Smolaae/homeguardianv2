<?php if (isset($_GET['error'])): ?>
<div class="max-w-md mx-auto mt-6">
  <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-lg text-sm text-center">
    <?php
      if ($_GET['error'] == 1) echo "Tous les champs sont obligatoires.";
      if ($_GET['error'] == 2) echo "Cet email est déjà utilisé.";
    ?>
  </div>
</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Créer un compte - HomeGuardian</title>

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
  <img src="./assets/img/logo-white.png" class="h-20 mx-auto mb-3">
  <h1 class="text-2xl font-bold">Créer un compte</h1>
  <p class="text-gray-400 text-sm">Commencez gratuitement en quelques secondes</p>
</div>

<!-- CARD -->
<div class="glass rounded-2xl p-8 shadow-xl">

<form method="POST" action="/homeguardian/api/auth/register.php">

<!-- NOM -->
<div class="mb-4">
<input
type="text"
name="firstname"
placeholder="Nom"
required
class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
/>
</div>

<!-- EMAIL -->
<div class="mb-4">
<input
type="email"
name="email"
placeholder="Email"
required
class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
/>
</div>

<!-- PASSWORD -->
<div class="mb-4">
<input
type="password"
name="password"
placeholder="Mot de passe"
required
class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
/>
</div>

<!-- CHECKBOX -->
<div class="flex items-start gap-2 mb-6 text-sm text-gray-400">
<input type="checkbox" required class="mt-1 accent-blue-500">
<span>
J'accepte les <a href="#" class="text-blue-400 hover:underline">conditions d'utilisation</a>
</span>
</div>

<!-- BUTTON -->
<button
type="submit"
class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition transform hover:scale-[1.02] shadow-lg"
>
Créer mon compte
</button>

<!-- LOGIN -->
<p class="text-center text-sm text-gray-400 mt-6">
Déjà inscrit ?
<a href="/homeguardian/login.php" class="text-blue-400 hover:underline">Se connecter</a>
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