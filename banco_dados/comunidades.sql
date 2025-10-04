create table comunidade (
    idComunidade int not null auto_increment primary key,
    idUser int,
    comunidade int,
    mensagens text
    foreign key(idUser) references usuarios(idUser)
)default charset = utf8;