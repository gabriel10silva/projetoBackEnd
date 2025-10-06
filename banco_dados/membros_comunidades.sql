CREATE TABLE membros_comunidades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_comunidade INT,
    data_adesao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_comunidade) REFERENCES comunidades(id),
    UNIQUE KEY (id_usuario, id_comunidade)
);