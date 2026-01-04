# Sistema de Ordenação de Produtos - GLMSystem

## Instruções de Instalação

### 1. Atualizar Base de Dados

Execute o script SQL `add_ordem_produtos.sql` na sua base de dados MySQL:

```bash
mysql -u glmsyste -p glmsyste_glmsystem1 < add_ordem_produtos.sql
```

Ou através do phpMyAdmin:
1. Aceda ao phpMyAdmin
2. Selecione a base de dados `glmsyste_glmsystem1`
3. Vá ao separador "SQL"
4. Copie e cole o conteúdo do ficheiro `add_ordem_produtos.sql`
5. Execute o script

### 2. Funcionalidades Implementadas

#### Backoffice - Gestão de Produtos
- **Botões de Ordenação**: Cada produto tem botões de seta para cima (🟢) e para baixo (🟡)
- **Indicador de Ordem**: Mostra o número da ordem atual de cada produto
- **Ordenação por Contexto**: A ordenação funciona dentro da categoria ou subcategoria selecionada

#### Como Usar:
1. Aceda a "Gestão de Produtos" no backoffice
2. Use os filtros para selecionar uma categoria ou subcategoria
3. Os produtos aparecem ordenados
4. Use os botões de seta para mover produtos:
   - **Seta Verde (↑)** - Move o produto para cima (aparece antes)
   - **Seta Amarela (↓)** - Move o produto para baixo (aparece depois)
5. A ordem é salva automaticamente

#### Frontend (Catálogo)
- Os produtos são exibidos na ordem definida no backoffice
- A ordenação é respeitada em:
  - Produtos de uma categoria
  - Produtos de uma subcategoria
  - Página principal do catálogo

### 3. Estrutura da Base de Dados

#### Campo Adicionado: `ordem_exibicao`
- Tipo: INT
- Default: 0
- Localização: Tabela `produtos`
- Função: Define a ordem de exibição dos produtos

### 4. Comportamento

#### Ordenação Inteligente:
- **Por Subcategoria**: Se o produto tem subcategoria, a ordem é dentro dessa subcategoria
- **Por Categoria**: Se o produto não tem subcategoria, a ordem é dentro da categoria
- **Independente**: Cada categoria/subcategoria tem sua própria ordenação

#### Exemplo Prático:
```
Categoria: INTRUSÃO
├── Subcategoria: Detetores
│   ├── Produto A (ordem: 1) ← Aparece primeiro
│   ├── Produto B (ordem: 2)
│   └── Produto C (ordem: 3) ← Aparece por último
└── Subcategoria: Sensores
    ├── Produto X (ordem: 1) ← Aparece primeiro (independente dos Detetores)
    └── Produto Y (ordem: 2)
```

### 5. Filtros e Ordenação

Para facilitar a gestão, o sistema agora:
1. **Não mostra produtos** até selecionar filtros
2. **Permite filtrar** por categoria e/ou subcategoria
3. **Mostra apenas** os produtos filtrados
4. **Permite ordenar** os produtos filtrados

### 6. Notas Importantes

- A ordenação é **automática** - não precisa salvar após mover
- Cada movimento **troca a posição** com o produto adjacente
- A ordem é **preservada** mesmo após editar outros campos do produto
- Produtos novos recebem **ordem automática** (baseada no ID)
- A ordem **não afeta** produtos de outras categorias/subcategorias

### 7. Arquivos Modificados

#### Novos Arquivos:
- `add_ordem_produtos.sql` - Script SQL para adicionar campo de ordem

#### Arquivos Modificados:
- `backoffice/page/catalogoonline.php` - Adicionado botões de ordenação e lógica
- `catalogo.php` - Atualizado para respeitar ordem_exibicao

### 8. Resolução de Problemas

**Produtos não aparecem ordenados?**
- Verifique se executou o script SQL
- Confirme que o campo `ordem_exibicao` existe na tabela `produtos`

**Botões de ordenação não funcionam?**
- Verifique se selecionou os filtros (categoria ou subcategoria)
- Confirme que há mais de um produto na categoria/subcategoria

**Ordem não é salva?**
- Verifique permissões de escrita na base de dados
- Confirme que não há erros no log do PHP

### 9. Suporte

Para questões ou problemas, contacte o desenvolvedor.
