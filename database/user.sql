INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES 
('Admin Principal', 'admin@cyragro.com', SHA2('Admin1234', 256), 'administrador', NOW(), NOW());

UPDATE users 
SET password = '$2y$10$iNGTO1JExq8coLIdGLk3QOwN17D6OOIGn8/e0vEHCNiSGxm6EnrUa'
WHERE email = 'admin@cyragro.com';
