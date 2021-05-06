CREATE DATABASE IF NOT EXISTS `instants`;
USE `instants`;

CREATE TABLE IF NOT EXISTS `user`
(
    `id`          int(11)      NOT NULL AUTO_INCREMENT,
    `username`    varchar(30)  NOT NULL,
    `description` varchar(255)          DEFAULT NULL,
    `email`       varchar(255) NOT NULL,
    `pwd`         varchar(60)  NOT NULL,
    `role`        varchar(255) NOT NULL DEFAULT '[]',
    `vreg`        varchar(13)           DEFAULT NULL,
    `createdAt`   datetime     NOT NULL,
    `updatedAt`   datetime     NOT NULL,
    `dateOfBirth` datetime     NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `vreg` (`vreg`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 10
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `post`
(
    `id`        int(11)      NOT NULL AUTO_INCREMENT,
    `author`    int(11)      NOT NULL,
    `content`   varchar(255) NOT NULL,
    `createdAt` timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `replyTo`   int(11)               DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_post_user` (`author`),
    KEY `FK_post_post` (`replyTo`),
    CONSTRAINT `FK_post_post` FOREIGN KEY (`replyTo`) REFERENCES `post` (`id`),
    CONSTRAINT `FK_post_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8;

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

CREATE TABLE IF NOT EXISTS `like`
(
    `post`      int(11)   NOT NULL,
    `user`      int(11)   NOT NULL,
    `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    KEY `FK_like_post` (`post`),
    KEY `FK_like_user` (`user`),
    CONSTRAINT `FK_like_post` FOREIGN KEY (`post`) REFERENCES `post` (`id`),
    CONSTRAINT `FK_like_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `messages`
(
    `id`        int(11)      NOT NULL,
    `sender`    int(11)      NOT NULL,
    `receiver`  int(11)      NOT NULL,
    `content`   varchar(255) NOT NULL,
    `createdAt` timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `FK_messages_user` (`sender`),
    KEY `FK_messages_user_2` (`receiver`),
    CONSTRAINT `FK_messages_user` FOREIGN KEY (`sender`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_messages_user_2` FOREIGN KEY (`receiver`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `report`
(
    `id`        int(11)      NOT NULL AUTO_INCREMENT,
    `author`    int(11)      NOT NULL,
    `post`      int(11)      NOT NULL,
    `content`   varchar(255) NOT NULL,
    `createdAt` timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `FK_report_user` (`author`),
    KEY `FK_report_post` (`post`),
    CONSTRAINT `FK_report_post` FOREIGN KEY (`post`) REFERENCES `post` (`id`),
    CONSTRAINT `FK_report_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


