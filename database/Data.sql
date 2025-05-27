USE cyrodb;

INSERT INTO productos (
    nombre, segmento, categoria, registro, contenido, presentaciones,
    intervalo_aplicacion, incompatibilidad, certificacion, controla,
    ficha_tecnica, hoja_seguridad, precio, cantidad_inventario, urlFoto,
    created_at, updated_at
) VALUES
-- Producto 1
('BIOINSECTICIDA', 'BIOCONTROL', 'Extracto acuoso', 'RSCO-MEZC-1101E-301-406-012',
 'Argemonina (3.50%), berberina (2.20%), ricinina (2.80%), a-terthienil (3.50%)',
 '12 x 1 L, 1 x 20 L, 1 a 3 L/ha', '7 días', NULL, NULL,
 'Araña roja (Oligonychus punicae), Trips (Thrips tabaci), Tetranychus urticae, Frankliniella occidentalis, Drosophila suzukii, Bemisia tabaci, Thrips palmi, Plutella xylostella, Trichoplusia ni, Brevicoryne brassicae, Diaphorina citri, Polyphagotarsonemus latus, Planococcus citri, Toxoptera aurantii, Lygus lineolaris, Dactylopius coccus, Raoiella indica',
 NULL, NULL, 0.00, 0, NULL, NOW(), NOW()),
('BIOINSECTICIDA', 'BIOCONTROL', 'Extracto de Neem', 'RSCO-INAC-0103I-303-009-080',
 'Extracto de Neem (Azadirachta indica) 80.0%, Concentrado emulsionable', '12 x 1 L, 1 x 20 L, 1 a 3 L/ha', '7 a 21 días', NULL, NULL,
 'Oligonychus punicae, Thrips tabaci, Tetranychus urticae, Thecla basilides, Frankliniella occidentalis, Bemisia tabaci, Plutella xylostella, Trichoplusia ni, Diaphorina citri, Toxoptera aurantii, Polyphagotarsonemus latus, Dactylopius coccus',
 NULL, NULL, 0.00, 0, NULL, NOW(), NOW()),
('BIOINSECTICIDA', 'BIOCONTROL', 'Extracto de Canela', 'RSCO-INAC-0104R-301-015-015',
 'Extracto de Canela (Cinnamomum zeylanicum) 15.0%, Emulsión aceite en agua', '12 x 1 L, 1 x 20 L, 1 a 3 L/ha', '7 a 21 días', NULL, NULL,
 'Oligonychus punicae, Thrips tabaci, Tetranychus urticae, Frankliniella occidentalis, Bemisia tabaci, Diaphorina citri, Polyphagotarsonemus latus, Planococcus citri, Dactylopius coccus, Aphis illinoisensis',
 NULL, NULL, 0.00, 0, NULL, NOW(), NOW()),
('BIOINSECTICIDA', 'BIOCONTROL', 'Sales potásicas de soya', 'RSCO-INAC-0101W-0426-375-50',
 'Sales potásicas de soya 50.0%, Concentrado soluble', '12 x 1 L, 1 x 20 L, 1 a 3 L/200 L', '7 días', NULL, NULL,
 'Tetranychus urticae, Oligonychus punicae, Dactylopius coccus, Diaphorina citri, Aphis gossypii, Frankliniella occidentalis, Thrips tabaci, Bemisia tabaci, Dysmicoccus brevipes, Aphis illinoisensis',
 NULL, NULL, 0.00, 0, NULL, NOW(), NOW()),
('BIOINSECTICIDA', 'BIOCONTROL', 'Mezcla Canela y Neem', 'RSCO-MEZC-1102B-301-009-070',
 'Extracto de Canela (55.0%), Extracto de Neem (15.0%), Concentrado emulsionable', '12 x 1 L, 1 x 20 L, 1 a 2 L/ha y 0.5-2.0 L/100 L', '7 a 8 días', NULL, NULL,
 'Aculops lycopersici, Tetranychus urticae, Bemisia tabaci, Thrips tabaci, Frankliniella occidentalis',
 NULL, NULL, 0.00, 0, NULL, NOW(), NOW());


-- 3. Insertar 10 tickets
-- Usamos empleado_id en [1,3] y cliente_id en [4,8], algunos tickets sin cliente (NULL)
INSERT INTO tickets (empleado_id, cliente_id, total) VALUES
(1, 4,  25.00),
(2, 5,  10.80),
(3, 6,   3.40),
(1, NULL,15.00),
(2, 7,  50.00),
(3, 8,  12.75),
(1, 4,  30.00),
(2, NULL, 5.50),
(3, 5,  22.20),
(1, 6,  18.90);

-- 4. Insertar 10 detalles (uno por ticket, producto aleatorio)
INSERT INTO detalles (ticket_id, producto_id, cantidad, precio_unit) VALUES
(1,  1, 10, 0.50),
(2,  2,  9, 1.20),
(3,  3,  4, 0.85),
(4,  5, 10, 0.90),
(5,  4, 20, 2.50),
(6,  7,  6, 1.75),
(7, 10,  2, 3.80),
(8,  8,  8, 0.65),
(9,  6, 12, 1.10),
(10, 9,  1, 4.20);
