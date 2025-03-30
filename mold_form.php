<?php
// mold_form.php - Formular zum Hinzufügen/Bearbeiten von Gießformen
session_start();
require_once 'config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mold = [
    'id' => 0,
    'name' => '',
    'fill_volume' => '',
    'image' => null
];

// Wenn ID vorhanden, Gießform aus der Datenbank laden
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM mold WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $mold = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Gießform nicht gefunden";
        $_SESSION['message_type'] = "danger";
        header("Location: /molds.php");
        exit;
    }
}

// Formular-Titel basierend auf Bearbeitungs- oder Erstellungsmodus
$title = $id > 0 ? 'Gießform bearbeiten' : 'Neue Gießform anlegen';

// Inhalt für das Gießform-Formular
$content = '
<h1>' . $title . '</h1>

<form action="/mold_save.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="' . $mold['id'] . '">
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="' . htmlspecialchars($mold['name']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="fill_volume">Füllvolumen</label>
        <input type="number" name="fill_volume" id="fill_volume" class="form-control" step="0.01" value="' . htmlspecialchars($mold['fill_volume']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="image">Bild</label>';

if ($mold['image']) {
    $content .= '
        <div class="mb-2">
            <img src="/image.php?type=mold&id=' . $mold['id'] . '" alt="Aktuelles Bild" class="img-thumbnail" style="max-width: 200px;">
        </div>';
}

$content .= '
        <input type="file" name="image" id="image" class="form-control">
    </div>
    
    <button type="submit" class="btn btn-primary">Speichern</button>
    <a href="/molds.php" class="btn btn-secondary">Abbrechen</a>
</form>
';

// Layout einbinden
include 'includes/layout.php';
?>
