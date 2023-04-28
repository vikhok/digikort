DROP DATABASE IF EXISTS digikort;
CREATE DATABASE IF NOT EXISTS digikort;
USE digikort;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET GLOBAL event_scheduler=ON;

CREATE TABLE `user` (
    `user_id`     int(11)         NOT NULL,
    `first_name`  varchar(64)     NOT NULL,
    `last_name`   varchar(64)     NOT NULL,
    `job_title`   varchar(64)     DEFAULT NULL,
    `email`       varchar(128)    NOT NULL,
    `phone`       varchar(15)     NOT NULL,
    `pass`        varchar(255)    NOT NULL
);

CREATE TABLE `company` (
    `company_id`    int(11)       NOT NULL,
    `company_name`  varchar(64)   NOT NULL UNIQUE,
    `company_email` varchar(128)  NOT NULL,
    `descriptions`  varchar(255)  NOT NULL,
    `web_url`       varchar(255)  NOT NULL,
    `company_address` varchar(128)  NOT NULL,
    `city`          varchar(64)   NOT NULL,
    `zip`           int(4)        NOT NULL
);

CREATE TABLE `note` (
    `note_id`       int(11)       NOT NULL,
    `user_id`       int(11)       NOT NULL,
    `note_subject`  varchar(255)  NOT NULL,
    `note_body`     varchar(255)  NOT NULL,
    `note_date`     datetime      NOT NULL
);

CREATE TABLE `reset_password` (
    `email`         varchar(128)  NOT NULL,
    `security_code` varchar(6)    NOT NULL,
    `valid_to`      datetime      DEFAULT NULL
);

CREATE TABLE `business_card` (
    `card_id`       int(11)       NOT NULL,
    `user_id`       int(11)       NOT NULL,
    `company_id`    int(11)       NOT NULL,
    `administrator` boolean       NOT NULL DEFAULT false
);

CREATE TABLE `user_social` (
    `user_id`   int(11)       NOT NULL,
    `linkedin`  varchar(255)  DEFAULT NULL,
    `github`    varchar(255)  DEFAULT NULL,
    `instagram` varchar(255)  DEFAULT NULL
);

CREATE TABLE `company_social` (
    `company_id`  int(11)       NOT NULL,
    `linkedin`    varchar(255)  DEFAULT NULL,
    `github`      varchar(255)  DEFAULT NULL,
    `instagram`   varchar(255)  DEFAULT NULL
);


-- Keys:

ALTER TABLE `user`
    ADD PRIMARY KEY (`user_id`),
    ADD UNIQUE KEY `user_id` (`user_id`),
    ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `note`
    ADD PRIMARY KEY (`note_id`),
    ADD KEY `user_id` (`user_id`);

ALTER TABLE `reset_password`
    ADD PRIMARY KEY (`email`),
    ADD UNIQUE KEY `email` (`email`),
    ADD UNIQUE KEY `security_code` (`security_code`);

ALTER TABLE `business_card`
    ADD PRIMARY KEY (`card_id`),
    ADD KEY `company_id` (`company_id`),
    ADD KEY `user_id` (`user_id`);

ALTER TABLE `company`
    ADD PRIMARY KEY (`company_id`);

ALTER TABLE `user_social`
    ADD PRIMARY KEY (`user_id`),
    ADD KEY `user_id` (`user_id`);

ALTER TABLE `company_social`
    ADD PRIMARY KEY (`company_id`),
    ADD KEY `company_id` (`company_id`);


-- AUTO_INCREMENT:

ALTER TABLE `user`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `company`
    MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `note`
    MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `business_card`
    MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT;


-- Constraints on cascade:

ALTER TABLE `note`
    ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `reset_password`
    ADD CONSTRAINT `reset_password_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

ALTER TABLE `business_card`
    ADD CONSTRAINT `business_card_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `business_card_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE;

ALTER TABLE `user_social`
    ADD CONSTRAINT `user_social_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `company_social`
    ADD CONSTRAINT `company_social_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE;


-- Reset_password validation event:

CREATE DEFINER=`root`@`localhost` EVENT `reset_password_validation_limit` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-03-14 20:00:10' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM reset_password where valid_to<NOW();

COMMIT;