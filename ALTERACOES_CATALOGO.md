# Alterações no Sistema de Catálogo Online

## 📋 Resumo das Alterações

O sistema foi **simplificado de 3 níveis para 2 níveis**:

### Antes:
- Títulos → Categorias → Produtos

### Agora:
- **Categorias** → **Produtos**

---

## ✨ Novidades

### 1. **Página do Catálogo Online** (`catalogo.php`)
- ✅ Barra de pesquisa no topo
- ✅ Cards de categorias em grid (exibido por padrão)
- ✅ Cards de produtos (exibido ao clicar numa categoria)
- ✅ Design moderno e responsivo como na imagem de referência
- ✅ Botão "Voltar às Categorias" quando mostra produtos
- ✅ Pesquisa em tempo real

### 2. **Backoffice - Gestão de Categorias** (`alterar_categorias.php`)
- ✅ Adicionado campo **Imagem** (upload de imagem para cada categoria)
- ✅ Adicionado campo **Descrição** (texto descritivo da categoria)
- ✅ Removido campo "Correspondente" (já não é necessário)
- ✅ Interface simplificada
- ✅ Botão "Gerir Categorias" no catálogo online

### 3. **Backoffice - Gestão de Produtos** (`catalogoonline.php`)
- ✅ Removido botão "Alterar Títulos"
- ✅ Interface mais limpa
- ✅ Produtos continuam a ser associados diretamente às categorias

---

## 🗄️ Alterações na Base de Dados

Execute o script **`atualizar_bd.sql`** no phpMyAdmin para:

1. Adicionar campos `imagem` e `descricao` à tabela `categorias`
2. Remover campo `correspondente` (opcional)
3. Criar índices para melhor performance

**Tabela `categorias` atualizada:**
```
- id (INT, AUTO_INCREMENT)
- nome (VARCHAR)
- imagem (VARCHAR) ← NOVO
- descricao (TEXT) ← NOVO
```

**Tabela `produtos` (sem alterações):**
```
- id (INT, AUTO_INCREMENT)
- imagem (VARCHAR)
- nome (VARCHAR)
- preco (DECIMAL)
- texto (TEXT)
- link (VARCHAR)
- categoria (VARCHAR) ← Liga aos nomes das categorias
```

---

## 📁 Novos Ficheiros/Pastas

- `backoffice/page/uploads/` - Pasta para imagens das categorias
- `atualizar_bd.sql` - Script SQL para atualizar a base de dados
- `ALTERACOES_CATALOGO.md` - Este ficheiro de documentação

---

## 🚀 Como Usar

### No Backoffice:

1. **Criar Categorias:**
   - Aceda a "Gerir Categorias" no backoffice
   - Preencha: Nome, Upload de Imagem, Descrição
   - Clique em "Inserir"

2. **Criar Produtos:**
   - Aceda ao "Catálogo Online" no backoffice
   - Selecione a categoria no dropdown
   - Preencha os dados do produto
   - Clique em "Inserir"

### No Site:

1. Página inicial mostra **cards das categorias**
2. Clique numa categoria para ver os **produtos dessa categoria**
3. Use a **barra de pesquisa** para filtrar
4. Clique em "Voltar às Categorias" para voltar

---

## ⚠️ Notas Importantes

- As imagens das categorias são guardadas em `backoffice/page/uploads/`
- Certifique-se que a pasta tem permissões de escrita (chmod 755)
- Os produtos continuam associados às categorias pelo **nome** da categoria
- A tabela `titulos` já não é usada (pode ser eliminada opcionalmente)
- A tabela `pesquisa` continua a ser sincronizada automaticamente com as categorias

---

## 🎨 Layout

O novo layout segue o design moderno da imagem de referência:
- Cards grandes com imagens
- Sombras e hover effects
- Grid responsivo
- Barra de pesquisa elegante
- Interface limpa e profissional

---

## 📞 Suporte

Se tiver problemas:
1. Verifique se executou o script SQL
2. Verifique permissões da pasta uploads
3. Teste criar uma categoria com imagem
4. Teste criar um produto associado à categoria
