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
    `company_id`            int(11)         NOT NULL,
    `company_name`          varchar(64)     NOT NULL UNIQUE,
    `company_email`         varchar(128)    NOT NULL,
    `company_desc`          varchar(255)    NOT NULL,
    `company_url`           varchar(255)    NOT NULL,
    `company_address`       varchar(128)    NOT NULL,
    `company_city`          varchar(64)     NOT NULL,
    `company_zip`           int(4)          NOT NULL,
    `access_code`           varchar(255)    NOT NULL
);

CREATE TABLE `note` (
    `note_id`       int(11)       NOT NULL,
    `user_id`       int(11)       NOT NULL,
    `note_subject`  varchar(64)   NOT NULL,
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

-- Delete empty company event:
CREATE DEFINER=`root`@`localhost` EVENT `delete_empty_company` ON SCHEDULE EVERY 1 DAY STARTS CURRENT_TIMESTAMP ENABLE DO DELETE FROM company WHERE company_id NOT IN (SELECT DISTINCT company_id FROM business_card);
COMMIT;


#Testdata users
INSERT INTO user(first_name, last_name, job_title, email, phone, pass) VALUES 
    ('Eivind', 'Halsnes', 'Senior systemarkitekt', 'ehalsnes@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Viktor', 'Hokland', 'Administrerende direktør', 'vikhokjoh@gmail.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Aleksander', 'Kolsrud', 'Front-end utvikler', 'alekkols@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Arvid', 'Hellstrøm', 'Arkitekt', 'ArvHel@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Henrik', 'Hjaldar', 'Praktikant', 'Henhja@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Julius', 'Apekatt', 'Sirkus ape', 'Julape@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Mikael', 'Mannemann', 'Senior Front-end utvikler','Mikman@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Kristian', 'Sund', 'Direktør', 'Krisun@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Ole', 'Kristiansen', 'Praktikant', 'Olekri@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Dole', 'Didriksen', 'Junior Utvikler', 'Doldid@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Doffen', 'Kragerud', 'Database Ekspert', 'Dofkra@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Donald', 'Durian', 'Daglig leder', 'Dondur@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK');

#Testdata user_social
INSERT INTO user_social(user_id, linkedin, github, instagram) VALUES 
    ('1', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/'),
    ('2', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/'),
    ('3', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/'),
    ('4', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/'),
    ('5', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/'),
    ('6', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/');

#Testdata company
INSERT INTO company(company_name, company_email, company_desc, company_url, company_address, company_city, company_zip, access_code) VALUES 
    ('Egde Consulting Kristiansand', 'egde@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no', 'Gravane 16', 'Kristiansand', '4610', 'hemmelig'),
    ('Egde Consulting Grimstad', 'egde@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no', 'Terje  Løvås vei 1', 'Grimstad', '4879', 'hemmelig'),
    ('Egde Consulting Porsgrunn', 'egde@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no', 'Dokkvegen 11', 'Porsgrunn', '3920', 'hemmelig'),
    ('Gard AS', 'gard@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.gard.no', 'Bukkene Bruses vei 12', 'Kristiansand S', '4638', 'hemmelig'),
    ('Klippehopping AS', 'klippe@mail.com', 'Vi er et konsulentselskap som leverer et bredt aspekt av klippehoppere.', 'Kliphop.no', 'Ramnfloget 1', 'Bodø', '8011', 'hemmelig'),
    ('Spiseriet til mor AS', 'spisemor@mail.com', 'Vi er et selskap som driver med catering av konsulent-kunnskap', 'Spisemor.no', 'Bolleveien 45', 'Stavanger', '4900', 'hemmelig'),
    ('Pappas pizzeria', 'Papapiza@mail.com', 'Vi er et selskap med et bredet spekter av pizza-utvalg', 'Papapiza.no', 'Hjartliveien 3', 'Bodø', '8011', 'hemmelig'),
    ('Hallgeirs bakeri', 'Hallbakeri@mail.com', 'Jeg styrer en bedrift som jobbed med agil baking', 'Hallgeirsbakeri.no', 'Barstølveien 32', 'Kristiansand', '4630', 'hemmelig'),
    ('Janis Jarnitsjarer', 'Janismusikk@mail.com', 'Dette er et korps som spesialiserer i hardware', 'Janismusikk.no', 'Utedoveien 3', 'Voss', '3210', 'hemmelig');

#Testdata company_social
INSERT INTO company_social(company_id, linkedin, github, instagram) VALUES 
    ('1', 'https://www.linkedin.com/company/egde-consulting-as/', 'https://github.com/EgdeConsulting', 'https://www.instagram.com/egde_consulting/'),
    ('2', 'https://www.linkedin.com/company/egde-consulting-as/', 'https://github.com/EgdeConsulting', 'https://www.instagram.com/egde_consulting/'),
    ('3', 'https://www.linkedin.com/company/egde-consulting-as/', 'https://github.com/EgdeConsulting', 'https://www.instagram.com/egde_consulting/');
INSERT INTO company_social(company_id, linkedin) VALUES 
    ('4', 'https://www.linkedin.com/company/gard-as/');

#Testdata business_card
INSERT INTO business_card(user_id, company_id, administrator) VALUES 
    ('1', '1', true),
    ('2', '2', true),
    ('3', '1', false),
    ('4', '3', true),
    ('5', '2', false),
    ('6', '3', false),
    ('7', '1', false);

#Testdata note
INSERT INTO note(user_id, note_subject, note_body, note_date) VALUES 
    ('1', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('2', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('2', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('2', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('2', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('2', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('2', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('2', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56'),
    ('3', 'TS9xMXpPSmMyYXFBNFYyNm5MMERPUT09OjqT5Hr8ejWqT7ZIQag8NvTN', 'UDUvYTlVQzZSd2dvN2s5Z1ErY2pqQWxDMnF0Z1d6bEhySkJkUm1nWHpuQmpScWQ2N0JlRlJENXFPMVJnalNscmxvZDErOTc4aGJ3bTIvZXR6VkZBUWd6UEZPdzk3TXlLczVXaWNxQ0hJL0E9OjojxBwfuGj2kMW8V2rzfv2o', '2023-04-19 12:53:56');