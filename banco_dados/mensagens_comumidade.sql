CREATE TABLE mensagens_comunidade (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_comunidade INT,
    id_usuario INT,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_comunidade) REFERENCES comunidades(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;