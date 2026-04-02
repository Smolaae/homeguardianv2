<?php
require '../../config/db.php';
session_start();

$data = json_decode(file_get_contents("php://input"), true);

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(["error" => "Email ou mot de passe manquant"]);
    exit;
}

// Récupération utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["error" => "Identifiants invalides"]);
    exit;
}

// Stocker l'utilisateur en session
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];

echo json_encode([
    "success" => true,
    "user" => [
        "id" => $user['id'],
        "email" => $user['email'],
        "firstname" => $user['firstname']
    ]
]);

header("Location: /Homeguardian/home.php");
exit;
