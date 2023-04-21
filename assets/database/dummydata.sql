#Testdata users
INSERT INTO user(first_name, last_name, job_title, email, phone, pass) VALUES 
    ('Eivind', 'Halsnes', 'Senior systemarkitekt', 'ehalsnes@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Viktor', 'Hokland', 'Administrerende direktør', 'vikhokjoh@gmail.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK'),
    ('Aleksander', 'Kolsrud', 'Front-end utvikler', 'alekkols@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK');

#Testdata user_social
INSERT INTO user_social(user_id, linkedin, github, instagram) VALUES 
    ('1', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/'),
    ('2', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/'),
    ('3', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/');

#Testdata company
INSERT INTO company(company_name, company_email, descriptions, web_url, address, city, zip) VALUES 
    ('Egde Consulting Kristiansand', 'egde@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no', 'Gravane 16', 'Kristiansand', '4610'),
    ('Egde Consulting Grimstad', 'egde@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no', 'Terje  Løvås vei 1', 'Grimstad', '4879'),
    ('Egde Consulting Porsgrunn', 'egde@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no', 'Dokkvegen 11', 'Porsgrunn', '3920'),
    ('Gard AS', 'gard@mail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.gard.no', 'Bukkene Bruses vei 12', 'Kristiansand S', '4638');

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
    ('3', '1', false);

#Testdata note
INSERT INTO note(user_id, note_subject, note_body, note_date) VALUES 
    ('1', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('2', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('2', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('2', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('2', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('2', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('2', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('2', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56'),
    ('3', 'Husk melk', 'Husk å kjøpe melk så ikke min hustru blir sint.', '2023-04-19 12:53:56');