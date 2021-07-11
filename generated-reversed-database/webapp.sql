
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- group_members
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `group_members`;

CREATE TABLE `group_members`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `group_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `group_id` (`group_id`, `user_id`),
    INDEX `user_id` (`user_id`),
    CONSTRAINT `group_members_ibfk_1`
        FOREIGN KEY (`group_id`)
        REFERENCES `groups` (`id`)
        ON UPDATE NO ACTION
        ON DELETE CASCADE,
    CONSTRAINT `group_members_ibfk_2`
        FOREIGN KEY (`user_id`)
        REFERENCES `groups` (`id`)
        ON UPDATE NO ACTION
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- groups
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `groupname` VARCHAR(63) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `groupname` (`groupname`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- login_attempts
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(63) DEFAULT '' NOT NULL,
    `attempted_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `remember` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
    `user_id` INTEGER DEFAULT 0,
    `logout_at` DATETIME,
    `note` VARCHAR(255) DEFAULT '' NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `username` (`username`),
    INDEX `user_id` (`user_id`),
    CONSTRAINT `login_attempts_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- permissions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(127) NOT NULL,
    `description` VARCHAR(1023) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `slug` (`slug`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- token_auths
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `token_auths`;

CREATE TABLE `token_auths`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `cookie_hash` VARCHAR(255) NOT NULL,
    `expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id` (`user_id`),
    CONSTRAINT `token_auths_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON UPDATE NO ACTION
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_permissions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_permissions`;

CREATE TABLE `user_permissions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `permissions_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id` (`user_id`),
    INDEX `permissions_id` (`permissions_id`),
    CONSTRAINT `user_permissions_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON UPDATE NO ACTION
        ON DELETE CASCADE,
    CONSTRAINT `user_permissions_ibfk_2`
        FOREIGN KEY (`permissions_id`)
        REFERENCES `permissions` (`id`)
        ON UPDATE NO ACTION
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(31) NOT NULL,
    `password` VARCHAR(63) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username` (`username`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
