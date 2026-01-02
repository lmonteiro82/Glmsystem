-- Script para adicionar subcategorias ao sistema GLM

-- Criar tabela de subcategorias
CREATE TABLE IF NOT EXISTS subcategorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    categoria_id INT NOT NULL,
    imagem VARCHAR(255),
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Adicionar coluna subcategoria_id na tabela produtos
ALTER TABLE produtos ADD COLUMN subcategoria_id INT NULL AFTER categoria;

-- Adicionar foreign key para subcategorias (opcional, pode ser NULL)
ALTER TABLE produtos ADD CONSTRAINT fk_produtos_subcategoria 
    FOREIGN KEY (subcategoria_id) REFERENCES subcategorias(id) ON DELETE SET NULL;

-- Adicionar índices para melhor performance
CREATE INDEX idx_subcategorias_categoria ON subcategorias(categoria_id);
CREATE INDEX idx_produtos_subcategoria ON produtos(subcategoria_id);
