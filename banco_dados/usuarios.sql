create database if not exists forum
default charset utf8
default collate utf8_general_ci;

create table usuarios (
    id int not null primary key auto_increment,
    nome_usuario varchar(100),
    email_usario varchar(100) unique not null,
    senha varchar(100) not null,
    bio text,
    foto_perfil varchar(255) default '',
    data_cadastro timestamp default current_timestamp
)