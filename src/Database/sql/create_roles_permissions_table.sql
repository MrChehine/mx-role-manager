CREATE TABLE IF NOT EXISTS roles_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,

    CONSTRAINT fk_roles_permissions_role_id FOREIGN KEY (role_id) REFERENCES roles(id),
    CONSTRAINT fk_roles_permissions_permission_id FOREIGN KEY (permission_id) REFERENCES permissions(id),

    PRIMARY KEY (role_id, permission_id)
);