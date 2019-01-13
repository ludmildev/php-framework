CREATE TABLE `test`.`products` ( 
    `id` INT(8) NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(200) NOT NULL , 
    `description` TEXT NOT NULL , 
    `price` DECIMAL(4,2) NOT NULL DEFAULT '0.00', 
    `quantity` TINYINT(3) NOT NULL DEFAULT '0', 
PRIMARY KEY (`id`)) 
ENGINE = InnoDB;

CREATE TABLE `test`.`products_categories` ( 
    `productId` INT(8) NOT NULL , 
    `categoryId` INT(8) NOT NULL 
INDEX (`productId`, `categoryId`)) 
ENGINE = InnoDB;