-- MySQL Script generated by MySQL Workbench
-- Mon Jan 16 16:18:36 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

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
