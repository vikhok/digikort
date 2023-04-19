#Testdata users
INSERT INTO user(first_name, last_name, job_title, email, phone, pass)
    VALUES ('Eivind', 'Halsnes', 'Senior systemarkitekt', 'ehalsnes@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK');
INSERT INTO user(first_name, last_name, job_title, email, phone, pass)
    VALUES ('Viktor', 'Hokland', 'Administrerende direktør', 'vikhokjoh@gmail.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK');
INSERT INTO user(first_name, last_name, job_title, email, phone, pass)
    VALUES ('Aleksander', 'Kolsrud', 'Front-end utvikler', 'alekkols@epost.com', '12345678', '$2y$10$DW5DBzBM7hes7GrzItn2huzQKXM3yX52T5ZvyPr.PyDT537AufolK');

#Testdata company
INSERT INTO company(company_name, company_email, descriptions, web_url)
    VALUES ('Egde Consulting AS', 'digikortpass@gmail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no');
INSERT INTO company(company_name, company_email, descriptions, web_url)
    VALUES ('Gard AS', 'digikortpass@gmail.com', 'Vi er et konsulent firma med et bredt spekter av kompetanse', 'www.egde.no');

#Testdata company_social
INSERT INTO company_social(company_id, linkedin, github, instagram)
    VALUES('1', 'https://www.linkedin.com/company/egde-consulting-as/', 'https://github.com/EgdeConsulting', 'https://www.instagram.com/egde_consulting/');
INSERT INTO company_social(company_id, linkedin)
    VALUES('2', 'https://www.linkedin.com/company/gard-as/');

#Testdata location
INSERT INTO location(company_id, address, city, zip)
    VALUES('1', 'Gravane 16', 'Kristiansand', '4610');
INSERT INTO location(company_id, address, city, zip)
    VALUES('1', 'Terje  Løvås vei 1', 'Grimstad', '4879');
INSERT INTO location(company_id, address, city, zip)
    VALUES('1', 'Dokkvegen 11', 'Porsgrunn', '3920');
INSERT INTO location(company_id, address, city, zip)
    VALUES('2', 'Bukkene Bruses vei 12', 'Kristiansand S', '4638');


#Testdata note
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('1', 'Møte med Ola', 'Husk møte med Ola på Slottsplassen 23 kl. 11 førstkommende mandag', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Sende tilbud', 'Husk å sende tilbud til Gard AS', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('2', 'Kjøpe melk', 'Husk å Kjøpe melk så min hustru ikke blir sint.', '2023-04-19 12:53:56');
INSERT INTO note(user_id, note_subject, note_body, note_date)
    VALUES('3', 'Kaffe-drøs', 'Husk å invitere til kaffi-drøs med daglig leder Per i Rent og Pent AS for å diskutere nytt samarbeid', '2023-04-19 12:53:56');

#Testdata business_card
INSERT INTO business_card(user_id, company_id, location_id, administrator)
    VALUES('1', '1', '1', 'true');
INSERT INTO business_card(user_id, company_id, location_id, administrator)
    VALUES('2', '2', '2', 'true');
INSERT INTO business_card(user_id, company_id, location_id, administrator)
    VALUES('3', '1', '2', 'false');


#Testdata user_social
INSERT INTO user_social(user_id, linkedin, github, instagram)
    VALUES('1', 'https://www.linkedin.com/in/eivind-hauge-halsnes-875542215/', 'https://github.com/ehalsnes', 'https://www.instagram.com/eivindhalsnes/')


