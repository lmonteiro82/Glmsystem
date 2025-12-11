# GLM System

## Visão geral

Aplicação web em PHP para gestão e catálogo de conteúdos (front‑office e backoffice). Inclui páginas públicas (catálogo, blog, contacto) e um backoffice para administrar registos. Utiliza MySQL como base de dados e recursos estáticos em `assets/`.

## Tecnologias

- PHP 7.4+ (compatível com 8.x)
- MySQL/MariaDB
- HTML, CSS e JavaScript (ficheiros: `style.css`, `script.js`)
- Servidor web (Apache/Nginx) ou servidor embutido do PHP

## Estrutura do projeto

- `index.php` – Página inicial
- `catalogo.php`, `blog.php`, `contacto.php` – Páginas públicas
- `contactomail.php` – Envio de email de contacto
- `automatoslogin.php`, `passchange.php`, `registar_automatos.php` – Fluxos de autenticação/gestão de utilizadores
- `backoffice/` – Área administrativa (módulos, listagens, CRUD)
- `header.php`, `footer.php` – Partes comuns do layout
- `bd.php` – Ligação à base de dados (credenciais)
- `atualizar_bd.sql` – Script SQL de estrutura/atualização da BD
- `ALTERACOES_CATALOGO.md` – Histórico/observações do catálogo
- `assets/` – Imagens e recursos
- `script.js`, `style.css` – Recursos de front‑end
- `teste_bd.php` – Verificação de ligação à BD

## Pré‑requisitos

- PHP 7.4+ com extensão mysqli
- MySQL 5.7+ ou MariaDB 10.3+
- Servidor web (Apache com mod_php ou Nginx com PHP‑FPM)

## Instalação

1) Clonar o repositório

2) Criar a base de dados e importar estrutura
- Criar uma BD vazia no MySQL
- Importar o ficheiro `atualizar_bd.sql`

3) Configurar ligação à base de dados
- Editar `bd.php` e atualizar: `bd_host`, `bd_user`, `bd_password`, `bd_database`
- Confirmar ligação executando `teste_bd.php` no browser

4) Configurar o servidor
- Apache: apontar o DocumentRoot para a raiz do projeto
- Nginx: configurar server block para servir a raiz e encaminhar PHP para PHP‑FPM
- Alternativa rápida (dev): servidor embutido do PHP
  - `php -S localhost:8000 -t .`

## Execução (desenvolvimento)

- Com servidor embutido: abrir `http://localhost:8000`
- Com Apache/Nginx: abrir o domínio/host configurado

## Backoffice

- Diretório: `backoffice/`
- Requer credenciais de utilizador. Garanta que existem utilizadores criados na BD após importar o SQL ou através dos fluxos de registo existentes.

## Segurança e configuração

- As credenciais de BD atualmente são lidas de `bd.php`. Em produção, recomenda‑se mover para variáveis de ambiente e excluir credenciais do controlo de versão.
- Valide permissões de pastas se houver uploads (por exemplo, `assets/`), conforme necessário.
- Ative HTTPS e cabeçalhos de segurança no servidor web (HSTS, X‑Frame‑Options, CSP, etc.).

## Emails

- `contactomail.php` envia emails a partir do formulário de contacto. Configure o servidor de email/SMTP do ambiente conforme a sua infraestrutura.

## Troubleshooting

- Erro de ligação à BD: rever `bd.php`, utilizador/host e privilégios MySQL.
- Erros 500 em PHP: ativar `display_errors` em ambiente de desenvolvimento ou consultar logs do servidor.
- Rotas não encontradas: confirme que o DocumentRoot aponta para a raiz do projeto.

## Roadmap (sugestões)

- Externalizar credenciais para `.env`
- Sanitização/validação adicional de inputs
- CSRF tokens e hardening no backoffice
- Automatizar deploy (CI/CD) e backups da BD

## Licença

Definida pelo proprietário do projeto. Atualize esta secção se necessário.
