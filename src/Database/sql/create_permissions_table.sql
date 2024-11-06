CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    class_name VARCHAR(100),
    method_name VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME
);