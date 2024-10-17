ALTER TABLE `roles` ADD `level` INT NOT NULL DEFAULT '10' AFTER `description`;
UPDATE `roles` SET `level` = '1' WHERE `roles`.`id` = 1;