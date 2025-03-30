# Wichtelschmiede PHP

Eine PHP-Implementierung der Wichtelschmiede-Anwendung, die ausschließlich HTML, CSS, PHP und MySQL verwendet.

## Übersicht

Diese Anwendung ist eine Neuimplementierung der [Wichtelschmiede](https://github.com/Adprivat/Wichtelschmiede) mit folgenden Technologien:
- HTML
- CSS
- PHP
- MySQL

Die Anwendung ermöglicht die Verwaltung von Materialien, Gießpulvern, Gießformen und Werkstücken für eine Wichtelschmiede.

## Funktionen

- **Materialien-Verwaltung**: Anzeigen, Suchen, Hinzufügen, Bearbeiten und Löschen von Materialien mit Bildupload-Möglichkeit und CSV-Export
- **Gießpulver-Verwaltung**: Anzeigen, Hinzufügen, Bearbeiten und Löschen von Gießpulvern mit Wasser-Pulver-Verhältnis
- **Gießformen-Verwaltung**: Anzeigen, Hinzufügen, Bearbeiten und Löschen von Gießformen mit Bildupload-Möglichkeit
- **Werkstücke-Verwaltung**: Anzeigen, Hinzufügen, Bearbeiten und Löschen von Werkstücken mit Bildupload-Möglichkeit und Verknüpfung zu Materialien und Gießformen

## Projektstruktur

```
wichtelschmiede_php/
├── config/                 # Konfigurationsdateien
│   ├── auth.php            # Authentifizierungsfunktionen
│   └── database.php        # Datenbankverbindung
├── css/                    # CSS-Dateien
│   └── styles.css          # Hauptstilvorlage
├── includes/               # Wiederverwendbare PHP-Dateien
│   └── layout.php          # Gemeinsames Layout-Template
├── js/                     # JavaScript-Dateien
│   └── script.js           # Hauptskriptdatei
├── uploads/                # Verzeichnis für hochgeladene Dateien
│   ├── material/           # Materialbilder
│   ├── mold/               # Gießformbilder
│   └── workpiece/          # Werkstückbilder
├── index.php               # Startseite
├── login.php               # Anmeldeseite
├── materials.php           # Materialübersicht
├── material_form.php       # Formular zum Hinzufügen/Bearbeiten von Materialien
├── material_save.php       # Speichern von Materialien
├── material_delete.php     # Löschen von Materialien
├── material_export.php     # CSV-Export von Materialien
├── casting_powders.php     # Gießpulverübersicht
├── casting_powder_form.php # Formular zum Hinzufügen/Bearbeiten von Gießpulvern
├── casting_powder_save.php # Speichern von Gießpulvern
├── casting_powder_delete.php # Löschen von Gießpulvern
├── molds.php               # Gießformübersicht
├── mold_form.php           # Formular zum Hinzufügen/Bearbeiten von Gießformen
├── mold_save.php           # Speichern von Gießformen
├── mold_delete.php         # Löschen von Gießformen
├── workpieces.php          # Werkstückübersicht
├── workpiece_form.php      # Formular zum Hinzufügen/Bearbeiten von Werkstücken
├── workpiece_save.php      # Speichern von Werkstücken
├── workpiece_delete.php    # Löschen von Werkstücken
├── image.php               # Anzeigen von Bildern aus der Datenbank
├── database_schema.sql     # SQL-Skript zum Erstellen der Datenbank
├── INSTALL.md              # Installationsanleitung
└── USER_GUIDE.md           # Benutzerhandbuch
```

## Installation

Siehe [INSTALL.md](INSTALL.md) für detaillierte Installationsanweisungen.

## Verwendung

Siehe [USER_GUIDE.md](USER_GUIDE.md) für eine ausführliche Anleitung zur Verwendung der Anwendung.

## Datenbank

Die Anwendung verwendet eine MySQL-Datenbank mit folgenden Tabellen:
- `material`: Speichert Informationen über Materialien
- `casting_powder`: Speichert Informationen über Gießpulver
- `mold`: Speichert Informationen über Gießformen
- `workpiece`: Speichert Informationen über Werkstücke
- `workpiece_material`: Verknüpfungstabelle zwischen Werkstücken und Materialien
- `workpiece_mold`: Verknüpfungstabelle zwischen Werkstücken und Gießformen

Das vollständige Datenbankschema finden Sie in der Datei `database_schema.sql`.

## Lizenz

Dieses Projekt steht unter der MIT-Lizenz.
