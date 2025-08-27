INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES 
('Admin Principal', 'admin@cyragro.com', SHA2('Admin1234', 256), 'administrador', NOW(), NOW());