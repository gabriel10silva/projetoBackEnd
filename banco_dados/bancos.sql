desc usuarios;
drop database forum;
select * from usuarios;
create schema forum 
default char set utf8
default collate utf8_general_ci;

create table usuarios (
    id int not null primary key auto_increment,
    nome_usuario varchar(100),
    data_nascimento date,
    email_usuario varchar(100) unique not null,
    senha varchar(100) not null,
	area_foco enum('Humanas', 'Exatas', 'Tecnologia'),
    bio text,
    role enum('Usuário', 'Administrador') default 'Usuário',
    foto_perfil varchar(255) default '',
    data_cadastro timestamp default current_timestamp
)default charset = utf8;

select * from usuarios;


CREATE TABLE duvidas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

select * from duvidas;

alter table duvidas
add column curtidas int default 0 after conteudo;


CREATE TABLE comunidades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    foto_comunidade varchar(100) default 'profile.png',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)default charset = utf8;

drop table comunidades;
select * from comunidades;

alter table usuarios 
change area_atuação area_foco enum('Humanas', 'Exatas', 'Tecnologia' ) after senha;

select * from membros_comunidades;

truncate usuarios;

select * from membros_comunidades;
CREATE TABLE membros_comunidades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_comunidade INT,
    data_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_comunidade) REFERENCES comunidades(id),
    UNIQUE KEY (id_usuario, id_comunidade)
)default charset = utf8;

CREATE TABLE mensagens_comunidade (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_comunidade INT,
    id_usuario INT,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_comunidade) REFERENCES comunidades(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE respostas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_duvida INT,
    id_usuario INT,
    conteudo TEXT NOT NULL,
    imagem VARCHAR(100),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_duvida) REFERENCES duvidas(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);


select * from comunidades;