<?php
// casting_powder_save.php - Gießpulver speichern (neu oder bearbeiten)
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /casting_powders.php");
    exit;
}

// Formulardaten abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = $_POST['name'] ?? '';
$water_ratio = isset($_POST['water_ratio']) ? floatval($_POST['water_ratio']) : 0;
$powder_ratio = isset($_POST['powder_ratio']) ? floatval($_POST['powder_ratio']) : 0;
$price_per_gram = isset($_POST['price_per_gram']) ? floatval($_POST['price_per_gram']) : 0;

// Validierung
if (empty($name) || $water_ratio <= 0 || $powder_ratio <= 0 || $price_per_gram <= 0) {
    $_SESSION['message'] = "Bitte füllen Sie alle Pflichtfelder aus.";
    $_SESSION['message_type'] = "danger";
    header("Location: /casting_powder_form.php" . ($id > 0 ? "?id=$id" : ""));
    exit;
}

// Datenbankoperation (Update oder Insert)
if ($id > 0) {
    // Bestehendes Gießpulver aktualisieren
    $stmt = $conn->prepare("UPDATE casting_powder SET name = ?, water_ratio = ?, powder_ratio = ?, price_per_gram = ? WHERE id = ?");
    $stmt->bind_param("sdddi", $name, $water_ratio, $powder_ratio, $price_per_gram, $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Gießpulver erfolgreich aktualisiert.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Fehler beim Aktualisieren des Gießpulvers: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
} else {
    // Neues Gießpulver erstellen
    $stmt = $conn->prepare("INSERT INTO casting_powder (name, water_ratio, powder_ratio, price_per_gram) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sddd", $name, $water_ratio, $powder_ratio, $price_per_gram);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Gießpulver erfolgreich erstellt.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Fehler beim Erstellen des Gießpulvers: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
}

// Zurück zur Gießpulverübersicht
header("Location: /casting_powders.php");
exit;
?>
