<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Non autorisé"]);
    exit;
}
// require '../../middleware/auth.php'; à ajouter en haut de chaque fichier API protégé
