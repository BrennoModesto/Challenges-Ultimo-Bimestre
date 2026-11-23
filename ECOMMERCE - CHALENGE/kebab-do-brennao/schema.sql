-- schema.sql — Kebab do Brennão
CREATE DATABASE IF NOT EXISTS kebab_do_brenao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kebab_do_brenao;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS itens_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('cliente','admin') NOT NULL DEFAULT 'cliente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    imagem VARCHAR(255) DEFAULT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produtos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    forma_pagamento ENUM('pix','boleto','cartao') NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_pedidos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_itens_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    CONSTRAINT fk_itens_produto FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (nome, email, senha, perfil) VALUES
('Administrador', 'admin@kebab.com', '$2y$10$DDiBk5TDZ00kkwM5r/yHs.AxYIWAshY6T8K2rtyEsrFy.2IX4g3IO', 'admin'),
('Cliente Teste', 'cliente@teste.com', '$2y$10$DcqC6aK6LJp8GjNApQcXhe36cHsoNWLILHj0Fn7lMdB5H9u1lbdfK', 'cliente');

INSERT INTO categorias (nome, slug) VALUES
('Kebab', 'kebab'),
('Esfihas', 'esfihas'),
('Pratos Árabes', 'pratos-arabes'),
('Bebidas', 'bebidas');

INSERT INTO produtos (categoria_id, nome, descricao, preco, estoque) VALUES
(1, 'Kebab de Carne', 'Espetinho de carne bovina temperada com especiarias árabes, servido no pão sírio com salada, molho de alho e tahine.', 24.90, 40),
(1, 'Kebab de Frango', 'Frango marinado em iogurte, limão e zaatar, grelhado na brasa e servido no pão sírio com vegetais frescos.', 22.90, 35),
(1, 'Shawarma', 'Fatias finas de carne assada no espeto vertical, enroladas no pão árabe com picles, tomate e molho de gergelim.', 27.50, 30),
(2, 'Esfiha de Carne', 'Esfiha aberta tradicional com carne moída temperada, cebola, tomate e limão.', 6.50, 120),
(2, 'Esfiha de Queijo', 'Esfiha aberta recheada com queijo muçarela e coalhada, massa leve e dourada.', 6.00, 100),
(3, 'Falafel', 'Porção com 8 bolinhos crocantes de grão-de-bico, coentro e especiarias, acompanhados de molho tahine.', 21.00, 50),
(3, 'Homus', 'Pasta cremosa de grão-de-bico com tahine, limão e azeite de oliva, servida com pão sírio.', 18.00, 45),
(3, 'Tabule', 'Salada de trigo fino, salsinha, hortelã, tomate e cebola, temperada com limão e azeite.', 16.50, 40),
(3, 'Quibe', 'Porção com 6 unidades de quibe frito de carne bovina com trigo, recheado com carne e pinoli.', 26.00, 25),
(4, 'Suco de Tâmara', 'Suco gelado de tâmaras com leite e toque de canela, 400 ml.', 12.00, 60);
