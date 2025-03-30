<?php
// workpiece_form.php - Formular zum Hinzufügen/Bearbeiten von Werkstücken
session_start();
require_once 'config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$workpiece = [
    'id' => 0,
    'name' => '',
    'image' => null
];

// Wenn ID vorhanden, Werkstück aus der Datenbank laden
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM workpiece WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $workpiece = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Werkstück nicht gefunden";
        $_SESSION['message_type'] = "danger";
        header("Location: /workpieces.php");
        exit;
    }
}

// Alle Materialien abrufen
$materials_result = $conn->query("SELECT * FROM material ORDER BY name ASC");
$materials = $materials_result->fetch_all(MYSQLI_ASSOC);

// Alle Gießformen abrufen
$molds_result = $conn->query("SELECT * FROM mold ORDER BY name ASC");
$molds = $molds_result->fetch_all(MYSQLI_ASSOC);

// Alle Gießpulver abrufen
$casting_powders_result = $conn->query("SELECT * FROM casting_powder ORDER BY name ASC");
$casting_powders = $casting_powders_result->fetch_all(MYSQLI_ASSOC);

// Ausgewählte Materialien für dieses Werkstück abrufen
$selected_materials = [];
if ($id > 0) {
    $stmt = $conn->prepare("
        SELECT material_id, quantity 
        FROM workpiece_material 
        WHERE workpiece_id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $selected_materials[$row['material_id']] = $row['quantity'];
    }
}

// Ausgewählte Gießformen für dieses Werkstück abrufen
$selected_molds = [];
if ($id > 0) {
    $stmt = $conn->prepare("
        SELECT mold_id, casting_powder_id, quantity 
        FROM workpiece_mold 
        WHERE workpiece_id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $selected_molds[$row['mold_id']] = [
            'casting_powder_id' => $row['casting_powder_id'],
            'quantity' => $row['quantity']
        ];
    }
}

// Formular-Titel basierend auf Bearbeitungs- oder Erstellungsmodus
$title = $id > 0 ? 'Werkstück bearbeiten' : 'Neues Werkstück anlegen';

// Inhalt für das Werkstück-Formular
$content = '
<h1>' . $title . '</h1>

<form action="/workpiece_save.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="' . $workpiece['id'] . '">
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="' . htmlspecialchars($workpiece['name']) . '" required>
    </div>
    
    <div class="form-group">
        <label for="image">Bild</label>';

if ($workpiece['image']) {
    $content .= '
        <div class="mb-2">
            <img src="/image.php?type=workpiece&id=' . $workpiece['id'] . '" alt="Aktuelles Bild" class="img-thumbnail" style="max-width: 200px;">
        </div>';
}

$content .= '
        <input type="file" name="image" id="image" class="form-control">
    </div>
    
    <h3>Materialien</h3>
    <div class="form-group" id="materials-container">';

if (count($materials) > 0) {
    foreach ($materials as $material) {
        $quantity = isset($selected_materials[$material['id']]) ? $selected_materials[$material['id']] : '';
        $checked = !empty($quantity) ? 'checked' : '';
        
        $content .= '
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="materials[' . $material['id'] . '][selected]" id="material-' . $material['id'] . '" ' . $checked . '>
            <label class="form-check-label" for="material-' . $material['id'] . '">' . htmlspecialchars($material['name']) . '</label>
            <input type="number" name="materials[' . $material['id'] . '][quantity]" class="form-control" placeholder="Menge" value="' . htmlspecialchars($quantity) . '" step="0.01">
        </div>';
    }
} else {
    $content .= '<p>Keine Materialien verfügbar. <a href="/material_form.php">Erstellen Sie zuerst ein Material</a>.</p>';
}

$content .= '
    </div>
    
    <h3>Gießformen</h3>
    <div class="form-group" id="molds-container">';

if (count($molds) > 0) {
    foreach ($molds as $mold) {
        $selected = isset($selected_molds[$mold['id']]);
        $checked = $selected ? 'checked' : '';
        $quantity = $selected ? $selected_molds[$mold['id']]['quantity'] : 1;
        $casting_powder_id = $selected ? $selected_molds[$mold['id']]['casting_powder_id'] : '';
        
        $content .= '
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="molds[' . $mold['id'] . '][selected]" id="mold-' . $mold['id'] . '" ' . $checked . '>
            <label class="form-check-label" for="mold-' . $mold['id'] . '">' . htmlspecialchars($mold['name']) . '</label>
            <div class="row">
                <div class="col-md-6">
                    <label>Anzahl:</label>
                    <input type="number" name="molds[' . $mold['id'] . '][quantity]" class="form-control" value="' . htmlspecialchars($quantity) . '" min="1" step="1">
                </div>
                <div class="col-md-6">
                    <label>Gießpulver:</label>
                    <select name="molds[' . $mold['id'] . '][casting_powder_id]" class="form-control">
                        <option value="">Kein Gießpulver</option>';
        
        foreach ($casting_powders as $powder) {
            $selected_powder = ($casting_powder_id == $powder['id']) ? 'selected' : '';
            $content .= '<option value="' . $powder['id'] . '" ' . $selected_powder . '>' . htmlspecialchars($powder['name']) . '</option>';
        }
        
        $content .= '
                    </select>
                </div>
            </div>
        </div>';
    }
} else {
    $content .= '<p>Keine Gießformen verfügbar. <a href="/mold_form.php">Erstellen Sie zuerst eine Gießform</a>.</p>';
}

$content .= '
    </div>
    
    <button type="submit" class="btn btn-primary">Speichern</button>
    <a href="/workpieces.php" class="btn btn-secondary">Abbrechen</a>
</form>

<style>
.col-md-6 {
    width: 48%;
    display: inline-block;
    margin-right: 2%;
}
</style>
';

// Layout einbinden
include 'includes/layout.php';
?>
