USE cyrodb;

-- 2. Insertar 10 productos
INSERT INTO productos (sku, name, description, price, cantidad_inventario) VALUES
('SKU001','Manzana Roja',    'Manzana importada',     0.50, 200),
('SKU002','Pan Integral',    'Pan artesanal',         1.20, 150),
('SKU003','Leche Entera',    'Leche de vaca 1L',      0.85, 100),
('SKU004','Queso Oaxaca',    'Queso fresco 250g',     2.50,  80),
('SKU005','Arroz Blanco',    'Arroz 1kg',             0.90, 120),
('SKU006','Frijol Negro',    'Frijoles 1kg',          1.10, 110),
('SKU007','Huevos',          'Caja 12 piezas',        1.75,  90),
('SKU008','Azúcar',          'Azúcar 1kg',            0.65, 130),
('SKU009','Aceite de Oliva', 'Aceite virgen 500ml',   4.20,  60),
('SKU010','Café Molido',     'Café 250g',             3.80,  70);

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
