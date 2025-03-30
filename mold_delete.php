<?php
// mold_delete.php - Gießform löschen
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /molds.php");
    exit;
}

// ID abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    $_SESSION['message'] = "Ungültige Gießform-ID.";
    $_SESSION['message_type'] = "danger";
    header("Location: /molds.php");
    exit;
}

// Prüfen, ob die Gießform in Werkstücken verwendet wird
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM workpiece_mold WHERE mold_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    $_SESSION['message'] = "Diese Gießform wird in Werkstücken verwendet und kann nicht gelöscht werden.";
    $_SESSION['message_type'] = "danger";
    header("Location: /molds.php");
    exit;
}

// Gießform löschen
$stmt = $conn->prepare("DELETE FROM mold WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Gießform erfolgreich gelöscht.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Fehler beim Löschen der Gießform: " . $conn->error;
    $_SESSION['message_type'] = "danger";
}

// Zurück zur Gießformübersicht
header("Location: /molds.php");
exit;
?>
