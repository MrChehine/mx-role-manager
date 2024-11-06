ALTER TABLE roles_targets
    ADD CONSTRAINT fk_roles_targets_target_id
        FOREIGN KEY (target_id) REFERENCES targets(id);