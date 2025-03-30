<?php
// material_form.php - Formular zum Hinzufügen/Bearbeiten von Materialien
session_start();
require_once 'config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$material = [
    'id' => 0,
    'name' => '',
    'source' => '',
    'price' => '',
    'unit_price' => '',
    'image' => null
];

// Wenn ID vorhanden, Material aus der Datenbank laden
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM material WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $material = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Material nicht gefunden";
        $_SESSION['message_type'] = "danger";
        header("Location: /materials.php");
        exit;
    }
}

// Formular-Titel basierend auf Bearbeitungs- oder Erstellungsmodus
$title = $id > 0 ? 'Material bearbeiten' : 'Neues Material anlegen';

// Inhalt für das Material-Formular
$content = '
<h1>' . $title . '</h1>

<form action="/material_save.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="' . $material['id'] . '">
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="' . htmlspecialchars($material['name']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="source">Bezugsquelle</label>
        <input type="text" name="source" id="source" class="form-control" value="' . htmlspecialchars($material['source']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="price">Preis</label>
        <input type="number" name="price" id="price" class="form-control" step="0.01" value="' . htmlspecialchars($material['price']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="unit_price">Preis pro Einheit</label>
        <input type="number" name="unit_price" id="unit_price" class="form-control" step="0.01" value="' . htmlspecialchars($material['unit_price']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="image">Bild</label>';

if ($material['image']) {
    $content .= '
        <div class="mb-2">
            <img src="/image.php?type=material&id=' . $material['id'] . '" alt="Aktuelles Bild" class="img-thumbnail" style="max-width: 200px;">
        </div>';
}

$content .= '
        <input type="file" name="image" id="image" class="form-control">
    </div>
    
    <button type="submit" class="btn btn-primary">Speichern</button>
    <a href="/materials.php" class="btn btn-secondary">Abbrechen</a>
</form>
';

// Layout einbinden
include 'includes/layout.php';
?>
