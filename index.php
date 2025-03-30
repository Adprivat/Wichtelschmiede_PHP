<?php
// index.php - Startseite ohne Authentifizierung
session_start();

// Inhalt für die Startseite
$content = '
<h1>Willkommen</h1>
<p>Nutze das Menü, um Materialien, Gießpulver, Gießformen und Werkstücke zu verwalten.</p>
';

// Layout einbinden
include 'includes/layout.php';
?>
