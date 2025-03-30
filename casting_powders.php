<?php
// casting_powders.php - Gießpulver anzeigen und verwalten
session_start();
require_once 'config/database.php';

// Gießpulver aus der Datenbank abrufen
$sql = "SELECT * FROM casting_powder ORDER BY name ASC";
$result = $conn->query($sql);
$casting_powders = $result->fetch_all(MYSQLI_ASSOC);

// Inhalt für die Gießpulver-Seite
$content = '
<h1>Gießpulver</h1>

<a href="/casting_powder_form.php" class="btn btn-primary mb-3">Neues Gießpulver anlegen</a>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Wasser-Verhältnis</th>
            <th>Pulver-Verhältnis</th>
            <th>Preis pro Gramm</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>';

if (count($casting_powders) > 0) {
    foreach ($casting_powders as $powder) {
        $content .= '
        <tr>
            <td>' . htmlspecialchars($powder['name']) . '</td>
            <td>' . htmlspecialchars($powder['water_ratio']) . '</td>
            <td>' . htmlspecialchars($powder['powder_ratio']) . '</td>
            <td>' . htmlspecialchars($powder['price_per_gram']) . '</td>
            <td>
                <a href="/casting_powder_form.php?id=' . $powder['id'] . '" class="btn btn-sm btn-warning">Bearbeiten</a>
                <form action="/casting_powder_delete.php" method="post" style="display:inline;" onsubmit="return confirm(\'Soll das Gießpulver wirklich gelöscht werden?\');">
                    <input type="hidden" name="id" value="' . $powder['id'] . '">
                    <button type="submit" class="btn btn-sm btn-danger">Löschen</button>
                </form>
            </td>
        </tr>';
    }
} else {
    $content .= '<tr><td colspan="5">Keine Gießpulver gefunden.</td></tr>';
}

$content .= '
    </tbody>
</table>';

// Layout einbinden
include 'includes/layout.php';
?>
