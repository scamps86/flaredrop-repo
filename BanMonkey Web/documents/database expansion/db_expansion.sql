CREATE TABLE `flaredro_preview`.`bid` (
  `bidId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `objectId` BIGINT UNSIGNED NOT NULL,
  `userId` BIGINT UNSIGNED NOT NULL,
  `creationDate` DATETIME NOT NULL,
  PRIMARY KEY (`bidId`),
  UNIQUE INDEX `bidId_UNIQUE` (`bidId` ASC),
  INDEX `fk_userId_idx` (`userId` ASC),
  INDEX `fk_objectId_idx` (`objectId` ASC),
  CONSTRAINT `fk_userId`
    FOREIGN KEY (`userId`)
    REFERENCES `flaredro_preview`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_objectId`
    FOREIGN KEY (`objectId`)
    REFERENCES `flaredro_preview`.`object` (`objectId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


ALTER TABLE `flaredro_preview`.`bid`
ADD COLUMN `userNick` VARCHAR(20) NOT NULL AFTER `userId`,
ADD COLUMN `auctionExpireDate` DATETIME NOT NULL AFTER `creationDate`,
ADD COLUMN `currentPrice` DECIMAL(12,2) NOT NULL AFTER `auctionExpireDate`;


CREATE TABLE `flaredro_preview`.`bid_schedule` (
  `bidScheduleId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `userId` BIGINT UNSIGNED NOT NULL,
  `objectId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `maxBans` INT NOT NULL,
  `maxPrice` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`bidScheduleId`),
  INDEX `fk_user_idx` (`userId` ASC),
  INDEX `fk_object_idx` (`objectId` ASC),
  CONSTRAINT `fk_user`
    FOREIGN KEY (`userId`)
    REFERENCES `flaredro_preview`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_object`
    FOREIGN KEY (`objectId`)
    REFERENCES `flaredro_preview`.`object` (`objectId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
