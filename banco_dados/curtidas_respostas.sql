CREATE TABLE curtidas_respostas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_resposta INT,
    id_usuario INT,
    FOREIGN KEY (id_resposta) REFERENCES respostas(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    UNIQUE KEY (id_resposta, id_usuario) -- Garante que um usuário só curta uma resposta uma vez
);