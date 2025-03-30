# Wichtelschmiede - Dokumentation

## Übersicht

Die "Wichtelschmiede" ist eine Webanwendung zur Verwaltung von Materialien, Gießpulvern, Gießformen und Werkstücken. Die Anwendung ermöglicht es Benutzern, diese Elemente zu erstellen, anzuzeigen, zu bearbeiten und zu löschen.

## Technologien im Original-Repository

- **Backend**: Node.js mit Express
- **Frontend**: EJS-Templates mit Bootstrap CSS
- **Datenbank**: Sequelize ORM (vermutlich mit MySQL/MariaDB)
- **Authentifizierung**: Basic Authentication

## Datenmodelle

Basierend auf der Analyse des `models.js`-Files wurden folgende Datenmodelle identifiziert:

### 1. Material
- **Beschreibung**: Speichert Informationen über Materialien
- **Attribute**:
  - `name` (String, nicht null)
  - `source` (String, nicht null)
  - `price` (Float, nicht null)
  - `unit_price` (Float, nicht null)
  - `image` (BLOB, optional)

### 2. CastingPowder (Gießpulver)
- **Beschreibung**: Speichert Informationen über Gießpulver mit Mischverhältnis
- **Attribute**:
  - `name` (String, nicht null)
  - `water_ratio` (Float, nicht null)
  - `powder_ratio` (Float, nicht null)
  - `price_per_gram` (Decimal(10,4), nicht null)

### 3. Mold (Gießform)
- **Beschreibung**: Speichert Informationen über Gießformen mit Füllmenge
- **Attribute**:
  - `name` (String, nicht null)
  - `fill_volume` (Float, nicht null)
  - `image` (BLOB, optional)

### 4. WorkPiece (Werkstück)
- **Beschreibung**: Speichert Informationen über fertige Werkstücke
- **Attribute**:
  - `name` (String, nicht null)
  - `image` (BLOB, optional)

### 5. WorkPieceMaterial
- **Beschreibung**: Zwischentabelle zur Speicherung der verwendeten Materialien inkl. Mengen
- **Attribute**:
  - `quantity` (Float, nicht null)

### 6. WorkPieceMold
- **Beschreibung**: Zwischentabelle zur Speicherung der verwendeten Gießformen
- **Attribute**:
  - `quantity` (Float, nicht null, Standardwert: 1)

## Beziehungen zwischen den Modellen

- **WorkPiece zu Material**: Viele-zu-viele Beziehung über WorkPieceMaterial
- **Material zu WorkPiece**: Viele-zu-viele Beziehung über WorkPieceMaterial
- **WorkPiece zu Mold**: Viele-zu-viele Beziehung über WorkPieceMold
- **Mold zu WorkPiece**: Viele-zu-viele Beziehung über WorkPieceMold
- **CastingPowder zu WorkPieceMold**: Eine-zu-viele Beziehung (CastingPowder wird in WorkPieceMold als Zusatzinformation gespeichert)

## Funktionalitäten

### Allgemeine Funktionen
- **Navigation**: Menü mit Links zu allen Hauptbereichen (Materialien, Gießpulver, Gießformen, Werkstücke)
- **Layout**: Responsive Design mit Bootstrap

### Materialien-Verwaltung
- **Anzeigen**: Tabellarische Übersicht aller Materialien mit Name, Bezugsquelle, Preis, Preis pro Einheit und Bild
- **Suchen**: Suchfunktion nach Materialien
- **Hinzufügen**: Formular zum Anlegen neuer Materialien mit Bildupload-Möglichkeit
- **Bearbeiten**: Formular zum Ändern bestehender Materialien
- **Löschen**: Funktion zum Entfernen von Materialien mit Bestätigungsdialog
- **CSV-Export**: Möglichkeit zum Exportieren der Materialliste als CSV

### Gießpulver-Verwaltung
- **Anzeigen**: Tabellarische Übersicht aller Gießpulver mit Name, Wasser-Pulver-Verhältnis und Preis pro Gramm
- **Hinzufügen**: Formular zum Anlegen neuer Gießpulver
- **Bearbeiten**: Formular zum Ändern bestehender Gießpulver
- **Löschen**: Funktion zum Entfernen von Gießpulvern mit Bestätigungsdialog

### Gießformen-Verwaltung
- **Anzeigen**: Tabellarische Übersicht aller Gießformen mit Name, Füllvolumen und Bild
- **Hinzufügen**: Formular zum Anlegen neuer Gießformen mit Bildupload-Möglichkeit
- **Bearbeiten**: Formular zum Ändern bestehender Gießformen
- **Löschen**: Funktion zum Entfernen von Gießformen mit Bestätigungsdialog

### Werkstücke-Verwaltung
- **Anzeigen**: Tabellarische Übersicht aller Werkstücke mit Name, verwendeten Materialien, verwendeten Gießformen und Bild
- **Hinzufügen**: Formular zum Anlegen neuer Werkstücke mit Bildupload-Möglichkeit und Auswahl von Materialien und Gießformen
- **Bearbeiten**: Formular zum Ändern bestehender Werkstücke
- **Löschen**: Funktion zum Entfernen von Werkstücken mit Bestätigungsdialog

### Authentifizierung
- **Basic Authentication**: Passwortschutz für die Anwendung
- **Umgebungsvariablen**: Nutzung von Umgebungsvariablen für Benutzername und Passwort

## API-Endpunkte

Basierend auf der Analyse des `server.js`-Files wurden folgende API-Endpunkte identifiziert:

### Startseite
- `GET /`: Zeigt die Startseite an

### Materialien
- `GET /materials`: Zeigt alle Materialien an, unterstützt Suchparameter
- `GET /materials/new`: Formular zum Anlegen eines neuen Materials
- `GET /materials/:id/edit`: Formular zum Bearbeiten eines Materials
- `POST /materials/new`: Speichert ein neues Material
- `POST /materials/:id/edit`: Aktualisiert ein bestehendes Material
- `POST /materials/:id/delete`: Löscht ein Material
- `GET /materials/export`: Exportiert Materialien als CSV

### Gießpulver
- `GET /casting-powders`: Zeigt alle Gießpulver an
- `GET /casting-powders/new`: Formular zum Anlegen eines neuen Gießpulvers
- `GET /casting-powders/:id/edit`: Formular zum Bearbeiten eines Gießpulvers
- `POST /casting-powders/new`: Speichert ein neues Gießpulver
- `POST /casting-powders/:id/edit`: Aktualisiert ein bestehendes Gießpulver
- `POST /casting-powders/:id/delete`: Löscht ein Gießpulver

### Gießformen
- `GET /molds`: Zeigt alle Gießformen an
- `GET /molds/new`: Formular zum Anlegen einer neuen Gießform
- `GET /molds/:id/edit`: Formular zum Bearbeiten einer Gießform
- `POST /molds/new`: Speichert eine neue Gießform
- `POST /molds/:id/edit`: Aktualisiert eine bestehende Gießform
- `POST /molds/:id/delete`: Löscht eine Gießform

### Werkstücke
- `GET /workpieces`: Zeigt alle Werkstücke an
- `GET /workpieces/new`: Formular zum Anlegen eines neuen Werkstücks
- `GET /workpieces/:id/edit`: Formular zum Bearbeiten eines Werkstücks
- `POST /workpieces/new`: Speichert ein neues Werkstück
- `POST /workpieces/:id/edit`: Aktualisiert ein bestehendes Werkstück
- `POST /workpieces/:id/delete`: Löscht ein Werkstück

## Besonderheiten

- **Bildverwaltung**: Bilder werden für Materialien, Gießformen und Werkstücke unterstützt
- **CSV-Export**: Materialien können als CSV exportiert werden
- **Suchfunktion**: Materialien können durchsucht werden
- **Responsive Design**: Die Anwendung ist für verschiedene Bildschirmgrößen optimiert
