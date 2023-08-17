CREATE table roles(
idRole int not null auto_increment primary key,
nome varchar(100)
);

CREATE table estados(
idEstado int not null auto_increment primary  key,
nome varchar(20)
);

CREATE table generos(
    idGenero int not null auto_increment primary key,
    nome varchar(10)
);

CREATE table users(
idUser int not null auto_increment primary key,
  nome varchar(100),
  username varchar(100),
  password varchar(100),
  role int,
  estado int,
  dataInscrito date,
  foreign key(role) references roles(idRole),
  foreign key(estado) references estados(idEstado)
);