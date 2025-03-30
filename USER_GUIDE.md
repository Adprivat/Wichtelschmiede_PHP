# Wichtelschmiede PHP - Benutzerhandbuch

Dieses Handbuch beschreibt die Verwendung der Wichtelschmiede-Anwendung.

## Einführung

Die Wichtelschmiede-Anwendung ist ein Verwaltungssystem für eine Gießerei, mit dem Sie Materialien, Gießpulver, Gießformen und Werkstücke verwalten können. Die Anwendung ermöglicht es Ihnen, diese Elemente zu erstellen, anzuzeigen, zu bearbeiten und zu löschen.

## Starten der Anwendung

Öffnen Sie die Anwendung in Ihrem Browser, indem Sie die URL Ihres Webservers aufrufen.

## Hauptmenü

Auf der Startseite sehen Sie das Hauptmenü, über das Sie auf die verschiedenen Bereiche der Anwendung zugreifen können:

- **Materialien**: Verwaltung von Materialien
- **Gießpulver**: Verwaltung von Gießpulvern
- **Gießformen**: Verwaltung von Gießformen
- **Werkstücke**: Verwaltung von Werkstücken

## Materialien verwalten

### Materialien anzeigen

1. Klicken Sie im Hauptmenü auf "Materialien".
2. Sie sehen eine Liste aller Materialien mit Name, Bezugsquelle, Preis, Preis pro Einheit und Bild.
3. Verwenden Sie das Suchfeld, um nach bestimmten Materialien zu suchen.

### Neues Material anlegen

1. Klicken Sie auf der Materialseite auf "Neues Material anlegen".
2. Füllen Sie das Formular aus:
   - **Name**: Name des Materials
   - **Bezugsquelle**: Woher das Material bezogen wird
   - **Preis**: Gesamtpreis des Materials
   - **Preis pro Einheit**: Preis pro Einheit des Materials
   - **Bild**: Optional können Sie ein Bild des Materials hochladen
3. Klicken Sie auf "Speichern".

### Material bearbeiten

1. Klicken Sie in der Materialliste auf "Bearbeiten" neben dem Material, das Sie bearbeiten möchten.
2. Ändern Sie die gewünschten Informationen.
3. Klicken Sie auf "Speichern".

### Material löschen

1. Klicken Sie in der Materialliste auf "Löschen" neben dem Material, das Sie löschen möchten.
2. Bestätigen Sie die Löschung.

### Materialien exportieren

1. Klicken Sie auf der Materialseite auf "CSV Export".
2. Die Materialien werden als CSV-Datei heruntergeladen.

## Gießpulver verwalten

### Gießpulver anzeigen

1. Klicken Sie im Hauptmenü auf "Gießpulver".
2. Sie sehen eine Liste aller Gießpulver mit Name, Wasser-Verhältnis, Pulver-Verhältnis und Preis pro Gramm.

### Neues Gießpulver anlegen

1. Klicken Sie auf der Gießpulverseite auf "Neues Gießpulver anlegen".
2. Füllen Sie das Formular aus:
   - **Name**: Name des Gießpulvers
   - **Wasser-Verhältnis**: Verhältnis des Wassers im Gießpulver
   - **Pulver-Verhältnis**: Verhältnis des Pulvers im Gießpulver
   - **Preis pro Gramm**: Preis pro Gramm des Gießpulvers
3. Klicken Sie auf "Speichern".

### Gießpulver bearbeiten

1. Klicken Sie in der Gießpulverliste auf "Bearbeiten" neben dem Gießpulver, das Sie bearbeiten möchten.
2. Ändern Sie die gewünschten Informationen.
3. Klicken Sie auf "Speichern".

### Gießpulver löschen

1. Klicken Sie in der Gießpulverliste auf "Löschen" neben dem Gießpulver, das Sie löschen möchten.
2. Bestätigen Sie die Löschung.

## Gießformen verwalten

### Gießformen anzeigen

1. Klicken Sie im Hauptmenü auf "Gießformen".
2. Sie sehen eine Liste aller Gießformen mit Name, Füllvolumen und Bild.

### Neue Gießform anlegen

1. Klicken Sie auf der Gießformenseite auf "Neue Gießform anlegen".
2. Füllen Sie das Formular aus:
   - **Name**: Name der Gießform
   - **Füllvolumen**: Füllvolumen der Gießform
   - **Bild**: Optional können Sie ein Bild der Gießform hochladen
3. Klicken Sie auf "Speichern".

### Gießform bearbeiten

1. Klicken Sie in der Gießformenliste auf "Bearbeiten" neben der Gießform, die Sie bearbeiten möchten.
2. Ändern Sie die gewünschten Informationen.
3. Klicken Sie auf "Speichern".

### Gießform löschen

1. Klicken Sie in der Gießformenliste auf "Löschen" neben der Gießform, die Sie löschen möchten.
2. Bestätigen Sie die Löschung.

## Werkstücke verwalten

### Werkstücke anzeigen

1. Klicken Sie im Hauptmenü auf "Werkstücke".
2. Sie sehen eine Liste aller Werkstücke mit Name, verwendeten Materialien, verwendeten Gießformen und Bild.

### Neues Werkstück anlegen

1. Klicken Sie auf der Werkstückseite auf "Neues Werkstück anlegen".
2. Füllen Sie das Formular aus:
   - **Name**: Name des Werkstücks
   - **Bild**: Optional können Sie ein Bild des Werkstücks hochladen
   - **Materialien**: Wählen Sie die Materialien aus, die für das Werkstück verwendet werden, und geben Sie die Menge an
   - **Gießformen**: Wählen Sie die Gießformen aus, die für das Werkstück verwendet werden, geben Sie die Anzahl an und wählen Sie optional ein Gießpulver
3. Klicken Sie auf "Speichern".

### Werkstück bearbeiten

1. Klicken Sie in der Werkstückliste auf "Bearbeiten" neben dem Werkstück, das Sie bearbeiten möchten.
2. Ändern Sie die gewünschten Informationen.
3. Klicken Sie auf "Speichern".

### Werkstück löschen

1. Klicken Sie in der Werkstückliste auf "Löschen" neben dem Werkstück, das Sie löschen möchten.
2. Bestätigen Sie die Löschung.

## Tipps und Tricks

- **Materialsuche**: Verwenden Sie die Suchfunktion auf der Materialseite, um schnell bestimmte Materialien zu finden.
- **Bildupload**: Bilder sollten im JPEG-, PNG- oder GIF-Format sein und eine angemessene Größe haben.
- **Beziehungen**: Beachten Sie, dass Materialien, Gießpulver und Gießformen, die in Werkstücken verwendet werden, nicht gelöscht werden können.
- **CSV-Export**: Exportieren Sie Materialien als CSV, um sie in anderen Anwendungen wie Excel zu verwenden.
