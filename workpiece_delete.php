<?php
// workpiece_delete.php - Werkstück löschen
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /workpieces.php");
    exit;
}

// ID abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    $_SESSION['message'] = "Ungültige Werkstück-ID.";
    $_SESSION['message_type'] = "danger";
    header("Location: /workpieces.php");
    exit;
}

// Transaktion starten
$conn->begin_transaction();

try {
    // Verknüpfte Materialien löschen
    $stmt = $conn->prepare("DELETE FROM workpiece_material WHERE workpiece_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Verknüpfte Gießformen löschen
    $stmt = $conn->prepare("DELETE FROM workpiece_mold WHERE workpiece_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Werkstück löschen
    $stmt = $conn->prepare("DELETE FROM workpiece WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Transaktion bestätigen
    $conn->commit();
    
    $_SESSION['message'] = "Werkstück erfolgreich gelöscht.";
    $_SESSION['message_type'] = "success";
} catch (Exception $e) {
    // Transaktion zurückrollen bei Fehler
    $conn->rollback();
    
    $_SESSION['message'] = "Fehler beim Löschen des Werkstücks: " . $e->getMessage();
    $_SESSION['message_type'] = "danger";
}

// Zurück zur Werkstückübersicht
header("Location: /workpieces.php");
exit;
?>
