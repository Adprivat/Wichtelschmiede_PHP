<?php
// config/auth.php - Leere Authentifizierungsfunktionen (Authentifizierung entfernt)

// Dummy-Funktion für Kompatibilität
function authenticate($username, $password) {
    return true;
}

// Immer als angemeldet betrachten
function isLoggedIn() {
    return true;
}

// Keine Anmeldung erforderlich
function requireLogin() {
    // Keine Aktion erforderlich, da keine Anmeldung benötigt wird
    return;
}
