CREATE TABLE auth_groups
(
    code        VARCHAR(255)                         NOT NULL,
    groupName   VARCHAR(255)                         NOT NULL,
    description VARCHAR(255)                         NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at  DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (code)
);

CREATE TABLE auth_items
(
    item        VARCHAR(255)                         NOT NULL,
    description VARCHAR(255)                         NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at  DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (item)
);

CREATE TABLE auth_assignments
(
    code       VARCHAR(255)                         NOT NULL,
    item       VARCHAR(255)                         NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP(),
    CONSTRAINT auth_assignments_auth_groups_code_fk
        FOREIGN KEY (code) REFERENCES auth_groups (code)
            ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT auth_assignments_auth_items_item_fk
        FOREIGN KEY (item) REFERENCES auth_items (item)
            ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE role_groups
(
    roleID     INT                                  NOT NULL,
    groupCode  VARCHAR(255)                         NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP()
);

CREATE TABLE roles
(
    id          INT AUTO_INCREMENT
        PRIMARY KEY,
    roleName    VARCHAR(255)                         NOT NULL,
    description VARCHAR(255)                         NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at  DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP()
);

CREATE TABLE user_roles
(
    userId     INT                                  NOT NULL,
    roleId     INT                                  NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at DATETIME                             NULL ON UPDATE CURRENT_TIMESTAMP()
);

CREATE TABLE users
(
    id              INT AUTO_INCREMENT
        PRIMARY KEY,
    email           VARCHAR(255)                           NOT NULL,
    firstName       VARCHAR(255)                           NOT NULL,
    lastName        VARCHAR(255)                           NOT NULL,
    password        VARCHAR(255)                           NOT NULL,
    email_confirmed TINYINT(1)                             NOT NULL,
    created_at      DATETIME   DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    updated_at      DATETIME                               NULL ON UPDATE CURRENT_TIMESTAMP(),
    superadmin      TINYINT(1) DEFAULT 0                   NOT NULL
);

