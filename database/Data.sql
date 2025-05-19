USE cyrodb;

-- Insertar 10 productos adaptados a la nueva estructura
INSERT INTO productos (
    nombre, segmento, categoria, registro, contenido, presentaciones,
    intervalo_aplicacion, incompatibilidad, certificacion, controla,
    ficha_tecnica, hoja_seguridad, precio, cantidad_inventario, urlFoto, created_at, updated_at
) VALUES
-- Producto 1
('Manzana Roja', 'Frutas', 'Frescos', 'REG-123-FR', 'Manzana Red Delicious orgánica', '1 kg', 'Cada 5 días', 'No mezclar con cítricos', 'Orgánico USDA', 'Mejora digestión y antioxidante', 'manzana_ficha.pdf', 'manzana_seguridad.pdf', 0.50, 200, 'https://cdn.shopify.com/s/files/1/0273/0615/2728/products/redapple.jpg', NOW(), NOW()),
-- Producto 2
('Pan Integral', 'Panadería', 'Pan', 'REG-456-PN', 'Hecho con trigo integral, sin conservadores', '500 g', 'Diario', 'Evitar humedad', 'Pan Artesanal SINABIO', 'Favorece digestión, rico en fibra', 'pan_ficha.pdf', 'pan_seguridad.pdf', 1.20, 150, 'https://www.pequerecetas.com/wp-content/uploads/2020/09/pan-integral-casero-receta.jpg', NOW(), NOW()),
-- Producto 3
('Leche Entera', 'Lácteos', 'Leche', 'REG-789-LC', 'Leche de vaca pasteurizada 3.5% grasa', '1 L', 'Diario', 'No hervir', 'Certificación ISO 22000', 'Fuente de calcio y vitamina D', 'leche_ficha.pdf', 'leche_seguridad.pdf', 0.85, 100, 'https://colun.cl/assets/uploads/2022/07/leche-entera-1l.jpg', NOW(), NOW()),
-- Producto 4
('Queso Oaxaca', 'Lácteos', 'Quesos', 'REG-258-QO', 'Queso tipo oaxaca fresco hilado', '250 g', 'Cada semana', 'No congelar', 'HACCP Certificado', 'Fuente de proteína y calcio', 'queso_ficha.pdf', 'queso_seguridad.pdf', 2.50, 80, 'https://cdn7.kiwilimon.com/recetaimagen/18270/640x640/36279.jpg.webp', NOW(), NOW()),
-- Producto 5
('Arroz Blanco', 'Granos', 'Cereales', 'REG-159-AR', 'Arroz pulido de grano largo', '1 kg', 'Cada 3 días', 'Evitar humedad', 'Certificación Kosher', 'Aporta energía, bajo en grasa', 'arroz_ficha.pdf', 'arroz_seguridad.pdf', 0.90, 120, 'https://cdn7.kiwilimon.com/recetaimagen/34949/640x640/6005.jpg.webp', NOW(), NOW()),
-- Producto 6
('Frijol Negro', 'Granos', 'Legumbres', 'REG-357-FN', 'Frijol negro selección especial', '1 kg', 'Semanal', 'Evitar combinación con sales minerales', 'Certificado SAGARPA', 'Aporta proteína vegetal y fibra', 'frijol_ficha.pdf', 'frijol_seguridad.pdf', 1.10, 110, 'https://www.gob.mx/cms/uploads/article/main_image/80628/frijol.jpg', NOW(), NOW()),
-- Producto 7
('Huevos', 'Proteínas', 'Huevos', 'REG-753-HV', 'Huevos de gallina libre de jaula', '12 piezas', 'Cada 2 días', 'Evitar cambios bruscos de temperatura', 'Libre de antibióticos', 'Ricos en proteína y vitamina B12', 'huevos_ficha.pdf', 'huevos_seguridad.pdf', 1.75, 90, 'https://cdn.pixabay.com/photo/2017/01/20/15/06/eggs-1995056_1280.jpg', NOW(), NOW()),
-- Producto 8
('Azúcar', 'Endulzantes', 'Azúcar', 'REG-852-AZ', 'Azúcar refinada estándar', '1 kg', 'A conveniencia', 'No almacenar con productos húmedos', 'Norma NOM-117-SSA1', 'Fuente rápida de energía', 'azucar_ficha.pdf', 'azucar_seguridad.pdf', 0.65, 130, 'https://upload.wikimedia.org/wikipedia/commons/f/f7/Sugar_2xmacro.jpg', NOW(), NOW()),
-- Producto 9
('Aceite de Oliva', 'Aceites', 'Aceite de Oliva', 'REG-456-AO', 'Aceite extra virgen prensado en frío', '500 ml', 'Cada 3 días', 'Evitar freír en exceso', 'Orgánico certificado europeo', 'Reduce colesterol y es antioxidante', 'aceite_ficha.pdf', 'aceite_seguridad.pdf', 4.20, 60, 'https://www.directoalpaladar.com.mx/files/2021/02/aceite-oliva.jpg', NOW(), NOW()),
-- Producto 10
('Café Molido', 'Bebidas', 'Café', 'REG-951-CF', 'Café 100% arábica molido medio', '250 g', 'Diario', 'No refrigerar', 'Certificación Rainforest Alliance', 'Estimulante natural, rico en antioxidantes', 'cafe_ficha.pdf', 'cafe_seguridad.pdf', 3.80, 70, 'https://cdn.shopify.com/s/files/1/0293/9277/2285/products/4502_1080x.jpg', NOW(), NOW());

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
