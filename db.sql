DROP DATABASE IF EXISTS `instants`;
CREATE DATABASE IF NOT EXISTS `instants` DEFAULT CHARACTER SET utf8;
USE `instants`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user`
(
    `id`          INT(11)      NOT NULL AUTO_INCREMENT,
    `username`    VARCHAR(30)  NOT NULL,
    `description` VARCHAR(255) NULL     DEFAULT NULL,
    `email`       VARCHAR(255) NOT NULL,
    `pwd`         VARCHAR(60)  NOT NULL,
    `role`        VARCHAR(255) NOT NULL DEFAULT '[]',
    `vreg`        VARCHAR(13)  NULL     DEFAULT NULL,
    `createdAt`   DATETIME     NOT NULL,
    `updatedAt`   DATETIME     NOT NULL,
    `dateOfBirth` DATETIME     NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username` (`username`),
    UNIQUE INDEX `email` (`email`),
    UNIQUE INDEX `vreg` (`vreg`)
)
    COLLATE = 'utf8_general_ci'
    ENGINE = InnoDB
    AUTO_INCREMENT = 7;

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow`
(
    `follower` int(11) NOT NULL,
    `followee` int(11) NOT NULL,
    KEY `FK_follower` (`follower`),
    KEY `FK_followee` (`followee`),
    CONSTRAINT `FK_followee` FOREIGN KEY (`followee`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_follower` FOREIGN KEY (`follower`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post`
(
    `id`        int(11)      NOT NULL AUTO_INCREMENT,
    `author`    int(11)      NOT NULL,
    `content`   varchar(255) NOT NULL,
    `createdAt` timestamp    NOT NULL,
    `replyTo`   int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_post_user` (`author`),
    KEY `FK_post_post` (`replyTo`),
    CONSTRAINT `FK_post_post` FOREIGN KEY (`replyTo`) REFERENCES `post` (`id`),
    CONSTRAINT `FK_post_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `like`;
CREATE TABLE IF NOT EXISTS `like`
(
    `post`      int(11)   NOT NULL,
    `user`      int(11)   NOT NULL,
    `createdAt` timestamp NOT NULL,
    KEY `FK_like_post` (`post`),
    KEY `FK_like_user` (`user`),
    CONSTRAINT `FK_like_post` FOREIGN KEY (`post`) REFERENCES `post` (`id`),
    CONSTRAINT `FK_like_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages`
(
    `id`        int(11)      NOT NULL,
    `sender`    int(11)      NOT NULL,
    `receiver`  int(11)      NOT NULL,
    `content`   varchar(255) NOT NULL,
    `createdAt` timestamp    NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_messages_user` (`sender`),
    KEY `FK_messages_user_2` (`receiver`),
    CONSTRAINT `FK_messages_user` FOREIGN KEY (`sender`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_messages_user_2` FOREIGN KEY (`receiver`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
