--create user myuser with password 'mypass';
CREATE USER myuser;
CREATE DATABASE mydb;

GRANT ALL PRIVILEGES ON DATABASE mydb TO myuser;
CREATE TABLE empleado
(
	clave integer NOT NULL,
	nombre character varying,
	direccion character varying,
	telefono character varying,
	CONSTRAINT pk_clave PRIMARY KEY (clave) 
);