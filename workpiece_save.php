<?php
// workpiece_save.php - Werkstück speichern (neu oder bearbeiten)
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Nur POST-Anfragen verarbeiten
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /workpieces.php");
    exit;
}

// Formulardaten abrufen
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = $_POST['name'] ?? '';
$materials = $_POST['materials'] ?? [];
$molds = $_POST['molds'] ?? [];

// Validierung
if (empty($name)) {
    $_SESSION['message'] = "Bitte geben Sie einen Namen ein.";
    $_SESSION['message_type'] = "danger";
    header("Location: /workpiece_form.php" . ($id > 0 ? "?id=$id" : ""));
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
        header("Location: /workpiece_form.php" . ($id > 0 ? "?id=$id" : ""));
        exit;
    }
    
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $image_set = true;
}

// Transaktion starten
$conn->begin_transaction();

try {
    // Werkstück speichern (Update oder Insert)
    if ($id > 0) {
        // Bestehendes Werkstück aktualisieren
        if ($image_set) {
            // Mit Bild aktualisieren
            $stmt = $conn->prepare("UPDATE workpiece SET name = ?, image = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $image, $id);
        } else {
            // Ohne Bild aktualisieren
            $stmt = $conn->prepare("UPDATE workpiece SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $name, $id);
        }
        
        $stmt->execute();
    } else {
        // Neues Werkstück erstellen
        $stmt = $conn->prepare("INSERT INTO workpiece (name, image) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $image);
        $stmt->execute();
        $id = $conn->insert_id;
    }
    
    // Bestehende Materialien und Gießformen entfernen
    $stmt = $conn->prepare("DELETE FROM workpiece_material WHERE workpiece_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $stmt = $conn->prepare("DELETE FROM workpiece_mold WHERE workpiece_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Materialien speichern
    if (!empty($materials)) {
        $stmt = $conn->prepare("INSERT INTO workpiece_material (workpiece_id, material_id, quantity) VALUES (?, ?, ?)");
        
        foreach ($materials as $material_id => $material_data) {
            if (isset($material_data['selected']) && !empty($material_data['quantity'])) {
                $material_id = intval($material_id);
                $quantity = floatval($material_data['quantity']);
                
                $stmt->bind_param("iid", $id, $material_id, $quantity);
                $stmt->execute();
            }
        }
    }
    
    // Gießformen speichern
    if (!empty($molds)) {
        $stmt = $conn->prepare("INSERT INTO workpiece_mold (workpiece_id, mold_id, casting_powder_id, quantity) VALUES (?, ?, ?, ?)");
        
        foreach ($molds as $mold_id => $mold_data) {
            if (isset($mold_data['selected'])) {
                $mold_id = intval($mold_id);
                $quantity = intval($mold_data['quantity']);
                $casting_powder_id = !empty($mold_data['casting_powder_id']) ? intval($mold_data['casting_powder_id']) : null;
                
                $stmt->bind_param("iiii", $id, $mold_id, $casting_powder_id, $quantity);
                $stmt->execute();
            }
        }
    }
    
    // Transaktion bestätigen
    $conn->commit();
    
    $_SESSION['message'] = "Werkstück erfolgreich gespeichert.";
    $_SESSION['message_type'] = "success";
} catch (Exception $e) {
    // Transaktion zurückrollen bei Fehler
    $conn->rollback();
    
    $_SESSION['message'] = "Fehler beim Speichern des Werkstücks: " . $e->getMessage();
    $_SESSION['message_type'] = "danger";
}

// Zurück zur Werkstückübersicht
header("Location: /workpieces.php");
exit;
?>
