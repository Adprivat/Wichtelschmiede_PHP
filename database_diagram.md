# Datenbankschema für Wichtelschmiede

## Tabellen und Beziehungen

```
+----------------+       +-------------------+       +-------------+
|    material    |       | workpiece_material|       |  workpiece  |
+----------------+       +-------------------+       +-------------+
| id             |<----->| id                |<----->| id          |
| name           |       | workpiece_id      |       | name        |
| source         |       | material_id       |       | image       |
| price          |       | quantity          |       | created_at  |
| unit_price     |       | created_at        |       | updated_at  |
| image          |       | updated_at        |       +-------------+
| created_at     |       +-------------------+             ^
| updated_at     |                                         |
+----------------+                                         |
                                                           |
+----------------+       +-------------------+             |
|casting_powder  |       |   workpiece_mold  |             |
+----------------+       +-------------------+             |
| id             |<----->| id                |<------------+
| name           |       | workpiece_id      |
| water_ratio    |       | mold_id           |
| powder_ratio   |       | casting_powder_id |
| price_per_gram |       | quantity          |
| created_at     |       | created_at        |
| updated_at     |       | updated_at        |
+----------------+       +-------------------+
                                 ^
                                 |
                                 |
                         +----------------+
                         |      mold      |
                         +----------------+
                         | id             |
                         | name           |
                         | fill_volume    |
                         | image          |
                         | created_at     |
                         | updated_at     |
                         +----------------+

+----------------+
|      user      |
+----------------+
| id             |
| username       |
| password       |
| created_at     |
| updated_at     |
+----------------+
```

## Erklärung der Beziehungen

1. **Material zu Workpiece**: Viele-zu-viele Beziehung über die Zwischentabelle `workpiece_material`
   - Ein Material kann in vielen Werkstücken verwendet werden
   - Ein Werkstück kann viele verschiedene Materialien verwenden
   - Die Zwischentabelle speichert zusätzlich die Menge des verwendeten Materials

2. **Mold zu Workpiece**: Viele-zu-viele Beziehung über die Zwischentabelle `workpiece_mold`
   - Eine Gießform kann für viele Werkstücke verwendet werden
   - Ein Werkstück kann mit vielen verschiedenen Gießformen erstellt werden
   - Die Zwischentabelle speichert zusätzlich die Anzahl der verwendeten Formen

3. **CastingPowder zu WorkpieceMold**: Eins-zu-viele Beziehung
   - Ein Gießpulver kann in vielen Werkstück-Gießform-Kombinationen verwendet werden
   - Eine Werkstück-Gießform-Kombination verwendet maximal ein Gießpulver

4. **User**: Eigenständige Tabelle für die Authentifizierung
   - Speichert Benutzernamen und Passwörter für den Zugriff auf die Anwendung

## Indizes

Für eine bessere Leistung wurden Indizes auf folgenden Spalten erstellt:
- Alle Primärschlüssel (automatisch)
- Alle Fremdschlüssel
- Name-Spalten für schnelle Suche
