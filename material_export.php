<?php
// material_export.php - Materialien als CSV exportieren
session_start();
require_once 'config/database.php';

// Authentifizierung prüfen

// Materialien aus der Datenbank abrufen
$sql = "SELECT id, name, source, price, unit_price FROM material ORDER BY name ASC";
$result = $conn->query($sql);
$materials = $result->fetch_all(MYSQLI_ASSOC);

// CSV-Header setzen
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="materialien.csv"');

// CSV-Ausgabe öffnen
$output = fopen('php://output', 'w');

// UTF-8 BOM für Excel-Kompatibilität
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// CSV-Header schreiben
fputcsv($output, ['ID', 'Name', 'Bezugsquelle', 'Preis', 'Preis pro Einheit'], ';');

// Materialien als CSV-Zeilen schreiben
foreach ($materials as $material) {
    fputcsv($output, [
        $material['id'],
        $material['name'],
        $material['source'],
        $material['price'],
        $material['unit_price']
    ], ';');
}

// Ausgabe beenden
fclose($output);
exit;
?>
