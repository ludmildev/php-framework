CREATE TABLE `test`.`categories` ( 
    `id` TINYINT(1) NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(100) NOT NULL , 
PRIMARY KEY (`id`)) 
ENGINE = InnoDB;

INSERT INTO `categories` (`id`, `name`) VALUES (NULL, 'Category 1'), (NULL, 'Category 2');