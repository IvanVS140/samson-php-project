SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema test_samson
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `test_samson` DEFAULT CHARACTER SET utf8 ;
USE `test_samson` ;

-- -----------------------------------------------------
-- Table `test_samson`.`a_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_samson`.`a_category` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `category_code` INT NOT NULL,
  `category_name` VARCHAR(25) NOT NULL,
  INDEX `category_id` (`category_id` ASC) VISIBLE,
  INDEX `category_code` (`category_code` ASC) VISIBLE,
  INDEX `category_name` (`category_name` ASC) VISIBLE,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_samson`.`a_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_samson`.`a_product` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `product_code` INT NOT NULL,
  `product_name` VARCHAR(25) NOT NULL,
  INDEX `product_id` (`product_id` ASC) VISIBLE,
  INDEX `product_code` (`product_code` ASC) VISIBLE,
  INDEX `product_name` (`product_name` ASC) VISIBLE,
  PRIMARY KEY (`product_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_samson`.`a_price`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_samson`.`a_price` (
  `a_product_product_id` INT NOT NULL,
  `price_type` VARCHAR(25) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  INDEX `fk_a_price_a_product1_idx` (`a_product_product_id` ASC) VISIBLE,
  INDEX `price_type` (`price_type` ASC) VISIBLE,
  INDEX `price` (`price` ASC) VISIBLE,
  PRIMARY KEY (`a_product_product_id`, `price`),
  CONSTRAINT `fk_a_price_a_product1`
    FOREIGN KEY (`a_product_product_id`)
    REFERENCES `test_samson`.`a_product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_samson`.`a_property`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_samson`.`a_property` (
  `a_product_product_id` INT NOT NULL,
  `property_value` VARCHAR(45) NOT NULL,
  INDEX `fk_a_property_a_product1_idx` (`a_product_product_id` ASC) VISIBLE,
  INDEX `property_value` (`property_value` ASC) VISIBLE,
  PRIMARY KEY (`a_product_product_id`, `property_value`),
  CONSTRAINT `fk_a_property_a_product1`
    FOREIGN KEY (`a_product_product_id`)
    REFERENCES `test_samson`.`a_product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_samson`.`a_category_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_samson`.`a_category_product` (
  `a_category_category_id` INT NOT NULL,
  `a_product_product_id` INT NOT NULL,
  INDEX `fk_a_category_has_a_product_a_product1_idx` (`a_product_product_id` ASC) VISIBLE,
  INDEX `fk_a_category_has_a_product_a_category_idx` (`a_category_category_id` ASC) VISIBLE,
  PRIMARY KEY (`a_category_category_id`, `a_product_product_id`),
  CONSTRAINT `fk_a_category_has_a_product_a_category`
    FOREIGN KEY (`a_category_category_id`)
    REFERENCES `test_samson`.`a_category` (`category_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_a_category_has_a_product_a_product1`
    FOREIGN KEY (`a_product_product_id`)
    REFERENCES `test_samson`.`a_product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
