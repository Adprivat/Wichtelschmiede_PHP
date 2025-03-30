# Wichtelschmiede PHP - Installationsanleitung

Diese Anleitung beschreibt, wie Sie die Wichtelschmiede-Anwendung auf einem lokalen Server installieren und ausführen können.

## Voraussetzungen

- PHP 7.4 oder höher
- MySQL 5.7 oder höher
- Webserver (Apache, Nginx oder PHP's eingebauter Entwicklungsserver)
- GD-Bibliothek für PHP (für Bildverarbeitung)

## Installation

1. **Dateien kopieren**
   
   Kopieren Sie alle Dateien in das Webserver-Verzeichnis (z.B. `/var/www/html/wichtelschmiede` oder ähnlich).

2. **Datenbank einrichten**
   
   Führen Sie das SQL-Skript `database_schema.sql` in Ihrer MySQL-Datenbank aus:
   
   ```bash
   mysql -u username -p < database_schema.sql
   ```
   
   Oder importieren Sie die Datei über ein Tool wie phpMyAdmin.

3. **Datenbankverbindung konfigurieren**
   
   Öffnen Sie die Datei `config/database.php` und passen Sie die Verbindungsdaten an:
   
   ```php
   $host = 'localhost';     // Datenbankserver
   $dbname = 'wichtelschmiede'; // Datenbankname
   $username = 'root';      // Datenbankbenutzer
   $password = '';          // Datenbankpasswort
   ```

4. **Berechtigungen setzen**
   
   Stellen Sie sicher, dass das Verzeichnis `uploads` und seine Unterverzeichnisse für den Webserver beschreibbar sind:
   
   ```bash
   chmod -R 755 uploads/
   chown -R www-data:www-data uploads/  # Für Apache auf Ubuntu/Debian
   ```

5. **Webserver konfigurieren**
   
   Für Apache, erstellen Sie eine `.htaccess` Datei im Hauptverzeichnis mit folgendem Inhalt:
   
   ```
   <IfModule mod_rewrite.c>
     RewriteEngine On
     RewriteBase /
     RewriteCond %{REQUEST_FILENAME} !-f
     RewriteCond %{REQUEST_FILENAME} !-d
     RewriteRule ^(.*)$ index.php [QSA,L]
   </IfModule>
   ```

## Starten der Anwendung

### Mit PHP's eingebautem Entwicklungsserver

Für Entwicklungs- und Testzwecke können Sie den eingebauten PHP-Server verwenden:

```bash
cd /pfad/zur/wichtelschmiede
php -S localhost:8000
```

Die Anwendung ist dann unter `http://localhost:8000` erreichbar.

### Mit Apache oder Nginx

Wenn Sie Apache oder Nginx verwenden, konfigurieren Sie einen virtuellen Host, der auf das Installationsverzeichnis zeigt, und rufen Sie die Anwendung über den konfigurierten Hostnamen auf.

<!-- Anmeldung entfernt, da keine Authentifizierung mehr benötigt wird -->

## Fehlerbehebung

- **Datenbankverbindungsfehler**: Überprüfen Sie die Verbindungsdaten in `config/database.php`.
- **Bildupload funktioniert nicht**: Stellen Sie sicher, dass die GD-Bibliothek für PHP installiert ist und die Berechtigungen für das `uploads`-Verzeichnis korrekt gesetzt sind.
- **Seite nicht gefunden**: Überprüfen Sie die Webserver-Konfiguration und stellen Sie sicher, dass die URL-Umschreibung korrekt eingerichtet ist.
