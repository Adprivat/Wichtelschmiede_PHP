<?php
// casting_powder_form.php - Formular zum Hinzufügen/Bearbeiten von Gießpulvern
session_start();
require_once 'config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$casting_powder = [
    'id' => 0,
    'name' => '',
    'water_ratio' => '',
    'powder_ratio' => '',
    'price_per_gram' => ''
];

// Wenn ID vorhanden, Gießpulver aus der Datenbank laden
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM casting_powder WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $casting_powder = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Gießpulver nicht gefunden";
        $_SESSION['message_type'] = "danger";
        header("Location: /casting_powders.php");
        exit;
    }
}

// Formular-Titel basierend auf Bearbeitungs- oder Erstellungsmodus
$title = $id > 0 ? 'Gießpulver bearbeiten' : 'Neues Gießpulver anlegen';

// Inhalt für das Gießpulver-Formular
$content = '
<h1>' . $title . '</h1>

<form action="/casting_powder_save.php" method="post">
    <input type="hidden" name="id" value="' . $casting_powder['id'] . '">
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="' . htmlspecialchars($casting_powder['name']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="water_ratio">Wasser-Verhältnis</label>
        <input type="number" name="water_ratio" id="water_ratio" class="form-control" step="0.01" value="' . htmlspecialchars($casting_powder['water_ratio']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="powder_ratio">Pulver-Verhältnis</label>
        <input type="number" name="powder_ratio" id="powder_ratio" class="form-control" step="0.01" value="' . htmlspecialchars($casting_powder['powder_ratio']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="price_per_gram">Preis pro Gramm</label>
        <input type="number" name="price_per_gram" id="price_per_gram" class="form-control" step="0.0001" value="' . htmlspecialchars($casting_powder['price_per_gram']) . '" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Speichern</button>
    <a href="/casting_powders.php" class="btn btn-secondary">Abbrechen</a>
</form>
';

// Layout einbinden
include 'includes/layout.php';
?>
