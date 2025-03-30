<?php
// materials.php - Materialien anzeigen und verwalten
session_start();
require_once 'config/database.php';

// Suchparameter verarbeiten
$search = isset($_GET['q']) ? $_GET['q'] : '';
$searchCondition = '';
$params = [];

if (!empty($search)) {
    $searchCondition = "WHERE name LIKE ? OR source LIKE ?";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Materialien aus der Datenbank abrufen
$sql = "SELECT * FROM material $searchCondition ORDER BY name ASC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$materials = $result->fetch_all(MYSQLI_ASSOC);

// Inhalt für die Materialien-Seite
$content = '
<h1>Materialien</h1>

<!-- Suchformular -->
<form action="/materials.php" method="get" class="mb-3">
    <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Suche Materialien" value="' . htmlspecialchars($search) . '">
        <button type="submit" class="btn btn-primary mt-2">Suchen</button>
    </div>
</form>

<a href="/material_form.php" class="btn btn-primary mb-3">Neues Material anlegen</a>
<a href="/material_export.php" class="btn btn-secondary mb-3 ml-2">CSV Export</a>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Bezugsquelle</th>
            <th>Preis</th>
            <th>Preis pro Einheit</th>
            <th>Bild</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>';

if (count($materials) > 0) {
    foreach ($materials as $material) {
        $content .= '
        <tr>
            <td>' . htmlspecialchars($material['name']) . '</td>
            <td>' . htmlspecialchars($material['source']) . '</td>
            <td>' . htmlspecialchars($material['price']) . '</td>
            <td>' . htmlspecialchars($material['unit_price']) . '</td>
            <td>';
        
        if ($material['image']) {
            $content .= '<img src="/image.php?type=material&id=' . $material['id'] . '" alt="Bild" class="img-thumbnail">';
        } else {
            $content .= 'Kein Bild';
        }
        
        $content .= '</td>
            <td>
                <a href="/material_form.php?id=' . $material['id'] . '" class="btn btn-sm btn-warning">Bearbeiten</a>
                <form action="/material_delete.php" method="post" style="display:inline;" onsubmit="return confirm(\'Soll das Material wirklich gelöscht werden?\');">
                    <input type="hidden" name="id" value="' . $material['id'] . '">
                    <button type="submit" class="btn btn-sm btn-danger">Löschen</button>
                </form>
            </td>
        </tr>';
    }
} else {
    $content .= '<tr><td colspan="6">Keine Materialien gefunden.</td></tr>';
}

$content .= '
    </tbody>
</table>';

// Layout einbinden
include 'includes/layout.php';
?>
