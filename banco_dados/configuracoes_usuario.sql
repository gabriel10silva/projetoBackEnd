CREATE TABLE configuracoes_usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    notificacoes_email BOOLEAN DEFAULT TRUE,
    tema_escuro BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
