<?php
// casting_powder_delete.php - Gießpulver löschen
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /casting_powders.php");
    exit;
}

// ID abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    $_SESSION['message'] = "Ungültige Gießpulver-ID.";
    $_SESSION['message_type'] = "danger";
    header("Location: /casting_powders.php");
    exit;
}

// Prüfen, ob das Gießpulver in Werkstücken verwendet wird
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM workpiece_mold WHERE casting_powder_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    $_SESSION['message'] = "Dieses Gießpulver wird in Werkstücken verwendet und kann nicht gelöscht werden.";
    $_SESSION['message_type'] = "danger";
    header("Location: /casting_powders.php");
    exit;
}

// Gießpulver löschen
$stmt = $conn->prepare("DELETE FROM casting_powder WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Gießpulver erfolgreich gelöscht.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Fehler beim Löschen des Gießpulvers: " . $conn->error;
    $_SESSION['message_type'] = "danger";
}

// Zurück zur Gießpulverübersicht
header("Location: /casting_powders.php");
exit;
?>
