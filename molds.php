<?php
// molds.php - Gießformen anzeigen und verwalten
session_start();
require_once 'config/database.php';

// Gießformen aus der Datenbank abrufen
$sql = "SELECT * FROM mold ORDER BY name ASC";
$result = $conn->query($sql);
$molds = $result->fetch_all(MYSQLI_ASSOC);

// Inhalt für die Gießformen-Seite
$content = '
<h1>Gießformen</h1>

<a href="/mold_form.php" class="btn btn-primary mb-3">Neue Gießform anlegen</a>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Füllvolumen</th>
            <th>Bild</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>';

if (count($molds) > 0) {
    foreach ($molds as $mold) {
        $content .= '
        <tr>
            <td>' . htmlspecialchars($mold['name']) . '</td>
            <td>' . htmlspecialchars($mold['fill_volume']) . '</td>
            <td>';
        
        if ($mold['image']) {
            $content .= '<img src="/image.php?type=mold&id=' . $mold['id'] . '" alt="Bild" class="img-thumbnail">';
        } else {
            $content .= 'Kein Bild';
        }
        
        $content .= '</td>
            <td>
                <a href="/mold_form.php?id=' . $mold['id'] . '" class="btn btn-sm btn-warning">Bearbeiten</a>
                <form action="/mold_delete.php" method="post" style="display:inline;" onsubmit="return confirm(\'Soll die Gießform wirklich gelöscht werden?\');">
                    <input type="hidden" name="id" value="' . $mold['id'] . '">
                    <button type="submit" class="btn btn-sm btn-danger">Löschen</button>
                </form>
            </td>
        </tr>';
    }
} else {
    $content .= '<tr><td colspan="4">Keine Gießformen gefunden.</td></tr>';
}

$content .= '
    </tbody>
</table>';

// Layout einbinden
include 'includes/layout.php';
?>
