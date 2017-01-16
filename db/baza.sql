SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema epstore
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `epstore` ;

-- -----------------------------------------------------
-- Schema epstore
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `epstore` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci ;
USE `epstore` ;

-- -----------------------------------------------------
-- Table `epstore`.`Role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`Role` ;

CREATE TABLE IF NOT EXISTS `epstore`.`Role` (
  `role_id` INT NOT NULL,
  `role_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE INDEX `role_id_UNIQUE` (`role_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epstore`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`User` ;

CREATE TABLE IF NOT EXISTS `epstore`.`User` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(150) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `surname` VARCHAR(150) NOT NULL,
  `password_digest` VARCHAR(255) NULL,
  `phone` VARCHAR(16) NULL,
  `role_id` INT NOT NULL,
  `user_active` TINYINT(1) NOT NULL DEFAULT 0,
  `user_activation_token` VARCHAR(64) NOT NULL,
  `user_activation_token_created_at` DATETIME NOT NULL,
  `user_created_at` DATETIME NULL,
  `user_address` VARCHAR(50) NULL,
  `user_post` INT NULL,
  `user_city` VARCHAR(50) NULL,
  `user_country` VARCHAR(50) NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC),
  INDEX `fk_User_Role_idx` (`role_id` ASC),
  CONSTRAINT `fk_User_Role`
    FOREIGN KEY (`role_id`)
    REFERENCES `epstore`.`Role` (`role_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epstore`.`Product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`Product` ;

CREATE TABLE IF NOT EXISTS `epstore`.`Product` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(150) NOT NULL,
  `product_description` TEXT NOT NULL,
  `product_price` FLOAT NOT NULL,
  `product_rating` INT NOT NULL DEFAULT 0,
  `product_valid` TINYINT(1) NOT NULL DEFAULT 1,
  `product_rating_count` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_id`),
  UNIQUE INDEX `product_id_UNIQUE` (`product_id` ASC),
  FULLTEXT INDEX `fulltext` (`product_name` ASC, `product_description` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epstore`.`Order_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`Order_status` ;

CREATE TABLE IF NOT EXISTS `epstore`.`Order_status` (
  `status_id` INT NOT NULL,
  `status_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`status_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epstore`.`Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`Order` ;

CREATE TABLE IF NOT EXISTS `epstore`.`Order` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `status_id` INT NOT NULL,
  `order_created_at` DATETIME NOT NULL,
  `order_updated_at` DATETIME NOT NULL,
  `delivery_address` VARCHAR(50) NOT NULL,
  `delivery_post` INT NOT NULL,
  `delivery_city` VARCHAR(50) NOT NULL,
  `delivery_country` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`order_id`),
  INDEX `fk_Order_User1_idx` (`user_id` ASC),
  INDEX `fk_Order_Order_status1_idx` (`status_id` ASC),
  CONSTRAINT `fk_Order_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `epstore`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_Order_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `epstore`.`Order_status` (`status_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epstore`.`Order_item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`Order_item` ;

CREATE TABLE IF NOT EXISTS `epstore`.`Order_item` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `item_price` FLOAT NOT NULL,
  `item_quantity` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`order_id`, `product_id`),
  INDEX `fk_Order_item_Product1_idx` (`product_id` ASC),
  CONSTRAINT `fk_Order_item_Order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `epstore`.`Order` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_item_Product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `epstore`.`Product` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epstore`.`Rating`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`Rating` ;

CREATE TABLE IF NOT EXISTS `epstore`.`Rating` (
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `rating_value` INT NOT NULL,
  PRIMARY KEY (`user_id`, `product_id`),
  INDEX `fk_Rating_Product1_idx` (`product_id` ASC),
  CONSTRAINT `fk_Rating_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `epstore`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Rating_Product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `epstore`.`Product` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epstore`.`Image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `epstore`.`Image` ;

CREATE TABLE IF NOT EXISTS `epstore`.`Image` (
  `image_id` INT NOT NULL AUTO_INCREMENT,
  `image_name` VARCHAR(45) NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`image_id`),
  INDEX `fk_Image_Product1_idx` (`product_id` ASC),
  CONSTRAINT `fk_Image_Product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `epstore`.`Product` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_slovenian_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------
-- Seed values
-- -----------

INSERT INTO `Role` (`role_id`, `role_name`) VALUE ('1', 'Administrator');
INSERT INTO `Role` (`role_id`, `role_name`) VALUE ('2', 'Prodajalec');
INSERT INTO `Role` (`role_id`, `role_name`) VALUE ('3', 'Stranka');

INSERT INTO `Order_status` (`status_id`, `status_name`) VALUE ('1', 'Oddano');
INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUE ('2', 'Potrjeno');
INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUE ('3', 'Stornirano');

INSERT INTO `User` (`user_id`, `email`, `name`, `surname`, `password_digest`, `role_id`, `user_active`, `user_activation_token`, `user_activation_token_created_at`, `user_created_at`) VALUE ('1', 'admin@epstore.tk', 'Administrator', 'EP', '$2y$10$CGN3fErsAyNVeLdV8qCGF.I.Xh.WClVWbHhQio7RqHfnuPNRT1Crm', '1', '1', 'khxIPdVzCQIbb8KqLUyNJ6G4j-trvPA90_lx3DYfrJQLRebHBiqVfuLV2pB0itDB', '1000-01-01 00:00:00', NOW());
INSERT INTO `User` (`user_id`, `email`, `name`, `surname`, `password_digest`, `role_id`, `user_active`, `user_activation_token`, `user_activation_token_created_at`, `user_created_at`) VALUE ('2', 'prodajalec@epstore.tk', 'Prodajalec', 'Ena', '$2y$10$do/jHwmUjlY87EikzsSV8uwKi1xHHoAdPC7XXiBB3ZyDgXVAmr89O', '2', '1', 'khxIPdVzCQIbb8KqLUyNJ6G4j-trvPA90_lx3DYfrJQLRebHBiqVfuLV2pB0itDB', '1000-01-01 00:00:00', NOW());
INSERT INTO `User` (`user_id`, `email`, `name`, `surname`, `password_digest`, `role_id`, `user_active`, `user_activation_token`, `user_activation_token_created_at`, `user_created_at`, `phone`, `user_address`, `user_post`, `user_city`, `user_country`) VALUE ('3', 'stranka@ep.si', 'Stranka', 'Ena', '$2y$10$iXADxNZSSTiyo5S3UfZ4L.qjsd/V57jRFqWnMPOzM7RT1FkCVRRTm', '3', '1', 'khxIPdVzCQIbb8KqLUyNJ6G4j-trvPA90_lx3DYfrJQLRebHBiqVfuLV2pB0itDB', '1000-01-01 00:00:00', NOW(), '070707070', 'Slovenska cesta 10', '1000', 'Ljubljana', 'Slovenija');

INSERT INTO `Product` (product_name, product_description, product_price) VALUE ("Sandberg DP-MiniDP 2m", "Kabel Sandberg DisplayPort v Mini DisplayPort 1.2 4K 2 m za neposredno povezavo računalnika z zaslonom, odlična rešitev če imate televizor ali zaslon, ki potrebuje na eni strani Mini DisplayPort in DisplayPort na drugi. Ponuja hitrost prenosa podatkov, do 4K vsebine.", 12.9);
INSERT INTO `Product` (product_name, product_description, product_price) VALUE ("LG 27UD68-P", "Monitor LG LED 27UD68-P se ponaša s 27-palčno diagonalo in Ultra HD ločljivostjo (3840×2160).", 520.0);
INSERT INTO `Product` (product_name, product_description, product_price) VALUE ("Armor All Tech & Screen", "Armor All robčki Tech & Screen Wipes za čiščenje ekranov", 3.42);
INSERT INTO `Product` (product_name, product_description, product_price) VALUE ("Philips HX6932/36", "Philips Sonicare HX6932/36 dvojno pakiranje električnih zobnih ščetk vključuje 2 glavi ščetke in 2 ročaja ter UV-čistilnik za glave ščetk. Izbirate lahko med 3 načini delovanja, opremljena pa je z intervalnim časovnikom, ter 2-minutnim časovnikom za optimalno ščetkanje. Patentirana sonična tehnologija poskrbi za edinstveno dinamično čiščenje, glava z dolgimi ter gostimi ščetinami pa poskrbi za temeljito odstranjevanje zobnih oblog globoko med zobmi. ", 134.9);
INSERT INTO `Image` (image_name, product_id) VALUES ('1483526307.png',1),('1483526500.jpeg',2),('1483526516.jpeg',2),('1483526525.jpeg',2),('1483526532.jpeg',2),('1483526586.jpeg',3),('1483526659.jpeg',4),('1483526669.jpeg',4);
