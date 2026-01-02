# Sistema de Subcategorias - GLMSystem

## Instruções de Instalação

### 1. Atualizar Base de Dados

Execute o script SQL `update_subcategorias.sql` na sua base de dados MySQL:

```bash
mysql -u glmsyste -p glmsyste_glmsystem1 < update_subcategorias.sql
```

Ou através do phpMyAdmin:
1. Aceda ao phpMyAdmin
2. Selecione a base de dados `glmsyste_glmsystem1`
3. Vá ao separador "SQL"
4. Copie e cole o conteúdo do ficheiro `update_subcategorias.sql`
5. Execute o script

### 2. Funcionalidades Implementadas

#### Backoffice
- **Gerir Subcategorias**: Nova página em `backoffice/page/alterar_subcategorias.php`
  - Criar subcategorias associadas a categorias
  - Editar subcategorias existentes
  - Eliminar subcategorias
  - Upload de imagens para subcategorias

- **Gerir Produtos**: Página atualizada em `backoffice/page/catalogoonline.php`
  - Campo adicional para selecionar subcategoria (opcional)
  - Carregamento dinâmico de subcategorias ao selecionar categoria
  - Produtos podem estar numa categoria OU numa subcategoria

#### Frontend (Catálogo)
- **Navegação por Níveis**:
  1. Categorias → Subcategorias → Produtos
  2. Se uma categoria não tiver subcategorias, mostra produtos diretamente
  3. Botão "Voltar" para navegação intuitiva

### 3. Estrutura da Base de Dados

#### Nova Tabela: `subcategorias`
- `id` - ID único da subcategoria
- `nome` - Nome da subcategoria
- `categoria_id` - ID da categoria pai (FK)
- `imagem` - Caminho da imagem
- `descricao` - Descrição da subcategoria
- `created_at` - Data de criação

#### Tabela Atualizada: `produtos`
- Novo campo: `subcategoria_id` (INT NULL)
- Permite que produtos estejam em subcategorias

### 4. Fluxo de Utilização

#### No Backoffice:
1. Aceda a "Gerir Categorias" para criar/editar categorias principais
2. Aceda a "Gerir Subcategorias" para criar subcategorias dentro das categorias
3. Ao criar/editar produtos, selecione a categoria e opcionalmente uma subcategoria

#### No Frontend:
1. Cliente vê as categorias principais
2. Ao clicar numa categoria:
   - Se tiver subcategorias → mostra as subcategorias
   - Se não tiver subcategorias → mostra produtos diretamente
3. Ao clicar numa subcategoria → mostra produtos dessa subcategoria

### 5. Arquivos Criados/Modificados

#### Novos Arquivos:
- `update_subcategorias.sql` - Script SQL para criar estrutura
- `backoffice/page/alterar_subcategorias.php` - Gestão de subcategorias
- `backoffice/page/get_subcategorias.php` - API para carregar subcategorias via AJAX

#### Arquivos Modificados:
- `backoffice/page/catalogoonline.php` - Adicionado suporte a subcategorias
- `catalogo.php` - Navegação por categorias e subcategorias

### 6. Notas Importantes

- Subcategorias são **opcionais** - produtos podem estar apenas numa categoria
- Se eliminar uma categoria, as suas subcategorias são eliminadas automaticamente
- Se eliminar uma subcategoria, os produtos dessa subcategoria ficam apenas com a categoria
- Imagens de subcategorias são guardadas em `backoffice/page/uploads/`

### 7. Suporte

Para questões ou problemas, contacte o desenvolvedor.
