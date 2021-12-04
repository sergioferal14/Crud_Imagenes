drop table if exists trabajadores;
drop table if exists empresas;

create table empresas(

    id int AUTO_INCREMENT primary key,
    nombre VARCHAR(100)  not null,
    facturacion float(8,2), 
    logo varchar(120) not null
);

create table trabajadores(
    id int AUTO_INCREMENT primary key,
    nombre varchar(80),
    apellidos varchar(40) not null,
    telefono int(9),
    departamento enum('Informatica','Diseño','Marketing','Recursos Humanos'), 
    empresa_id int,
    constraint fk_art_cat foreign key(empresa_id) references empresas(id) on delete cascade on update cascade
);