CREATE TABLE auth_items
(
    id          INT AUTO_INCREMENT
        PRIMARY KEY,
    item        VARCHAR(255)                       NOT NULL,
    description TEXT                               NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at  DATETIME                           NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE roles
(
    id          INT AUTO_INCREMENT
        PRIMARY KEY,
    roleName    VARCHAR(255)                       NOT NULL,
    roleIcon    VARCHAR(255)                       NULL,
    description TEXT                               NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at  DATETIME                           NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE auth_assignments
(
    code       INT                                NOT NULL,
    item       INT                                NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at DATETIME                           NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT auth_assignments_auth_groups_id_fk
        FOREIGN KEY (code) REFERENCES roles (id)
            ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT auth_assignments_auth_items_id_fk
        FOREIGN KEY (item) REFERENCES auth_items (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE users
(
    id              INT AUTO_INCREMENT
        PRIMARY KEY,
    email           VARCHAR(255)                         NOT NULL,
    firstName       VARCHAR(255)                         NOT NULL,
    lastName        VARCHAR(255)                         NOT NULL,
    password        VARCHAR(255)                         NOT NULL,
    email_confirmed TINYINT(1) DEFAULT 0                 NOT NULL,
    created_at      DATETIME   DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE reset_tokens
(
    token        VARCHAR(64)                        NOT NULL
        PRIMARY KEY,
    userId       INT                                NOT NULL,
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    completed_at DATETIME                           NULL,
    CONSTRAINT reset_tokens_users_id_fk
        FOREIGN KEY (userId) REFERENCES users (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE user_roles
(
    userId     INT                                NOT NULL,
    roleId     INT                                NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at DATETIME                           NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT user_roles_roles_id_fk
        FOREIGN KEY (roleId) REFERENCES roles (id)
            ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT user_roles_users_id_fk
        FOREIGN KEY (userId) REFERENCES users (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

