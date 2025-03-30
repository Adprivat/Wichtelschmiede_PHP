<?php
// config/database.php - Datenbankverbindung herstellen

// Datenbankverbindungsdaten
$host = 'localhost';
$dbname = 'wichtelschmiede';
$username = 'root';
$password = '';

// Verbindung herstellen
$conn = new mysqli($host, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// UTF-8 Zeichensatz setzen
$conn->set_charset("utf8mb4");
