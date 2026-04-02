<?php
require_once "./config/db.php";
session_start();

/* Récupération état de la maison */
$statusFromDb = $pdo->query("SELECT * FROM home_status WHERE id = 1")->fetch();

/* Activités récentes */
$activities = $pdo->query("
  SELECT * FROM activities
  ORDER BY created_at DESC
  LIMIT 6
")->fetchAll();

/* Simulation temporaire */
$status = [
  'doors' => 'ok',
  'windows' => 'danger',
  'camera' => 'ok',
  'water' => 'warning',
  'electricity' => 'ok',
  'smoke' => 'ok'
];

function statusColor($level)
{
  return match ($level) {
    'ok' => 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300',
    'warning' => 'border-amber-500/30 bg-amber-500/10 text-amber-300',
    'danger' => 'border-red-500/30 bg-red-500/10 text-red-300',
    default => 'border-white/10 bg-white/5 text-gray-300'
  };
}

function statusLabel($type, $value)
{
  return match ($type) {
    'doors' => $value === 'ok' ? '3/3 fermées' : 'Porte ouverte',
    'windows' => $value === 'ok' ? '5/5 fermées' : 'Fenêtre ouverte',
    'camera' => $value === 'ok' ? 'Actives' : 'Désactivées',
    'smoke' => $value === 'ok' ? 'Aucun danger' : 'Fumée détectée',
    'water' => match ($value) {
      'ok' => 'Aucune fuite',
      'warning' => 'Fuite détectée',
      'danger' => 'Fuite critique',
      default => 'Inconnu'
    },
    'electricity' => $value === 'ok' ? 'Stable' : 'Coupure',
    default => 'Inconnu'
  };
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - HomeGuardian</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background:
        radial-gradient(circle at top left, rgba(59,130,246,0.18), transparent 28%),
        radial-gradient(circle at top right, rgba(99,102,241,0.12), transparent 24%),
        linear-gradient(180deg, #09090b 0%, #0f172a 100%);
      color: white;
    }

    .glass {
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    .card-hover {
      transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }

    .card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.30);
      border-color: rgba(96,165,250,0.25);
    }

    .nav-link {
      transition: all .2s ease;
    }

    .nav-link:hover {
      background: rgba(255,255,255,0.06);
      color: white;
    }

    .stat-gradient-blue {
      background: linear-gradient(135deg, rgba(37,99,235,.22), rgba(59,130,246,.08));
    }

    .stat-gradient-emerald {
      background: linear-gradient(135deg, rgba(16,185,129,.20), rgba(5,150,105,.08));
    }

    .stat-gradient-violet {
      background: linear-gradient(135deg, rgba(139,92,246,.20), rgba(99,102,241,.08));
    }

    .stat-gradient-amber {
      background: linear-gradient(135deg, rgba(245,158,11,.20), rgba(217,119,6,.08));
    }

    .badge-dot {
      width: 8px;
      height: 8px;
      border-radius: 9999px;
      display: inline-block;
    }

    .pulse-soft {
      animation: pulseSoft 1.8s infinite;
    }

    @keyframes pulseSoft {
      0%, 100% { opacity: 1; }
      50% { opacity: .55; }
    }
  </style>
</head>

<body class="min-h-screen">
  <div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="hidden lg:flex w-72 flex-col justify-between border-r border-white/10 bg-black/30 px-6 py-8">
      <div>
        <div class="flex items-center gap-3 mb-10">
          <div class="w-12 h-12 rounded-2xl glass flex items-center justify-center">
            <img class="w-8 h-8 object-contain" src="./assets/img/logo-white.png" alt="Logo HomeGuardian">
          </div>
          <div>
            <p class="text-lg font-bold">HomeGuardian</p>
            <p class="text-xs text-gray-400">Smart home dashboard</p>
          </div>
        </div>

        <nav class="space-y-2 text-sm text-gray-300">
          <a class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 bg-blue-600/20 text-white border border-blue-500/20" href="home.php">
            <span>Dashboard</span>
          </a>
          <a class="nav-link flex items-center gap-3 rounded-xl px-4 py-3" href="devices.php">
            <span>Appareils connectés</span>
          </a>
          <a class="nav-link flex items-center gap-3 rounded-xl px-4 py-3" href="alerts.php">
            <span>Alertes</span>
          </a>
          <a class="nav-link flex items-center gap-3 rounded-xl px-4 py-3" href="guardiania.php">
            <span>GuardianIA</span>
          </a>
          <a class="nav-link flex items-center gap-3 rounded-xl px-4 py-3" href="tutorial.php">
            <span>Tutoriels</span>
          </a>
          <a class="nav-link flex items-center gap-3 rounded-xl px-4 py-3" href="professional.php">
            <span>Professionnels</span>
          </a>
          <a class="nav-link flex items-center gap-3 rounded-xl px-4 py-3" href="statistics.php">
            <span>Statistiques</span>
          </a>
        </nav>
      </div>

      <div class="space-y-2 text-sm text-gray-400">
        <a class="nav-link block rounded-xl px-4 py-3" href="help.php">Aide</a>
        <a class="nav-link block rounded-xl px-4 py-3" href="settings.php">Paramètres</a>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 px-4 py-5 sm:px-6 lg:px-8">
      <!-- TOPBAR -->
      <header class="glass mb-8 rounded-2xl px-5 py-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <p class="text-sm text-blue-300 mb-1">Tableau de bord</p>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Vue globale de votre maison</h1>
            <p class="text-sm text-gray-400 mt-1">
              Surveillez votre sécurité, vos capteurs et vos équipements en temps réel.
            </p>
          </div>

          <div class="flex items-center gap-3">
            <button class="glass rounded-xl px-4 py-2 text-sm text-gray-300 hover:text-white transition">
              Notifications
            </button>
            <div class="w-11 h-11 rounded-2xl bg-blue-600 flex items-center justify-center font-semibold shadow-lg shadow-blue-600/20">
              U
            </div>
          </div>
        </div>
      </header>

      <!-- HERO ALERT -->
      <section class="mb-8">
        <div class="glass rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-4">
          <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
              <p class="text-sm font-semibold text-red-300">Alerte active</p>
              <p class="text-sm text-red-200/90">
                Une anomalie a été détectée sur les fenêtres ou le circuit d’eau. Vérification recommandée.
              </p>
            </div>
            <a href="alerts.php" class="inline-flex items-center justify-center rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 transition">
              Voir les alertes
            </a>
          </div>
        </div>
      </section>

      <!-- STATS -->
      <section class="mb-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
          <div class="glass stat-gradient-blue card-hover rounded-2xl p-5">
            <p class="text-sm text-gray-300">Capteurs actifs</p>
            <div class="mt-3 flex items-end justify-between">
              <div>
                <p class="text-3xl font-bold">12</p>
                <p class="text-xs text-gray-400 mt-1">Tous les systèmes principaux répondent</p>
              </div>
              <div class="w-11 h-11 rounded-xl bg-blue-500/20 border border-blue-400/20"></div>
            </div>
          </div>

          <div class="glass stat-gradient-emerald card-hover rounded-2xl p-5">
            <p class="text-sm text-gray-300">Niveau de sécurité</p>
            <div class="mt-3 flex items-end justify-between">
              <div>
                <p class="text-3xl font-bold text-emerald-300">Optimal</p>
                <p class="text-xs text-gray-400 mt-1">Surveillance active et stable</p>
              </div>
              <div class="w-11 h-11 rounded-xl bg-emerald-500/20 border border-emerald-400/20"></div>
            </div>
          </div>

          <div class="glass stat-gradient-violet card-hover rounded-2xl p-5">
            <p class="text-sm text-gray-300">Énergie estimée</p>
            <div class="mt-3 flex items-end justify-between">
              <div>
                <p class="text-3xl font-bold">320 kWh</p>
                <p class="text-xs text-gray-400 mt-1">Consommation cumulée récente</p>
              </div>
              <div class="w-11 h-11 rounded-xl bg-violet-500/20 border border-violet-400/20"></div>
            </div>
          </div>

          <div class="glass stat-gradient-amber card-hover rounded-2xl p-5">
            <p class="text-sm text-gray-300">Température intérieure</p>
            <div class="mt-3 flex items-end justify-between">
              <div>
                <p class="text-3xl font-bold">22°C</p>
                <p class="text-xs text-gray-400 mt-1">Niveau de confort actuel</p>
              </div>
              <div class="w-11 h-11 rounded-xl bg-amber-500/20 border border-amber-400/20"></div>
            </div>
          </div>
        </div>
      </section>

      <!-- CONTENT GRID -->
      <section class="grid grid-cols-1 gap-8 xl:grid-cols-3">

        <!-- LEFT -->
        <div class="xl:col-span-2 space-y-8">

          <!-- QUICK ACTIONS -->
          <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
              <div>
                <h2 class="text-lg font-semibold">Actions rapides</h2>
                <p class="text-sm text-gray-400">Accédez immédiatement aux commandes les plus importantes.</p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
              <button onclick="urgence()" class="card-hover rounded-2xl border border-red-500/20 bg-red-500/10 p-5 text-left">
                <p class="text-sm text-red-300 mb-2">Urgence</p>
                <p class="font-semibold text-white">Contacter les secours</p>
                <p class="text-xs text-red-200/80 mt-2">Action immédiate</p>
              </button>

              <button onclick="toggle('water')" class="card-hover rounded-2xl border border-cyan-500/20 bg-cyan-500/10 p-5 text-left">
                <p class="text-sm text-cyan-300 mb-2">Eau</p>
                <p class="font-semibold text-white">Couper l’arrivée</p>
                <p class="text-xs text-cyan-200/80 mt-2">Protection fuite</p>
              </button>

              <button onclick="toggle('electricity')" class="card-hover rounded-2xl border border-yellow-500/20 bg-yellow-500/10 p-5 text-left">
                <p class="text-sm text-yellow-300 mb-2">Électricité</p>
                <p class="font-semibold text-white">Gérer l’alimentation</p>
                <p class="text-xs text-yellow-200/80 mt-2">Circuit principal</p>
              </button>

              <button onclick="toggle('camera')" class="card-hover rounded-2xl border border-orange-500/20 bg-orange-500/10 p-5 text-left">
                <p class="text-sm text-orange-300 mb-2">Caméra</p>
                <p class="font-semibold text-white">Activer / couper</p>
                <p class="text-xs text-orange-200/80 mt-2">Surveillance visuelle</p>
              </button>
            </div>
          </div>

          <!-- HOUSE STATUS -->
          <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
              <div>
                <h2 class="text-lg font-semibold">État de votre maison</h2>
                <p class="text-sm text-gray-400">Résumé des principaux points de contrôle et de sécurité.</p>
              </div>
              <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                Mise à jour en direct
              </span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <?php
                $items = [
                  'doors' => 'Portes',
                  'windows' => 'Fenêtres',
                  'camera' => 'Caméras',
                  'smoke' => 'Fumée',
                  'water' => 'Eau',
                  'electricity' => 'Électricité'
                ];
              ?>

              <?php foreach ($items as $key => $label): ?>
                <div class="rounded-2xl border p-4 <?= statusColor($status[$key]) ?> <?= $key === 'water' && $status['water'] !== 'ok' ? 'pulse-soft' : '' ?>">
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <p class="text-sm font-medium"><?= $label ?></p>
                      <p class="text-lg font-semibold mt-1"><?= statusLabel($key, $status[$key]) ?></p>
                    </div>
                    <div class="mt-1">
                      <span class="badge-dot
                        <?= $status[$key] === 'ok' ? 'bg-emerald-400' : ($status[$key] === 'warning' ? 'bg-amber-400' : ($status[$key] === 'danger' ? 'bg-red-400' : 'bg-gray-400')) ?>">
                      </span>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

        </div>

        <!-- RIGHT -->
        <div class="space-y-8">

          <!-- SYSTEM OVERVIEW -->
          <div class="glass rounded-2xl p-6">
            <h2 class="text-lg font-semibold">Synthèse système</h2>
            <p class="text-sm text-gray-400 mt-1 mb-5">État global de la plateforme HomeGuardian.</p>

            <div class="space-y-4">
              <div class="flex items-center justify-between rounded-xl bg-white/5 px-4 py-3">
                <span class="text-sm text-gray-300">Portes sécurisées</span>
                <span class="text-sm font-semibold text-emerald-300">Oui</span>
              </div>

              <div class="flex items-center justify-between rounded-xl bg-white/5 px-4 py-3">
                <span class="text-sm text-gray-300">Caméras en ligne</span>
                <span class="text-sm font-semibold text-emerald-300">Actives</span>
              </div>

              <div class="flex items-center justify-between rounded-xl bg-white/5 px-4 py-3">
                <span class="text-sm text-gray-300">Risque fuite eau</span>
                <span class="text-sm font-semibold text-amber-300">Surveillance</span>
              </div>

              <div class="flex items-center justify-between rounded-xl bg-white/5 px-4 py-3">
                <span class="text-sm text-gray-300">Risque fumée</span>
                <span class="text-sm font-semibold text-emerald-300">Aucun</span>
              </div>
            </div>
          </div>

          <!-- RECENT ACTIVITIES -->
          <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
              <div>
                <h2 class="text-lg font-semibold">Activités récentes</h2>
                <p class="text-sm text-gray-400">Derniers événements détectés.</p>
              </div>
            </div>

            <div class="space-y-3">
              <?php foreach ($activities as $a): ?>
                <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <p class="text-sm text-white font-medium">
                        <?= htmlspecialchars($a['message']) ?>
                      </p>
                      <p class="text-xs text-gray-400 mt-1">
                        <?= date('d/m/Y', strtotime($a['created_at'])) ?>
                      </p>
                    </div>
                    <span class="text-xs text-gray-400 whitespace-nowrap">
                      <?= date('H:i', strtotime($a['created_at'])) ?>
                    </span>
                  </div>
                </div>
              <?php endforeach; ?>

              <?php if (empty($activities)): ?>
                <div class="rounded-xl border border-white/10 bg-white/5 p-4 text-sm text-gray-400">
                  Aucune activité récente.
                </div>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </section>
    </main>
  </div>

  <script>
    function urgence() {
      alert("Les services d'urgence ont été contactés.");
    }

    function toggle(type) {
      fetch("../actions/toggle.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "type=" + encodeURIComponent(type)
      }).then(() => location.reload());
    }
  </script>
</body>
</html>