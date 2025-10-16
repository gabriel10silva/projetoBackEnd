CREATE TABLE comunidades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    foto_comunidade varchar(100) default 'profile.png',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)default charset = utf8;
