CREATE
OR REPLACE TABLE auth_items
(
    id          INT AUTO_INCREMENT
        PRIMARY KEY,
    item        VARCHAR(255)                         NOT NULL,
    description TEXT                                 NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at  DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP()
);

CREATE
OR REPLACE TABLE roles
(
    id          INT AUTO_INCREMENT
        PRIMARY KEY,
    roleName    VARCHAR(255)                         NOT NULL,
    roleIcon    VARCHAR(255)                         NULL,
    description TEXT                                 NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at  DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP()
);

CREATE
OR REPLACE TABLE auth_assignments
(
    ROLE       INT                                  NOT NULL,
    item       INT                                  NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP(),
    CONSTRAINT auth_assignments_auth_groups_id_fk
        FOREIGN KEY (ROLE) REFERENCES roles (id)
            ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT auth_assignments_auth_items_id_fk
        FOREIGN KEY (item) REFERENCES auth_items (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE
OR REPLACE TABLE users
(
    id              INT AUTO_INCREMENT
        PRIMARY KEY,
    email           VARCHAR(255)                           NOT NULL,
    firstName       VARCHAR(255)                           NOT NULL,
    lastName        VARCHAR(255)                           NOT NULL,
    password        VARCHAR(255)                           NOT NULL,
    email_confirmed TINYINT(1) DEFAULT 0                   NOT NULL,
    token           VARCHAR(255)                           NOT NULL,
    created_at      DATETIME   DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at      DATETIME                               NULL ON UPDATE CURRENT_TIMESTAMP()
);

CREATE
OR REPLACE TABLE reset_tokens
(
    token        VARCHAR(64)                          NOT NULL
        PRIMARY KEY,
    userId       INT                                  NOT NULL,
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    completed_at DATETIME                             NULL,
    CONSTRAINT reset_tokens_users_id_fk
        FOREIGN KEY (userId) REFERENCES users (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE
OR REPLACE TABLE user_roles
(
    userId     INT                                  NOT NULL,
    roleId     INT                                  NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP(),
    CONSTRAINT user_roles_roles_id_fk
        FOREIGN KEY (roleId) REFERENCES roles (id)
            ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT user_roles_users_id_fk
        FOREIGN KEY (userId) REFERENCES users (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `auth_items` (`id`, `item`, `description`, `created_at`, `updated_at`)
VALUES (1, '@admin/', NULL, '2000-01-01 00:00:00', NULL),
       (2, '@admin/auth/forgot-password', NULL, '2000-01-01 00:00:00', NULL),
       (3, '@admin/auth/login', NULL, '2000-01-01 00:00:00', NULL),
       (4, '@admin/auth/logout', NULL, '2000-01-01 00:00:00', NULL),
       (5, '@admin/auth/register', NULL, '2000-01-01 00:00:00', NULL),
       (6, '@admin/auth/reset-password', NULL, '2000-01-01 00:00:00', NULL),
       (7, '@admin/routes-management/items/create', NULL, '2000-01-01 00:00:00', NULL),
       (8, '@admin/routes-management/items/list-all', NULL, '2000-01-01 00:00:00', NULL),
       (9, '@admin/routes-management/items/manage/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (10, '@admin/routes-management/items/delete/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (11, '@admin/routes-management/roles/create', NULL, '2000-01-01 00:00:00', NULL),
       (12, '@admin/routes-management/roles/delete/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (13, '@admin/routes-management/roles/list-all', NULL, '2000-01-01 00:00:00', NULL),
       (14, '@admin/routes-management/roles/manage/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (15, '@admin/site/dashboard', NULL, '2000-01-01 00:00:00', NULL),
       (16, '@admin/site/profile', NULL, '2000-01-01 00:00:00', NULL),
       (17, '@admin/users/create', NULL, '2000-01-01 00:00:00', NULL),
       (18, '@admin/users/delete/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (19, '@admin/users/list-all', NULL, '2000-01-01 00:00:00', NULL),
       (20, '@admin/users/manage/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (21, '@api/', NULL, '2000-01-01 00:00:00', NULL),
       (22, '@api/routes-management/items/list', NULL, '2000-01-01 00:00:00', NULL),
       (23, '@api/routes-management/roles/list', NULL, '2000-01-01 00:00:00', NULL),
       (24, '@api/users/list', NULL, '2000-01-01 00:00:00', NULL),
       (25, '@public/', NULL, '2000-01-01 00:00:00', NULL);

INSERT INTO `roles` (`id`, `roleName`, `roleIcon`, `description`, `created_at`, `updated_at`)
VALUES (1, 'Administrator', '<i class=\"fa-solid fa-crown\" style=\"color: #f5bd02;\"></i>', NULL,
        '2000-01-01 00:00:00', NULL),
       (2, 'Visitor', NULL, NULL, '2000-01-01 00:00:00', NULL);


INSERT INTO `users` (`id`, `email`, `firstName`, `lastName`, `password`, `email_confirmed`, `token`, `created_at`,
                     `updated_at`)
VALUES (1, 'admin@example.com', 'Superadmin', 'Superadmin',
        '$argon2id$v=19$m=65536,t=4,p=3$OUtyZ2RKckloMDNXbUtsUw$OITax6QoMsOvWo1+1Bd0IzSTt4pPsg6U88i36Bwak68', 1,
        'ViYkamFu53UUgBUTGHNSeql6oZpeoVWp', '2000-01-01 00:00:00', NULL);


INSERT INTO `user_roles` (`userId`, `roleId`, `created_at`, `updated_at`)
VALUES (1, 1, '2000-01-01 00:00:00', '2024-01-03 23:17:17');

INSERT INTO `auth_assignments` (`role`, `item`, `created_at`, `updated_at`)
VALUES (1, 1, '2000-01-01 00:00:00', NULL),
       (1, 2, '2000-01-01 00:00:00', NULL),
       (1, 3, '2000-01-01 00:00:00', NULL),
       (1, 4, '2000-01-01 00:00:00', NULL),
       (1, 5, '2000-01-01 00:00:00', NULL),
       (1, 6, '2000-01-01 00:00:00', NULL),
       (1, 7, '2000-01-01 00:00:00', NULL),
       (1, 8, '2000-01-01 00:00:00', NULL),
       (1, 9, '2000-01-01 00:00:00', NULL),
       (1, 10, '2000-01-01 00:00:00', NULL),
       (1, 11, '2000-01-01 00:00:00', NULL),
       (1, 12, '2000-01-01 00:00:00', NULL),
       (1, 13, '2000-01-01 00:00:00', NULL),
       (1, 14, '2000-01-01 00:00:00', NULL),
       (1, 15, '2000-01-01 00:00:00', NULL),
       (1, 16, '2000-01-01 00:00:00', NULL),
       (1, 17, '2000-01-01 00:00:00', NULL),
       (1, 18, '2000-01-01 00:00:00', NULL),
       (1, 19, '2000-01-01 00:00:00', NULL),
       (1, 20, '2000-01-01 00:00:00', NULL),
       (1, 21, '2000-01-01 00:00:00', NULL),
       (1, 22, '2000-01-01 00:00:00', NULL),
       (1, 23, '2000-01-01 00:00:00', NULL),
       (1, 24, '2000-01-01 00:00:00', NULL),
       (1, 25, '2000-01-01 00:00:00', NULL),
       (2, 1, '2000-01-01 00:00:00', NULL),
       (2, 2, '2000-01-01 00:00:00', NULL),
       (2, 3, '2000-01-01 00:00:00', NULL),
       (2, 4, '2000-01-01 00:00:00', NULL);
    (2, 5, '2000-01-01 00:00:00', NULL)
    ,
       (2, 6, '2000-01-01 00:00:00', NULL),
       (2, 21, '2000-01-01 00:00:00', NULL),
       (2, 25, '2000-01-01 00:00:00', NULL),