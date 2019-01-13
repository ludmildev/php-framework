CREATE TABLE `test`.`users` (
    `id` INT(8) NOT NULL , 
    `username` VARCHAR(20) NOT NULL , 
    `password` VARCHAR(255) NOT NULL , 
    `isAdmin` TINYINT(1) NOT NULL DEFAULT '0' , 
    `isEditor` TINYINT(1) NOT NULL DEFAULT '0' , 
    `isModerator` TINYINT(1) NOT NULL DEFAULT '0' ,
    `cash` INT(8) NOT NULL DEFAULT '0' ,
    `created` TIMESTAMP(6) NULL DEFAULT CURRENT_TIMESTAMP ) 
ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

ALTER TABLE `users` ADD PRIMARY KEY(`id`)
ALTER TABLE `users` CHANGE `id` `id` INT(8) NOT NULL AUTO_INCREMENT;