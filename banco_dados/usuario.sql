create table usuarios (
    id int not null auto_increment primary key,
    nome varchar(100),
    email varchar(100) unique not null,
    senha varchar(100)
)default charset = utf8;