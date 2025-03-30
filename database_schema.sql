-- MySQL Datenbankschema für Wichtelschmiede

-- Datenbank erstellen
CREATE DATABASE IF NOT EXISTS wichtelschmiede;
USE wichtelschmiede;

-- Tabelle für Materialien
CREATE TABLE IF NOT EXISTS material (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    source VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    unit_price FLOAT NOT NULL,
    image LONGBLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabelle für Gießpulver
CREATE TABLE IF NOT EXISTS casting_powder (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    water_ratio FLOAT NOT NULL,
    powder_ratio FLOAT NOT NULL,
    price_per_gram DECIMAL(10,4) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabelle für Gießformen
CREATE TABLE IF NOT EXISTS mold (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    fill_volume FLOAT NOT NULL,
    image LONGBLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabelle für Werkstücke
CREATE TABLE IF NOT EXISTS workpiece (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image LONGBLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Zwischentabelle für Werkstücke und Materialien
CREATE TABLE IF NOT EXISTS workpiece_material (
    id INT AUTO_INCREMENT PRIMARY KEY,
    workpiece_id INT NOT NULL,
    material_id INT NOT NULL,
    quantity FLOAT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (workpiece_id) REFERENCES workpiece(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES material(id) ON DELETE CASCADE
);

-- Zwischentabelle für Werkstücke und Gießformen
CREATE TABLE IF NOT EXISTS workpiece_mold (
    id INT AUTO_INCREMENT PRIMARY KEY,
    workpiece_id INT NOT NULL,
    mold_id INT NOT NULL,
    casting_powder_id INT,
    quantity FLOAT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (workpiece_id) REFERENCES workpiece(id) ON DELETE CASCADE,
    FOREIGN KEY (mold_id) REFERENCES mold(id) ON DELETE CASCADE,
    FOREIGN KEY (casting_powder_id) REFERENCES casting_powder(id) ON DELETE SET NULL
);

-- Benutzer-Tabelle entfernt (Authentifizierung nicht mehr benötigt)

-- Indizes für bessere Leistung
CREATE INDEX idx_material_name ON material(name);
CREATE INDEX idx_casting_powder_name ON casting_powder(name);
CREATE INDEX idx_mold_name ON mold(name);
CREATE INDEX idx_workpiece_name ON workpiece(name);
CREATE INDEX idx_workpiece_material_workpiece_id ON workpiece_material(workpiece_id);
CREATE INDEX idx_workpiece_material_material_id ON workpiece_material(material_id);
CREATE INDEX idx_workpiece_mold_workpiece_id ON workpiece_mold(workpiece_id);
CREATE INDEX idx_workpiece_mold_mold_id ON workpiece_mold(mold_id);
CREATE INDEX idx_workpiece_mold_casting_powder_id ON workpiece_mold(casting_powder_id);

-- Standardbenutzer entfernt (Authentifizierung nicht mehr benötigt)
