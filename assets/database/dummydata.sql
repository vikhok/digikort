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