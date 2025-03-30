<?php
// workpieces.php - Werkstücke anzeigen und verwalten
session_start();
require_once 'config/database.php';

// Werkstücke aus der Datenbank abrufen
$sql = "SELECT * FROM workpiece ORDER BY name ASC";
$result = $conn->query($sql);
$workpieces = $result->fetch_all(MYSQLI_ASSOC);

// Inhalt für die Werkstücke-Seite
$content = '
<h1>Werkstücke</h1>

<a href="/workpiece_form.php" class="btn btn-primary mb-3">Neues Werkstück anlegen</a>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Materialien</th>
            <th>Gießformen</th>
            <th>Bild</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>';

if (count($workpieces) > 0) {
    foreach ($workpieces as $workpiece) {
        // Materialien für dieses Werkstück abrufen
        $stmt = $conn->prepare("
            SELECT m.name, wm.quantity 
            FROM workpiece_material wm
            JOIN material m ON wm.material_id = m.id
            WHERE wm.workpiece_id = ?
        ");
        $stmt->bind_param("i", $workpiece['id']);
        $stmt->execute();
        $materials_result = $stmt->get_result();
        $materials = $materials_result->fetch_all(MYSQLI_ASSOC);
        
        // Gießformen für dieses Werkstück abrufen
        $stmt = $conn->prepare("
            SELECT m.name, wm.quantity, cp.name as casting_powder_name
            FROM workpiece_mold wm
            JOIN mold m ON wm.mold_id = m.id
            LEFT JOIN casting_powder cp ON wm.casting_powder_id = cp.id
            WHERE wm.workpiece_id = ?
        ");
        $stmt->bind_param("i", $workpiece['id']);
        $stmt->execute();
        $molds_result = $stmt->get_result();
        $molds = $molds_result->fetch_all(MYSQLI_ASSOC);
        
        $content .= '
        <tr>
            <td>' . htmlspecialchars($workpiece['name']) . '</td>
            <td>';
        
        if (count($materials) > 0) {
            $content .= '<ul>';
            foreach ($materials as $material) {
                $content .= '<li>' . htmlspecialchars($material['name']) . ' (' . htmlspecialchars($material['quantity']) . ')</li>';
            }
            $content .= '</ul>';
        } else {
            $content .= 'Keine Materialien';
        }
        
        $content .= '</td>
            <td>';
        
        if (count($molds) > 0) {
            $content .= '<ul>';
            foreach ($molds as $mold) {
                $content .= '<li>' . htmlspecialchars($mold['name']) . ' (' . htmlspecialchars($mold['quantity']) . ')';
                if (!empty($mold['casting_powder_name'])) {
                    $content .= ' mit ' . htmlspecialchars($mold['casting_powder_name']);
                }
                $content .= '</li>';
            }
            $content .= '</ul>';
        } else {
            $content .= 'Keine Gießformen';
        }
        
        $content .= '</td>
            <td>';
        
        if ($workpiece['image']) {
            $content .= '<img src="/image.php?type=workpiece&id=' . $workpiece['id'] . '" alt="Bild" class="img-thumbnail">';
        } else {
            $content .= 'Kein Bild';
        }
        
        $content .= '</td>
            <td>
                <a href="/workpiece_form.php?id=' . $workpiece['id'] . '" class="btn btn-sm btn-warning">Bearbeiten</a>
                <form action="/workpiece_delete.php" method="post" style="display:inline;" onsubmit="return confirm(\'Soll das Werkstück wirklich gelöscht werden?\');">
                    <input type="hidden" name="id" value="' . $workpiece['id'] . '">
                    <button type="submit" class="btn btn-sm btn-danger">Löschen</button>
                </form>
            </td>
        </tr>';
    }
} else {
    $content .= '<tr><td colspan="5">Keine Werkstücke gefunden.</td></tr>';
}

$content .= '
    </tbody>
</table>';

// Layout einbinden
include 'includes/layout.php';
?>
