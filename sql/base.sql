CREATE TABLE if NOT EXISTS auth_items
(
    id
    INT
    auto_increment
    PRIMARY
    KEY,
    item
    VARCHAR
(
    255
) NOT NULL,
    description text NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at datetime NULL ON UPDATE CURRENT_TIMESTAMP
    );

CREATE TABLE if NOT EXISTS roles
(
    id
    INT
    auto_increment
    PRIMARY
    KEY,
    roleName
    VARCHAR
(
    255
) NOT NULL,
    roleIcon VARCHAR
(
    255
) NULL,
    description text NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at datetime NULL ON UPDATE CURRENT_TIMESTAMP
    );

CREATE TABLE if NOT EXISTS auth_assignments
(
    ROLE
    INT
    NOT
    NULL,
    item
    INT
    NOT
    NULL,
    created_at
    datetime
    DEFAULT
    CURRENT_TIMESTAMP
    NOT
    NULL,
    updated_at
    datetime
    NULL
    ON
    UPDATE
    CURRENT_TIMESTAMP,
    CONSTRAINT
    auth_assignments_auth_groups_id_fk
    FOREIGN
    KEY
(
    ROLE
) REFERENCES roles
(
    id
)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT auth_assignments_auth_items_id_fk
    FOREIGN KEY
(
    item
) REFERENCES auth_items
(
    id
)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    );

CREATE TABLE if NOT EXISTS users
(
    id
    INT
    auto_increment
    PRIMARY
    KEY,
    email
    VARCHAR
(
    255
) NOT NULL,
    firstName VARCHAR
(
    255
) NOT NULL,
    lastName VARCHAR
(
    255
) NOT NULL,
    password VARCHAR
(
    255
) NOT NULL,
    email_confirmed tinyint
(
    1
) DEFAULT 0 NOT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at datetime NULL ON UPDATE CURRENT_TIMESTAMP
    );

CREATE TABLE if NOT EXISTS reset_tokens
(
    token
    VARCHAR
(
    64
) NOT NULL,
    userId INT NOT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    completed_at datetime NULL,
    PRIMARY KEY
(
    token
),
    CONSTRAINT reset_tokens_users_id_fk
    FOREIGN KEY
(
    userId
) REFERENCES users
(
    id
)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    );

CREATE TABLE if NOT EXISTS user_roles
(
    userId
    INT
    NOT
    NULL,
    roleId
    INT
    NOT
    NULL,
    created_at
    datetime
    DEFAULT
    CURRENT_TIMESTAMP
    NOT
    NULL,
    updated_at
    datetime
    NULL
    ON
    UPDATE
    CURRENT_TIMESTAMP,
    CONSTRAINT
    user_roles_roles_id_fk
    FOREIGN
    KEY
(
    roleId
) REFERENCES roles
(
    id
)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT user_roles_users_id_fk
    FOREIGN KEY
(
    userId
) REFERENCES users
(
    id
)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    );

INSERT INTO `auth_items` (`id`, `item`, `description`, `created_at`, `updated_at`)
VALUES (1, '@admin/auth/login', NULL, '2000-01-01 00:00:00', NULL),
       (2, '@admin/auth/register', NULL, '2000-01-01 00:00:00', NULL),
       (6, '@admin/site/dashboard', NULL, '2000-01-01 00:00:00', NULL),
       (7, '@admin/site/profile', NULL, '2000-01-01 00:00:00', NULL),
       (8, '@admin/users/list-all', NULL, '2000-01-01 00:00:00', NULL),
       (9, '@admin/users/manage/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (10, '@admin/users/create', NULL, '2000-01-01 00:00:00', NULL),
       (11, '@admin/routes-management/items/list-all', NULL, '2000-01-01 00:00:00', NULL),
       (12, '@admin/routes-management/items/manage/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (13, '@admin/routes-management/items/create', NULL, '2000-01-01 00:00:00', NULL),
       (14, '@admin/auth/logout', NULL, '2000-01-01 00:00:00', NULL),
       (15, '@admin/auth/forgot-password', NULL, '2000-01-01 00:00:00', NULL),
       (16, '@admin/auth/reset-password', NULL, '2000-01-01 00:00:00', NULL),
       (18, '@admin/routes-management/roles/create', NULL, '2000-01-01 00:00:00', NULL),
       (19, '@admin/routes-management/roles/list-all', NULL, '2000-01-01 00:00:00', NULL),
       (20, '@admin/routes-management/roles/manage/{id}', NULL, '2000-01-01 00:00:00', NULL),
       (21, '@public/', NULL, '2000-01-01 00:00:00', NULL);

INSERT INTO `roles` (`id`, `roleName`, `roleIcon`, `description`, `created_at`, `updated_at`)
VALUES (1, 'Administrator', '<i class=\"fa-solid fa-crown\" style=\"color: #f5bd02;\"></i>', NULL,
        '2000-01-01 00:00:00', NULL),
       (2, 'Visitor', NULL, NULL, '2000-01-01 00:00:00', NULL);


INSERT INTO `users` (`id`, `email`, `firstName`, `lastName`, `password`, `email_confirmed`, `created_at`,
                     `updated_at`)
VALUES (1, 'admin@example.com', 'Superadmin', 'Superadmin',
        '$argon2id$v=19$m=65536,t=4,p=3$OUtyZ2RKckloMDNXbUtsUw$OITax6QoMsOvWo1+1Bd0IzSTt4pPsg6U88i36Bwak68', 1,
        '2000-01-01 00:00:00', NULL);


INSERT INTO `user_roles` (`userId`, `roleId`, `created_at`, `updated_at`)
VALUES (1, 1, '2000-01-01 00:00:00', '2024-01-03 23:17:17');

INSERT INTO `auth_assignments` (`role`, `item`, `created_at`, `updated_at`)
VALUES (1, 21, '2000-01-01 00:00:00', NULL),
       (1, 15, '2000-01-01 00:00:00', NULL),
       (1, 1, '2000-01-01 00:00:00', NULL),
       (1, 14, '2000-01-01 00:00:00', NULL),
       (1, 2, '2000-01-01 00:00:00', NULL),
       (1, 16, '2000-01-01 00:00:00', NULL),
       (1, 13, '2000-01-01 00:00:00', NULL),
       (1, 11, '2000-01-01 00:00:00', NULL),
       (1, 12, '2000-01-01 00:00:00', NULL),
       (1, 18, '2000-01-01 00:00:00', NULL),
       (1, 19, '2000-01-01 00:00:00', NULL),
       (1, 20, '2000-01-01 00:00:00', NULL),
       (1, 6, '2000-01-01 00:00:00', NULL),
       (1, 7, '2000-01-01 00:00:00', NULL),
       (1, 10, '2000-01-01 00:00:00', NULL),
       (1, 8, '2000-01-01 00:00:00', NULL),
       (1, 9, '2000-01-01 00:00:00', NULL),
       (2, 21, '2000-01-01 00:00:00', NULL),
       (2, 15, '2000-01-01 00:00:00', NULL),
       (2, 1, '2000-01-01 00:00:00', NULL),
       (2, 14, '2000-01-01 00:00:00', NULL),
       (2, 2, '2000-01-01 00:00:00', NULL),
       (2, 16, '2000-01-01 00:00:00', NULL);