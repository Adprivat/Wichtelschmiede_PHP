<?php
// mold_save.php - Gießform speichern (neu oder bearbeiten)
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /molds.php");
    exit;
}

// Formulardaten abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = $_POST['name'] ?? '';
$fill_volume = isset($_POST['fill_volume']) ? floatval($_POST['fill_volume']) : 0;

// Validierung
if (empty($name) || $fill_volume <= 0) {
    $_SESSION['message'] = "Bitte füllen Sie alle Pflichtfelder aus.";
    $_SESSION['message_type'] = "danger";
    header("Location: /mold_form.php" . ($id > 0 ? "?id=$id" : ""));
    exit;
}

// Bild verarbeiten
$image = null;
$image_set = false;

if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
    // Bild-Upload verarbeiten
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        $_SESSION['message'] = "Nur JPEG, PNG und GIF Bilder sind erlaubt.";
        $_SESSION['message_type'] = "danger";
        header("Location: /mold_form.php" . ($id > 0 ? "?id=$id" : ""));
        exit;
    }
    
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $image_set = true;
}

// Datenbankoperation (Update oder Insert)
if ($id > 0) {
    // Bestehende Gießform aktualisieren
    if ($image_set) {
        // Mit Bild aktualisieren
        $stmt = $conn->prepare("UPDATE mold SET name = ?, fill_volume = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $name, $fill_volume, $image, $id);
    } else {
        // Ohne Bild aktualisieren
        $stmt = $conn->prepare("UPDATE mold SET name = ?, fill_volume = ? WHERE id = ?");
        $stmt->bind_param("sdi", $name, $fill_volume, $id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Gießform erfolgreich aktualisiert.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Fehler beim Aktualisieren der Gießform: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
} else {
    // Neue Gießform erstellen
    $stmt = $conn->prepare("INSERT INTO mold (name, fill_volume, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $fill_volume, $image);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Gießform erfolgreich erstellt.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Fehler beim Erstellen der Gießform: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
}

// Zurück zur Gießformübersicht
header("Location: /molds.php");
exit;
?>
