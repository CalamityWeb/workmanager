create table if not exists `auth_assignments`
(
    `role`       int      not null,
    `item`       int      not null,
    `created_at` datetime not null default CURRENT_TIMESTAMP,
    `updated_at` datetime          default null on update CURRENT_TIMESTAMP,
    key `auth_assignments_auth_groups_id_fk` (`role`),
    key `auth_assignments_auth_items_id_fk` (`item`)
);

insert into `auth_assignments` (`role`, `item`, `created_at`, `updated_at`)
values (1, 21, '2024-06-25 12:45:38', null),
       (1, 27, '2024-06-25 12:45:38', null),
       (1, 24, '2024-06-25 12:45:38', null),
       (1, 25, '2024-06-25 12:45:38', null),
       (1, 26, '2024-06-25 12:45:38', null),
       (1, 15, '2024-06-25 12:45:38', null),
       (1, 22, '2024-06-25 12:45:38', null),
       (1, 1, '2024-06-25 12:45:38', null),
       (1, 14, '2024-06-25 12:45:38', null),
       (1, 2, '2024-06-25 12:45:38', null),
       (1, 16, '2024-06-25 12:45:38', null),
       (1, 23, '2024-06-25 12:45:38', null),
       (1, 13, '2024-06-25 12:45:38', null),
       (1, 11, '2024-06-25 12:45:38', null),
       (1, 12, '2024-06-25 12:45:38', null),
       (1, 18, '2024-06-25 12:45:38', null),
       (1, 19, '2024-06-25 12:45:38', null),
       (1, 20, '2024-06-25 12:45:38', null),
       (1, 6, '2024-06-25 12:45:38', null),
       (1, 7, '2024-06-25 12:45:38', null),
       (1, 10, '2024-06-25 12:45:38', null),
       (1, 8, '2024-06-25 12:45:38', null),
       (1, 9, '2024-06-25 12:45:38', null),
       (2, 21, '2024-06-25 12:45:44', null),
       (2, 27, '2024-06-25 12:45:44', null),
       (2, 24, '2024-06-25 12:45:44', null),
       (2, 25, '2024-06-25 12:45:44', null),
       (2, 26, '2024-06-25 12:45:44', null),
       (2, 15, '2024-06-25 12:45:44', null),
       (2, 22, '2024-06-25 12:45:44', null),
       (2, 1, '2024-06-25 12:45:44', null),
       (2, 14, '2024-06-25 12:45:44', null),
       (2, 2, '2024-06-25 12:45:44', null),
       (2, 16, '2024-06-25 12:45:44', null),
       (2, 23, '2024-06-25 12:45:44', null);


create table if not exists `auth_items`
(
    `id`          int                                     not null auto_increment,
    `item`        varchar(255) collate utf8mb4_general_ci not null,
    `description` text collate utf8mb4_general_ci,
    `created_at`  datetime                                not null default CURRENT_TIMESTAMP,
    `updated_at`  datetime                                         default null on update CURRENT_TIMESTAMP,
    primary key (`id`)
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
       (23, '@admin/auth/verify-account/{token}', null, '2000-01-01 00:00:00', null),
       (24, '@public/impressum', null, '2024-06-25 12:41:46', null),
       (25, '@public/privacy-policy', null, '2024-06-25 12:41:54', null),
       (26, '@public/terms-of-service', null, '2024-06-25 12:42:02', null),
       (27, '@public/about', null, '2024-06-25 12:45:33', null);

create table if not exists `reset_tokens`
(
    `token`        varchar(64) collate utf8mb4_general_ci not null,
    `userId`       int                                    not null,
    `created_at`   datetime                               not null default CURRENT_TIMESTAMP,
    `completed_at` datetime                                        default null,
    primary key (`token`),
    key `reset_tokens_users_id_fk` (`userId`)
);

create table if not exists `roles`
(
    `id`          int                                                           not null auto_increment,
    `name`        varchar(255) character set utf8mb4 collate utf8mb4_general_ci not null,
    `icon`        varchar(255) character set utf8mb4 collate utf8mb4_general_ci          default null,
    `description` text collate utf8mb4_general_ci,
    `created_at`  datetime                                                      not null default CURRENT_TIMESTAMP,
    `updated_at`  datetime                                                               default null on update CURRENT_TIMESTAMP,
    primary key (`id`)
);

insert into `roles` (`id`, `name`, `icon`, `description`, `created_at`, `updated_at`)
values (1, 'Administrator', '<i class=\"fa-solid fa-crown\" style=\"color: #f5bd02;\"></i>', null, '2000-01-01 00:00:00', null),
       (2, 'Visitor', null, null, '2000-01-01 00:00:00', null);

create table if not exists `users`
(
    `id`              int                                                   not null auto_increment,
    `email`           varchar(255) collate utf8mb4_general_ci               not null,
    `firstName`       varchar(255) collate utf8mb4_general_ci               not null,
    `lastName`        varchar(255) collate utf8mb4_general_ci               not null,
    `password`        varchar(255) collate utf8mb4_general_ci                        default null,
    `email_confirmed` tinyint(1)                                            not null default '0',
    `auth_provider`   enum ('internal','google') collate utf8mb4_general_ci not null,
    `created_at`      datetime                                              not null default CURRENT_TIMESTAMP,
    `updated_at`      datetime                                                       default null on update CURRENT_TIMESTAMP,
    primary key (`id`)
);

insert into `users` (`id`, `email`, `firstName`, `lastName`, `password`, `email_confirmed`, `auth_provider`, `created_at`, `updated_at`)
values (1, 'admin@example.com', 'Superadmin', 'Superadmin',
        '$argon2id$v=19$m=65536,t=4,p=3$OUtyZ2RKckloMDNXbUtsUw$OITax6QoMsOvWo1+1Bd0IzSTt4pPsg6U88i36Bwak68', 1, 'internal', '2000-01-01 00:00:00',
        null);


create table if not exists `user_roles`
(
    `userId`     int      not null,
    `roleId`     int      not null,
    `created_at` datetime not null default CURRENT_TIMESTAMP,
    `updated_at` datetime          default null on update CURRENT_TIMESTAMP,
    key `user_roles_roles_id_fk` (`roleId`),
    key `user_roles_users_id_fk` (`userId`)
);

insert into `user_roles` (`userId`, `roleId`, `created_at`, `updated_at`)
values (1, 1, '2000-01-01 00:00:00', null);

alter table `auth_assignments`
    add constraint `auth_assignments_auth_groups_id_fk` foreign key (`role`) references `roles` (`id`) on delete cascade on update cascade,
    add constraint `auth_assignments_auth_items_id_fk` foreign key (`item`) references `auth_items` (`id`) on delete cascade on update cascade;

alter table `reset_tokens`
    add constraint `reset_tokens_users_id_fk` foreign key (`userId`) references `users` (`id`) on delete cascade on update cascade;

alter table `user_roles`
    add constraint `user_roles_roles_id_fk` foreign key (`roleId`) references `roles` (`id`) on delete cascade on update cascade,
    add constraint `user_roles_users_id_fk` foreign key (`userId`) references `users` (`id`) on delete cascade on update cascade;