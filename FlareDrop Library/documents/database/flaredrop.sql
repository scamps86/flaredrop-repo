-- MySQL Script generated by MySQL Workbench
-- Tue Aug 11 07:50:22 2015
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema flaredro_preview
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `flaredro_preview` ;

-- -----------------------------------------------------
-- Schema flaredro_preview
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `flaredro_preview` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `flaredro_preview` ;

-- -----------------------------------------------------
-- Table `flaredro_preview`.`plan`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`plan` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`plan` (
  `planId` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `type` VARCHAR(2) NOT NULL COMMENT '',
  `price` DECIMAL(10,2) NOT NULL COMMENT '',
  `allowedSpace` INT NOT NULL COMMENT '',
  PRIMARY KEY (`planId`)  COMMENT '',
  UNIQUE INDEX `planId_UNIQUE` (`planId` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`root`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`root` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`root` (
  `rootId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `planId` TINYINT UNSIGNED NOT NULL COMMENT '',
  `name` VARCHAR(255) NOT NULL COMMENT '',
  `selectedSkin` VARCHAR(10) NOT NULL COMMENT '',
  `domainExpirationDate` DATE NOT NULL COMMENT '',
  PRIMARY KEY (`rootId`)  COMMENT '',
  UNIQUE INDEX `rootId_UNIQUE` (`rootId` ASC)  COMMENT '',
  UNIQUE INDEX `name_UNIQUE` (`name` ASC)  COMMENT '',
  INDEX `fk_root_plan1_idx` (`planId` ASC)  COMMENT '',
  CONSTRAINT `fk_root_plan1`
    FOREIGN KEY (`planId`)
    REFERENCES `flaredro_preview`.`plan` (`planId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`privilege`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`privilege` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`privilege` (
  `privilegeId` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `type` VARCHAR(1) NOT NULL COMMENT '',
  PRIMARY KEY (`privilegeId`)  COMMENT '',
  UNIQUE INDEX `privilegeId_UNIQUE` (`privilegeId` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`disk`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`disk` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`disk` (
  `diskId` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(10) NOT NULL COMMENT '',
  PRIMARY KEY (`diskId`)  COMMENT '',
  UNIQUE INDEX `diskId_UNIQUE` (`diskId` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`folder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`folder` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`folder` (
  `folderId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `parentFolderId` BIGINT UNSIGNED NULL COMMENT '',
  `rootId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `diskId` TINYINT UNSIGNED NOT NULL COMMENT '',
  `privilegeId` TINYINT UNSIGNED NOT NULL DEFAULT 2 COMMENT '',
  `visible` TINYINT NOT NULL COMMENT '',
  `objectType` VARCHAR(15) NOT NULL COMMENT '',
  `index` BIGINT NULL DEFAULT 0 COMMENT '',
  `data` TEXT NULL COMMENT '',
  PRIMARY KEY (`folderId`)  COMMENT '',
  INDEX `fk_folder_root1_idx` (`rootId` ASC)  COMMENT '',
  UNIQUE INDEX `folderId_UNIQUE` (`folderId` ASC)  COMMENT '',
  INDEX `fk_folder_privilege1_idx` (`privilegeId` ASC)  COMMENT '',
  INDEX `fk_folder_disk1_idx` (`diskId` ASC)  COMMENT '',
  INDEX `fk_folder_folder1_idx` (`parentFolderId` ASC)  COMMENT '',
  CONSTRAINT `fk_folder_root1`
    FOREIGN KEY (`rootId`)
    REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_folder_privilege1`
    FOREIGN KEY (`privilegeId`)
    REFERENCES `flaredro_preview`.`privilege` (`privilegeId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_folder_disk1`
    FOREIGN KEY (`diskId`)
    REFERENCES `flaredro_preview`.`disk` (`diskId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_folder_folder1`
    FOREIGN KEY (`parentFolderId`)
    REFERENCES `flaredro_preview`.`folder` (`folderId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`folder_lan`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`folder_lan` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`folder_lan` (
  `lanId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `folderId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `tag` VARCHAR(5) NOT NULL COMMENT '',
  `name` VARCHAR(255) NULL COMMENT '',
  `description` TEXT NULL COMMENT '',
  `data` TEXT NULL COMMENT '',
  PRIMARY KEY (`lanId`)  COMMENT '',
  INDEX `fk_folder_lan_folder1_idx` (`folderId` ASC)  COMMENT '',
  UNIQUE INDEX `lanId_UNIQUE` (`lanId` ASC)  COMMENT '',
  CONSTRAINT `fk_folder_lan_folder1`
    FOREIGN KEY (`folderId`)
    REFERENCES `flaredro_preview`.`folder` (`folderId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`user` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`user` (
  `userId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `privilegeId` TINYINT UNSIGNED NOT NULL DEFAULT 2 COMMENT '',
  `creationDate` DATETIME NOT NULL COMMENT '',
  `name` VARCHAR(80) NOT NULL COMMENT '',
  `password` VARCHAR(32) NOT NULL COMMENT '',
  `validated` TINYINT NULL COMMENT '',
  `email` VARCHAR(80) NULL COMMENT '',
  `firstName` VARCHAR(45) NULL COMMENT '',
  `middleName` VARCHAR(45) NULL COMMENT '',
  `lastName` VARCHAR(45) NULL COMMENT '',
  `location` VARCHAR(200) NULL COMMENT '',
  `cp` VARCHAR(20) NULL COMMENT '',
  `city` VARCHAR(20) NULL COMMENT '',
  `region` VARCHAR(20) NULL COMMENT '',
  `country` VARCHAR(20) NULL COMMENT '',
  `phone1` VARCHAR(20) NULL COMMENT '',
  `phone2` VARCHAR(20) NULL COMMENT '',
  `data` TEXT NULL COMMENT '',
  PRIMARY KEY (`userId`)  COMMENT '',
  UNIQUE INDEX `userId_UNIQUE` (`userId` ASC)  COMMENT '',
  INDEX `fk_user_privilege1_idx` (`privilegeId` ASC)  COMMENT '',
  UNIQUE INDEX `name_UNIQUE` (`name` ASC)  COMMENT '',
  CONSTRAINT `fk_user_privilege1`
    FOREIGN KEY (`privilegeId`)
    REFERENCES `flaredro_preview`.`privilege` (`privilegeId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`file`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`file` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`file` (
  `fileId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `privilegeId` TINYINT UNSIGNED NOT NULL DEFAULT 2 COMMENT '',
  `type` VARCHAR(15) NOT NULL COMMENT '',
  `name` VARCHAR(255) NOT NULL COMMENT '',
  `extension` VARCHAR(15) NOT NULL COMMENT '',
  `size` BIGINT NOT NULL COMMENT '',
  `private` TINYINT NOT NULL COMMENT '',
  `data` TEXT NULL COMMENT '',
  PRIMARY KEY (`fileId`)  COMMENT '',
  UNIQUE INDEX `fileId_UNIQUE` (`fileId` ASC)  COMMENT '',
  INDEX `fk_file_privilege1_idx` (`privilegeId` ASC)  COMMENT '',
  CONSTRAINT `fk_file_privilege1`
    FOREIGN KEY (`privilegeId`)
    REFERENCES `flaredro_preview`.`privilege` (`privilegeId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`object`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`object` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`object` (
  `objectId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `privilegeId` TINYINT UNSIGNED NOT NULL DEFAULT 2 COMMENT '',
  `type` VARCHAR(15) NOT NULL COMMENT '',
  `creationDate` DATETIME NOT NULL COMMENT '',
  `properties` TEXT NULL COMMENT '',
  PRIMARY KEY (`objectId`)  COMMENT '',
  UNIQUE INDEX `objectId_UNIQUE` (`objectId` ASC)  COMMENT '',
  INDEX `fk_object_privilege1_idx` (`privilegeId` ASC)  COMMENT '',
  CONSTRAINT `fk_object_privilege1`
    FOREIGN KEY (`privilegeId`)
    REFERENCES `flaredro_preview`.`privilege` (`privilegeId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`object_file`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`object_file` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`object_file` (
  `objectFileId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `objectId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `fileId` BIGINT UNSIGNED NOT NULL COMMENT '',
  PRIMARY KEY (`objectFileId`)  COMMENT '',
  UNIQUE INDEX `objectFileId_UNIQUE` (`objectFileId` ASC)  COMMENT '',
  INDEX `fk_object_file_object1_idx` (`objectId` ASC)  COMMENT '',
  INDEX `fk_object_file_file1_idx` (`fileId` ASC)  COMMENT '',
  CONSTRAINT `fk_object_file_object1`
    FOREIGN KEY (`objectId`)
    REFERENCES `flaredro_preview`.`object` (`objectId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_object_file_file1`
    FOREIGN KEY (`fileId`)
    REFERENCES `flaredro_preview`.`file` (`fileId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`object_lan`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`object_lan` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`object_lan` (
  `objectLanId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `objectId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `tag` VARCHAR(5) NOT NULL COMMENT '',
  `properties` TEXT NULL COMMENT '',
  PRIMARY KEY (`objectLanId`)  COMMENT '',
  UNIQUE INDEX `objectLanId_UNIQUE` (`objectLanId` ASC)  COMMENT '',
  INDEX `fk_object_lan_object1_idx` (`objectId` ASC)  COMMENT '',
  CONSTRAINT `fk_object_lan_object1`
    FOREIGN KEY (`objectId`)
    REFERENCES `flaredro_preview`.`object` (`objectId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`object_configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`object_configuration` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`object_configuration` (
  `objectType` VARCHAR(15) NOT NULL COMMENT '',
  `rootId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `bundle` VARCHAR(45) NOT NULL COMMENT '',
  `foldersLink` TINYINT NOT NULL COMMENT '',
  `foldersShow` TINYINT NOT NULL COMMENT '',
  `folderOptionsShow` TINYINT NOT NULL COMMENT '',
  `folderLevels` TINYINT NOT NULL COMMENT '',
  `filesEnabled` TINYINT NOT NULL COMMENT '',
  `folderFilesEnabled` TINYINT NOT NULL COMMENT '',
  `picturesEnabled` TINYINT NOT NULL COMMENT '',
  `folderPicturesEnabled` TINYINT NOT NULL COMMENT '',
  `pictureDimensions` VARCHAR(255) NULL COMMENT '',
  `pictureQuality` TINYINT NULL COMMENT '',
  INDEX `fk_configuration_root1_idx` (`rootId` ASC)  COMMENT '',
  UNIQUE INDEX `objectType_UNIQUE` (`objectType` ASC)  COMMENT '',
  PRIMARY KEY (`objectType`)  COMMENT '',
  CONSTRAINT `fk_configuration_root1`
    FOREIGN KEY (`rootId`)
    REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`menu_configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`menu_configuration` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`menu_configuration` (
  `objectType` VARCHAR(15) NOT NULL COMMENT '',
  `rootId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `literalKey` VARCHAR(45) NOT NULL COMMENT '',
  `iconClassName` VARCHAR(45) NOT NULL COMMENT '',
  INDEX `fk_menu_configuration_root1_idx` (`rootId` ASC)  COMMENT '',
  UNIQUE INDEX `objectType_UNIQUE` (`objectType` ASC)  COMMENT '',
  PRIMARY KEY (`objectType`)  COMMENT '',
  CONSTRAINT `fk_menu_configuration_root1`
    FOREIGN KEY (`rootId`)
    REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`filter_configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`filter_configuration` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`filter_configuration` (
  `objectType` VARCHAR(15) NOT NULL COMMENT '',
  `rootId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `showDisk` TINYINT NOT NULL COMMENT '',
  `diskDefault` TINYINT UNSIGNED NOT NULL COMMENT '',
  `showTextProperties` VARCHAR(255) NOT NULL COMMENT '',
  `showPeriod` TINYINT NOT NULL COMMENT '',
  PRIMARY KEY (`objectType`)  COMMENT '',
  UNIQUE INDEX `objectType_UNIQUE` (`objectType` ASC)  COMMENT '',
  INDEX `fk_filter_configuration_root1_idx` (`rootId` ASC)  COMMENT '',
  INDEX `fk_filter_configuration_disk1_idx` (`diskDefault` ASC)  COMMENT '',
  CONSTRAINT `fk_filter_configuration_root1`
    FOREIGN KEY (`rootId`)
    REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_filter_configuration_disk1`
    FOREIGN KEY (`diskDefault`)
    REFERENCES `flaredro_preview`.`disk` (`diskId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`properties_configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`properties_configuration` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`properties_configuration` (
  `propertiesConfigurationId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `rootId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `objectType` VARCHAR(15) NOT NULL COMMENT '',
  `property` VARCHAR(15) NOT NULL COMMENT '',
  `defaultValue` VARCHAR(45) NOT NULL COMMENT '',
  `literalKey` VARCHAR(45) NOT NULL COMMENT '',
  `type` VARCHAR(15) NOT NULL COMMENT '',
  `localized` TINYINT NOT NULL COMMENT '',
  `base64Encode` TINYINT NOT NULL COMMENT '',
  `validate` VARCHAR(45) NOT NULL COMMENT '',
  `validateCondition` VARCHAR(3) NOT NULL COMMENT '',
  `validateErrorLiteralKey` VARCHAR(45) NOT NULL COMMENT '',
  INDEX `fk_properties_configuration_root1_idx` (`rootId` ASC)  COMMENT '',
  PRIMARY KEY (`propertiesConfigurationId`)  COMMENT '',
  UNIQUE INDEX `propertiesConfigurationId_UNIQUE` (`propertiesConfigurationId` ASC)  COMMENT '',
  CONSTRAINT `fk_properties_configuration_root1`
    FOREIGN KEY (`rootId`)
    REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`list_configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`list_configuration` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`list_configuration` (
  `listConfigurationId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `rootId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `objectType` VARCHAR(15) NOT NULL COMMENT '',
  `property` VARCHAR(15) NOT NULL COMMENT '',
  `literalKey` VARCHAR(45) NOT NULL COMMENT '',
  `formatType` VARCHAR(15) NOT NULL COMMENT '',
  `width` TINYINT NOT NULL COMMENT '',
  INDEX `fk_list_configuration_root1_idx` (`rootId` ASC)  COMMENT '',
  PRIMARY KEY (`listConfigurationId`)  COMMENT '',
  UNIQUE INDEX `listConfigurationId_UNIQUE` (`listConfigurationId` ASC)  COMMENT '',
  CONSTRAINT `fk_list_configuration_root1`
    FOREIGN KEY (`rootId`)
    REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`folder_file`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`folder_file` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`folder_file` (
  `folderFileId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `fileId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `folderId` BIGINT UNSIGNED NOT NULL COMMENT '',
  PRIMARY KEY (`folderFileId`)  COMMENT '',
  INDEX `fk_folder_file_file1_idx` (`fileId` ASC)  COMMENT '',
  INDEX `fk_folder_file_folder1_idx` (`folderId` ASC)  COMMENT '',
  CONSTRAINT `fk_folder_file_file1`
    FOREIGN KEY (`fileId`)
    REFERENCES `flaredro_preview`.`file` (`fileId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_folder_file_folder1`
    FOREIGN KEY (`folderId`)
    REFERENCES `flaredro_preview`.`folder` (`folderId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`object_folder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`object_folder` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`object_folder` (
  `folderId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `objectId` BIGINT UNSIGNED NOT NULL COMMENT '',
  INDEX `fk_object_folder_folder1_idx` (`folderId` ASC)  COMMENT '',
  INDEX `fk_object_folder_object1_idx` (`objectId` ASC)  COMMENT '',
  CONSTRAINT `fk_object_folder_folder1`
    FOREIGN KEY (`folderId`)
    REFERENCES `flaredro_preview`.`folder` (`folderId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_object_folder_object1`
    FOREIGN KEY (`objectId`)
    REFERENCES `flaredro_preview`.`object` (`objectId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`user_folder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`user_folder` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`user_folder` (
  `folderId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `userId` BIGINT UNSIGNED NOT NULL COMMENT '',
  INDEX `fk_user_folder_folder1_idx` (`folderId` ASC)  COMMENT '',
  INDEX `fk_user_folder_user1_idx` (`userId` ASC)  COMMENT '',
  CONSTRAINT `fk_user_folder_folder1`
    FOREIGN KEY (`folderId`)
    REFERENCES `flaredro_preview`.`folder` (`folderId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_folder_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `flaredro_preview`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`css_configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`css_configuration` ;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`css_configuration` (
  `cssConfigurationId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
  COMMENT '',
  `rootId` BIGINT UNSIGNED NOT NULL COMMENT '',
  `name` VARCHAR(45) NOT NULL COMMENT '',
  `selector` VARCHAR(255) NOT NULL COMMENT '',
  `styles` TEXT NOT NULL COMMENT '',
  PRIMARY KEY (`cssConfigurationId`)  COMMENT '',
  INDEX `fk_css_configuration_root1_idx` (`rootId` ASC)  COMMENT '',
  UNIQUE INDEX `cssConfigurationId_UNIQUE` (`cssConfigurationId` ASC)
    COMMENT '',
  CONSTRAINT `fk_css_configuration_root1`
  FOREIGN KEY (`rootId`)
  REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flaredro_preview`.`var_configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flaredro_preview`.`var_configuration`;

CREATE TABLE IF NOT EXISTS `flaredro_preview`.`var_configuration` (
  `variable` VARCHAR(45)     NOT NULL
  COMMENT '',
  `rootId`   BIGINT UNSIGNED NOT NULL
  COMMENT '',
  `name`     VARCHAR(45)     NOT NULL
  COMMENT '',
  `value`    TEXT            NULL
  COMMENT '',
  UNIQUE INDEX `var_UNIQUE` (`variable` ASC)
    COMMENT '',
  INDEX `fk_var_configuration_root1_idx` (`rootId` ASC)
    COMMENT '',
  PRIMARY KEY (`variable`)
    COMMENT '',
  CONSTRAINT `fk_var_configuration_root1`
    FOREIGN KEY (`rootId`)
    REFERENCES `flaredro_preview`.`root` (`rootId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`plan`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`plan` (`planId`, `type`, `price`, `allowedSpace`) VALUES (1, '2M', 45.00, 200);
INSERT INTO `flaredro_preview`.`plan` (`planId`, `type`, `price`, `allowedSpace`) VALUES (2, '5M', 60.00, 500);
INSERT INTO `flaredro_preview`.`plan` (`planId`, `type`, `price`, `allowedSpace`) VALUES (3, '1G', 75.00, 1000);
INSERT INTO `flaredro_preview`.`plan` (`planId`, `type`, `price`, `allowedSpace`) VALUES (4, '2G', 95.00, 2000);
INSERT INTO `flaredro_preview`.`plan` (`planId`, `type`, `price`, `allowedSpace`) VALUES (5, '5G', 120.00, 5000);

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`root`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`root` (`rootId`, `planId`, `name`, `selectedSkin`, `domainExpirationDate`) VALUES (1, 2, 'FlareDrop Development', 'orange', '1990-01-01');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`privilege`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`privilege` (`privilegeId`, `type`) VALUES (1, 'r');
INSERT INTO `flaredro_preview`.`privilege` (`privilegeId`, `type`) VALUES (2, 'w');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`disk`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`disk` (`diskId`, `name`) VALUES (1, 'manager');
INSERT INTO `flaredro_preview`.`disk` (`diskId`, `name`) VALUES (2, 'website');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`folder`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`folder` (`folderId`, `parentFolderId`, `rootId`, `diskId`, `privilegeId`, `visible`, `objectType`, `index`, `data`) VALUES (1, NULL, 1, 1, 1, 0, 'user', 0, '');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`folder_lan`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`folder_lan` (`lanId`, `folderId`, `tag`, `name`, `description`, `data`) VALUES (1, 1, 'ca_ES', 'Administradors', '', '');
INSERT INTO `flaredro_preview`.`folder_lan` (`lanId`, `folderId`, `tag`, `name`, `description`, `data`) VALUES (2, 1, 'es_ES', 'Administradores', '', '');
INSERT INTO `flaredro_preview`.`folder_lan` (`lanId`, `folderId`, `tag`, `name`, `description`, `data`) VALUES (3, 1, 'en_US', 'Administrators', '', '');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`user` (`userId`, `privilegeId`, `creationDate`, `name`, `password`, `validated`, `email`, `firstName`, `middleName`, `lastName`, `location`, `cp`, `city`, `region`, `country`, `phone1`, `phone2`, `data`) VALUES (1, 1, '1990-01-01', 'admin', '00ffa7b2cb65656d0f8815e7a0e41c1b', 1, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`object_configuration`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`object_configuration` (`objectType`, `rootId`, `bundle`, `foldersLink`, `foldersShow`, `folderOptionsShow`, `folderLevels`, `filesEnabled`, `folderFilesEnabled`, `picturesEnabled`, `folderPicturesEnabled`, `pictureDimensions`, `pictureQuality`) VALUES ('user', 1, 'ManagerUsers', 0, 1, 1, 1, 1, 1, 1, 1, '100x100', 70);
INSERT INTO `flaredro_preview`.`object_configuration` (`objectType`, `rootId`, `bundle`, `foldersLink`, `foldersShow`, `folderOptionsShow`, `folderLevels`, `filesEnabled`, `folderFilesEnabled`, `picturesEnabled`, `folderPicturesEnabled`, `pictureDimensions`, `pictureQuality`) VALUES ('product', 1, 'ManagerProducts', 0, 1, 1, 2, 1, 1, 1, 1, '100x100', 70);
INSERT INTO `flaredro_preview`.`object_configuration` (`objectType`, `rootId`, `bundle`, `foldersLink`, `foldersShow`, `folderOptionsShow`, `folderLevels`, `filesEnabled`, `folderFilesEnabled`, `picturesEnabled`, `folderPicturesEnabled`, `pictureDimensions`, `pictureQuality`) VALUES ('new', 1, 'ManagerNews', 0, 1, 1, 2, 1, 1, 1, 1, '100x100', 70);

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`menu_configuration`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`menu_configuration` (`objectType`, `rootId`, `literalKey`, `iconClassName`) VALUES ('user', 1, 'MAIN_MENU_MODULE_USERS', 'menuIconUser');
INSERT INTO `flaredro_preview`.`menu_configuration` (`objectType`, `rootId`, `literalKey`, `iconClassName`) VALUES ('product', 1, 'MAIN_MENU_MODULE_PRODUCTS', 'menuIconObject');
INSERT INTO `flaredro_preview`.`menu_configuration` (`objectType`, `rootId`, `literalKey`, `iconClassName`) VALUES ('new', 1, 'MAIN_MENU_MODULE_NEWS', 'menuIconNew');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`filter_configuration`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`filter_configuration` (`objectType`, `rootId`, `showDisk`, `diskDefault`, `showTextProperties`, `showPeriod`) VALUES ('user', 1, 1, 1, 'name;email', 1);
INSERT INTO `flaredro_preview`.`filter_configuration` (`objectType`, `rootId`, `showDisk`, `diskDefault`, `showTextProperties`, `showPeriod`) VALUES ('product', 1, 0, 2, 'title;description;price', 0);
INSERT INTO `flaredro_preview`.`filter_configuration` (`objectType`, `rootId`, `showDisk`, `diskDefault`, `showTextProperties`, `showPeriod`) VALUES ('new', 1, 0, 2, 'title;description', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`properties_configuration`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (1, 1, 'user', 'name', '', 'PROPERTY_NAME', 'text', 0, 0, 'default', 'AND', 'ERROR_NAME');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (2, 1, 'user', 'password', '', 'PROPERTY_PSW', 'password', 0, 1, 'password', 'AND', 'ERROR_PSW');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (3, 1, 'user', 'email', '', 'PROPERTY_EMAIL', 'text', 0, 0, 'empty;email', 'OR', 'ERROR_EMAIL');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (4, 1, 'product', 'title', '', 'PROPERTY_TITLE', 'text', 1, 0, 'fill', 'AND', 'ERROR_TITLE');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (5, 1, 'product', 'description', '', 'PROPERTY_DESCRIPTION', 'textarea', 1, 0, 'fill', 'AND', 'ERROR_DESCRIPTION');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (6, 1, 'product', 'price', '', 'PROPERTY_PRICE', 'text', 0, 0, '', '', '');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (7, 1, 'product', 'visible', '', 'PROPERTY_VISIBLE', 'check', 0, 0, '', '', '');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (8, 1, 'new', 'title', '', 'PROPERTY_TITLE', 'text', 1, 0, 'fill', 'AND', 'ERROR_TITLE');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (9, 1, 'new', 'description', '', 'PROPERTY_DESCRIPTION', 'textarea', 1, 0, 'fill', 'AND', 'ERROR_DESCRIPTION');
INSERT INTO `flaredro_preview`.`properties_configuration` (`propertiesConfigurationId`, `rootId`, `objectType`, `property`, `defaultValue`, `literalKey`, `type`, `localized`, `base64Encode`, `validate`, `validateCondition`, `validateErrorLiteralKey`) VALUES (10, 1, 'new', 'visible', '', 'PROPERTY_VISIBLE', 'check', 0, 0, '', '', '');

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`list_configuration`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (1, 1, 'user', 'userId', 'PROPERTY_ID', 'text', 10);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (2, 1, 'user', 'name', 'PROPERTY_NAME', 'text', 50);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (3, 1, 'user', 'creationDate', 'PROPERTY_CREATION_DATE', 'text', 20);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (4, 1, 'user', 'email', 'PROPERTY_EMAIL', 'text', 20);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (5, 1, 'product', 'title', 'PROPERTY_TITLE', 'text', 30);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (6, 1, 'product', 'description', 'PROPERTY_DESCRIPTION', 'text', 50);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (7, 1, 'product', 'objectId', 'PROPERTY_ID', 'text', 10);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (8, 1, 'product', 'visible', 'PROPERTY_VISIBLE', 'check', 10);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (9, 1, 'new', 'title', 'PROPERTY_TITLE', 'text', 40);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (10, 1, 'new', 'description', 'PROPERTY_DESCRIPTION', 'text', 50);
INSERT INTO `flaredro_preview`.`list_configuration` (`listConfigurationId`, `rootId`, `objectType`, `property`, `literalKey`, `formatType`, `width`) VALUES (11, 1, 'new', 'visible', 'PROPERTY_VISIBLE', 'check', 10);

COMMIT;


-- -----------------------------------------------------
-- Data for table `flaredro_preview`.`user_folder`
-- -----------------------------------------------------
START TRANSACTION;
USE `flaredro_preview`;
INSERT INTO `flaredro_preview`.`user_folder` (`folderId`, `userId`) VALUES (1, 1);

COMMIT;

