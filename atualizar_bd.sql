-- Script para atualizar a base de dados para o novo sistema de 2 níveis
-- Execute este script no phpMyAdmin ou MySQL

-- Adicionar campos 'imagem' e 'descricao' à tabela categorias (se não existirem)
ALTER TABLE `categorias` 
ADD COLUMN IF NOT EXISTS `imagem` VARCHAR(255) DEFAULT '' AFTER `nome`,
ADD COLUMN IF NOT EXISTS `descricao` TEXT DEFAULT '' AFTER `imagem`;

-- Remover campo 'correspondente' da tabela categorias (se existir)
ALTER TABLE `categorias` 
DROP COLUMN IF EXISTS `correspondente`;

-- Criar índice para melhorar performance nas buscas
ALTER TABLE `categorias` 
ADD INDEX IF NOT EXISTS `idx_nome` (`nome`);

-- Limpar dados órfãos (opcional - produtos sem categoria válida)
-- DELETE FROM produtos WHERE categoria NOT IN (SELECT nome FROM categorias);

-- Criar pasta para uploads (já foi criada pelo sistema)
-- Certifique-se que a pasta backoffice/page/uploads tem permissões 755
