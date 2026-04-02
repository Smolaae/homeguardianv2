<?php
require '../../config/db.php';

$firstname = trim($_POST['firstname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$terms = isset($_POST['terms']);

if (!$firstname || !$email || !$password || !$terms) {
    header("Location: ./register.php?error=1");
    exit;
}

// Vérifier email existant
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    header("Location: ./register.php?error=2");
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert
$stmt = $pdo->prepare("
  INSERT INTO users (firstname, email, password)
  VALUES (?, ?, ?)
");
$stmt->execute([$firstname, $email, $hashedPassword]);

// Redirection login

header("Location: ./login.php");
exit;
