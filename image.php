<?php
// image.php - Bild aus der Datenbank anzeigen (ohne Authentifizierung)
session_start();
require_once 'config/database.php';

// Parameter prüfen
$type = $_GET['type'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($type) || $id <= 0) {
    header("HTTP/1.0 400 Bad Request");
    exit("Ungültige Parameter");
}

// Tabelle basierend auf dem Typ bestimmen
$table = '';
switch ($type) {
    case 'material':
        $table = 'material';
        break;
    case 'mold':
        $table = 'mold';
        break;
    case 'workpiece':
        $table = 'workpiece';
        break;
    default:
        header("HTTP/1.0 400 Bad Request");
        exit("Ungültiger Bildtyp");
}

// Bild aus der Datenbank abrufen
$stmt = $conn->prepare("SELECT image FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    header("HTTP/1.0 404 Not Found");
    exit("Bild nicht gefunden");
}

$stmt->bind_result($image);
$stmt->fetch();

// Bild-Header setzen und Bild ausgeben
header("Content-Type: image/jpeg");
echo $image;
exit;
?>
