<?php
// material_delete.php - Material löschen
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /materials.php");
    exit;
}

// ID abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    $_SESSION['message'] = "Ungültige Material-ID.";
    $_SESSION['message_type'] = "danger";
    header("Location: /materials.php");
    exit;
}

// Prüfen, ob das Material in Werkstücken verwendet wird
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM workpiece_material WHERE material_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    $_SESSION['message'] = "Dieses Material wird in Werkstücken verwendet und kann nicht gelöscht werden.";
    $_SESSION['message_type'] = "danger";
    header("Location: /materials.php");
    exit;
}

// Material löschen
$stmt = $conn->prepare("DELETE FROM material WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Material erfolgreich gelöscht.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Fehler beim Löschen des Materials: " . $conn->error;
    $_SESSION['message_type'] = "danger";
}

// Zurück zur Materialübersicht
header("Location: /materials.php");
exit;
?>
