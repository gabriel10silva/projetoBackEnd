create table comentarios (
    idComentario int not auto_increment primary key,
    idUser int,
    comentario text
    foreign key(idUser) references usuarios(id)
)default charset = utf8;

create table respostas (
    idRest int not nul auto_increment  primary key,
    idComent int,
    resposta text,
    curtida int,
    foreign key(idComent) references comentarios(idComentario)
)default charset = utf8;