create table if not exists auth_items
(
    id   int auto_increment primary key,
    item varchar(255) not null,
    description text                               null,
    created_at  datetime default CURRENT_TIMESTAMP not null,
    updated_at  datetime                           null on update CURRENT_TIMESTAMP
);

create table if not exists roles
(
    id       int auto_increment primary key,
    roleName varchar(255) not null,
    roleIcon    varchar(255)                       null,
    description text                               null,
    created_at  datetime default CURRENT_TIMESTAMP not null,
    updated_at  datetime                           null on update CURRENT_TIMESTAMP
);

create table if not exists auth_assignments
(
    role       int                                not null,
    item       int                                not null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime                           null on update CURRENT_TIMESTAMP,
    constraint auth_assignments_auth_groups_id_fk foreign key (role) references roles (id) on update cascade on delete cascade,
    constraint auth_assignments_auth_items_id_fk foreign key (item) references auth_items (id) on update cascade on delete cascade
);

create table if not exists users
(
    id int auto_increment primary key,
    email           varchar(255)                         not null,
    firstName       varchar(255)                         not null,
    lastName        varchar(255)                         not null,
    password        varchar(255)                         null,
    email_confirmed tinyint(1) default 0                 not null,
    auth_provider   enum ('internal', 'google')          not null,
    created_at      datetime   default CURRENT_TIMESTAMP not null,
    updated_at      datetime                             null on update CURRENT_TIMESTAMP
);

create table if not exists reset_tokens
(
    token        varchar(64)                        not null,
    userId       int                                not null,
    created_at   datetime default CURRENT_TIMESTAMP not null,
    completed_at datetime                           null,
    primary key (token),
    constraint reset_tokens_users_id_fk foreign key (userId) references users (id) on update cascade on delete cascade
);

create table if not exists user_roles
(
    userId     int                                not null,
    roleId     int                                not null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime                           null on update CURRENT_TIMESTAMP,
    constraint user_roles_roles_id_fk foreign key (roleId) references roles (id) on update cascade on delete cascade,
    constraint user_roles_users_id_fk foreign key (userId) references users (id) on update cascade on delete cascade
);

insert into `auth_items` (`id`, `item`, `description`, `created_at`, `updated_at`)
values (1, '@admin/auth/login', null, '2000-01-01 00:00:00', null),
       (2, '@admin/auth/register', null, '2000-01-01 00:00:00', null),
       (6, '@admin/site/dashboard', null, '2000-01-01 00:00:00', null),
       (7, '@admin/site/profile', null, '2000-01-01 00:00:00', null),
       (8, '@admin/users/list-all', null, '2000-01-01 00:00:00', null),
       (9, '@admin/users/manage/{id}', null, '2000-01-01 00:00:00', null),
       (10, '@admin/users/create', null, '2000-01-01 00:00:00', null),
       (11, '@admin/routes-management/items/list-all', null, '2000-01-01 00:00:00', null),
       (12, '@admin/routes-management/items/manage/{id}', null, '2000-01-01 00:00:00', null),
       (13, '@admin/routes-management/items/create', null, '2000-01-01 00:00:00', null),
       (14, '@admin/auth/logout', null, '2000-01-01 00:00:00', null),
       (15, '@admin/auth/forgot-password', null, '2000-01-01 00:00:00', null),
       (16, '@admin/auth/reset-password/{token}', null, '2000-01-01 00:00:00', null),
       (18, '@admin/routes-management/roles/create', null, '2000-01-01 00:00:00', null),
       (19, '@admin/routes-management/roles/list-all', null, '2000-01-01 00:00:00', null),
       (20, '@admin/routes-management/roles/manage/{id}', null, '2000-01-01 00:00:00', null),
       (21, '@public/', null, '2000-01-01 00:00:00', null),
       (22, '@admin/auth/google-auth', null, '2000-01-01 00:00:00', null),
       (23, '@admin/auth/verify-account/{token}', null, '2000-01-01 00:00:00', null);

insert into `roles` (`id`, `roleName`, `roleIcon`, `description`, `created_at`, `updated_at`)
values (1, 'Administrator', '<i class=\"fa-solid fa-crown\" style=\"color: #f5bd02;\"></i>', null, '2000-01-01 00:00:00', null),
       (2, 'Visitor', null, null, '2000-01-01 00:00:00', null);

insert into `users` (`id`, `email`, `firstName`, `lastName`, `password`, `email_confirmed`, `auth_provider`, `created_at`, `updated_at`)
values (1, 'admin@example.com', 'Superadmin', 'Superadmin',
        '$argon2id$v=19$m=65536,t=4,p=3$OUtyZ2RKckloMDNXbUtsUw$OITax6QoMsOvWo1+1Bd0IzSTt4pPsg6U88i36Bwak68', 1, 'internal', '2000-01-01 00:00:00',
        null);

insert into `user_roles` (`userId`, `roleId`, `created_at`, `updated_at`)
values (1, 1, '2000-01-01 00:00:00', null);

insert into `auth_assignments` (`role`, `item`, `created_at`, `updated_at`)
values (1, 21, '2000-01-01 00:00:00', null),
       (1, 15, '2000-01-01 00:00:00', null),
       (1, 1, '2000-01-01 00:00:00', null),
       (1, 14, '2000-01-01 00:00:00', null),
       (1, 2, '2000-01-01 00:00:00', null),
       (1, 16, '2000-01-01 00:00:00', null),
       (1, 13, '2000-01-01 00:00:00', null),
       (1, 11, '2000-01-01 00:00:00', null),
       (1, 12, '2000-01-01 00:00:00', null),
       (1, 18, '2000-01-01 00:00:00', null),
       (1, 19, '2000-01-01 00:00:00', null),
       (1, 20, '2000-01-01 00:00:00', null),
       (1, 6, '2000-01-01 00:00:00', null),
       (1, 7, '2000-01-01 00:00:00', null),
       (1, 10, '2000-01-01 00:00:00', null),
       (1, 8, '2000-01-01 00:00:00', null),
       (1, 9, '2000-01-01 00:00:00', null),
       (1, 22, '2000-01-01 00:00:00', null),
       (1, 23, '2000-01-01 00:00:00', null),
       (2, 23, '2000-01-01 00:00:00', null),
       (2, 22, '2000-01-01 00:00:00', null),
       (2, 21, '2000-01-01 00:00:00', null),
       (2, 15, '2000-01-01 00:00:00', null),
       (2, 1, '2000-01-01 00:00:00', null),
       (2, 14, '2000-01-01 00:00:00', null),
       (2, 2, '2000-01-01 00:00:00', null),
       (2, 16, '2000-01-01 00:00:00', null);