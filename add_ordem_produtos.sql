-- Script para adicionar campo de ordem aos produtos

-- Adicionar coluna ordem_exibicao na tabela produtos
ALTER TABLE produtos ADD COLUMN ordem_exibicao INT DEFAULT 0 AFTER subcategoria_id;

-- Criar índice para melhorar performance de ordenação
CREATE INDEX idx_produtos_ordem ON produtos(categoria, subcategoria_id, ordem_exibicao);

-- Atualizar produtos existentes com ordem baseada no ID (ordem atual)
UPDATE produtos SET ordem_exibicao = id;
