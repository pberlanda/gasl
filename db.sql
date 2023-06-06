/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  paoloberlanda
 * Created: 16 mag 2023
 */
CREATE TABLE IF NOT EXISTS accounts (
    username varchar(30) not null,
    password varchar(30) not null,
    nome varchar(30) not null,
    cognome varchar(30) not null,
    tipo char(1) not null, -- valori ammessi S = studente, I Tutor interno, E Tutor esterno A = Admin -- MySQL non prevede i check come altri RDBMS quindi verrà gestito dall'app
    email varchar(50) not null,
    telefono_1 varchar(10) null,
    telefono_2 varchar(10) null,
    note text null,

    CONSTRAINT PK_username PRIMARY KEY (username)
);

INSERT INTO accounts (username, password, nome, cognome, tipo, email, telefono_1, telefono_2, note) VALUES ('paolob', '123456', paolo', 'berlanda', 'S', 'paolo.berlanda@marconirovereto.it', '3493141895', null, 'dev');
INSERT INTO accounts (username, password, nome, cognome, tipo, email, telefono_1, telefono_2, note) VALUES ('admin', '123456', paolo', 'berlanda', 'A', 'admin@gasl.it', '3493141895', null, 'admin')


