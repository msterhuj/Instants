CREATE TABLE `users`
(
    `id`            INT(11)     NOT NULL AUTO_INCREMENT,
    `username`      VARCHAR(50) NOT NULL,
    `description`   VARCHAR(255) NULL DEFAULT NULL,
    `email`         VARCHAR(255) NOT NULL,
    `pwd`           VARCHAR(60) NOT NULL,
    `roles`         TEXT        NOT NULL,
    `verified_code` VARCHAR(50) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
)
    COLLATE = 'utf8_general_ci'
    ENGINE = InnoDB
;