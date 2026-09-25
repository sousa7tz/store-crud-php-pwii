CREATE DATABASE IF NOT EXISTS loja_etim
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE loja_etim;

CREATE TABLE IF NOT EXISTS produtos (
    id_produto INT NOT NULL AUTO_INCREMENT,
    nome_produto VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_produto)
);

CREATE TABLE IF NOT EXISTS imagens (
    id_imagem INT NOT NULL AUTO_INCREMENT,
    nome_imagem VARCHAR(255) NOT NULL,
    fk_id_produto INT NOT NULL,
    PRIMARY KEY (id_imagem),
    CONSTRAINT fk_imagens_produtos
        FOREIGN KEY (fk_id_produto)
        REFERENCES produtos(id_produto)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
