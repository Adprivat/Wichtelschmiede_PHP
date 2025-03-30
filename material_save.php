<?php
// material_save.php - Material speichern (neu oder bearbeiten)
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /materials.php");
    exit;
}

// Formulardaten abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = $_POST['name'] ?? '';
$source = $_POST['source'] ?? '';
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$unit_price = isset($_POST['unit_price']) ? floatval($_POST['unit_price']) : 0;

// Validierung
if (empty($name) || empty($source) || $price <= 0 || $unit_price <= 0) {
    $_SESSION['message'] = "Bitte füllen Sie alle Pflichtfelder aus.";
    $_SESSION['message_type'] = "danger";
    header("Location: /material_form.php" . ($id > 0 ? "?id=$id" : ""));
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
        header("Location: /material_form.php" . ($id > 0 ? "?id=$id" : ""));
        exit;
    }
    
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $image_set = true;
}

// Datenbankoperation (Update oder Insert)
if ($id > 0) {
    // Bestehendes Material aktualisieren
    if ($image_set) {
        // Mit Bild aktualisieren
        $stmt = $conn->prepare("UPDATE material SET name = ?, source = ?, price = ?, unit_price = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssddsi", $name, $source, $price, $unit_price, $image, $id);
    } else {
        // Ohne Bild aktualisieren
        $stmt = $conn->prepare("UPDATE material SET name = ?, source = ?, price = ?, unit_price = ? WHERE id = ?");
        $stmt->bind_param("ssddi", $name, $source, $price, $unit_price, $id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Material erfolgreich aktualisiert.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Fehler beim Aktualisieren des Materials: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
} else {
    // Neues Material erstellen
    $stmt = $conn->prepare("INSERT INTO material (name, source, price, unit_price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdds", $name, $source, $price, $unit_price, $image);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Material erfolgreich erstellt.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Fehler beim Erstellen des Materials: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
}

// Zurück zur Materialübersicht
header("Location: /materials.php");
exit;
?>
