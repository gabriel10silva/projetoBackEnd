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