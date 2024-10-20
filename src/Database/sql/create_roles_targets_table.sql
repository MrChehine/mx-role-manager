CREATE TABLE IF NOT EXISTS roles_targets (
    role_id INT NOT NULL,
    target_id INT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,

    CONSTRAINT fk_roles_targets_role_id FOREIGN KEY (role_id) REFERENCES roles(id),

    PRIMARY KEY (role_id, target_id)
);