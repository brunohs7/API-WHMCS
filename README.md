# Script para Contagem de E-mails e Extração de Domínios

Este script permite visualizar informações sobre a caixa de entrada de uma conta do Gmail, incluindo o número total de mensagens e o domínio extraído do remetente de cada e-mail.

## Funcionalidades

- Conta o total de mensagens na caixa de entrada do Gmail.
- Exibe o assunto de cada e-mail presente na caixa de entrada.
- Extrai o domínio do remetente de cada e-mail (ex: gmail.com, yahoo.com).
- Exibe essas informações de forma clara e organizada em uma interface web.

## Exemplo de Saída

O script exibe as seguintes informações no navegador:

- **Total de Mensagens na Caixa de Entrada:** X
- **Assunto:** [Assunto do e-mail]
- **Domínio:** [Domínio extraído do e-mail]

Essas informações são exibidas de forma clara e organizada para o usuário, permitindo uma visão rápida e intuitiva do estado da caixa de entrada e dos e-mails presentes.

## Como Funciona

- **Conexão com o Gmail:** O script usa a API do Gmail para se conectar à conta de e-mail do usuário. É necessário que o usuário tenha autenticado a aplicação com a permissão adequada para acessar a caixa de entrada do Gmail.
  
- **Contagem de Mensagens:** O número total de mensagens na caixa de entrada é obtido através da consulta `users.messages.list`, que retorna a quantidade de mensagens no Gmail.

- **Extração de Dados dos E-mails:** A partir da lista de mensagens, o script recupera o assunto de cada e-mail e extrai o domínio do remetente, utilizando expressões regulares para isolar o domínio a partir do endereço de e-mail do remetente.

- **Exibição no Navegador:** A informação é formatada e exibida no navegador utilizando HTML. Isso inclui a contagem total de mensagens, o assunto dos e-mails e o domínio extraído de cada remetente.

## Tecnologias Utilizadas

- **Node.js:** Para execução do script e manipulação de arquivos JSON.
- **Google API Client:** Para interação com a API do Gmail.
- **Express:** Para servir a interface web onde os dados são exibidos.
- **JavaScript:** Para lógica do backend e manipulação de dados.
- **HTML/CSS:** Para a interface de exibição no navegador.

## Configuração

### Passo 1: Obter credenciais da API do Gmail

1. Acesse o [Console de Desenvolvedor do Google](https://console.developers.google.com/).
2. Crie um novo projeto.
3. Habilite a API do Gmail.
4. Crie uma credencial do tipo **OAuth 2.0 Client ID**.
5. Baixe o arquivo `credentials.json` e coloque na raiz do seu projeto.

### Passo 2: Instalar Dependências

Execute o seguinte comando para instalar as dependências do projeto:

```bash
npm install
```

### Passo 3: Autenticação e Execução

1. Execute o script para autenticar a aplicação:

```bash
node authenticate.js
```

2. Após autenticação, execute o servidor para visualizar a saída no navegador:

```bash
node app.js
```

3. Acesse a interface web no seu navegador em http://localhost:3000.

## Contribuindo

Se você deseja contribuir com melhorias para este projeto, siga os passos abaixo:

1. Faça o fork deste repositório.
2. Crie uma branch para a sua feature (git checkout -b feature/MinhaFeature).
3. Faça as alterações necessárias e comite-as (git commit -am 'Adiciona nova feature').
4. Faça o push para a sua branch (git push origin feature/MinhaFeature).
5. Abra um Pull Request explicando as alterações realizadas.

## Licença
Este projeto está licenciado sob a MIT License - veja o arquivo LICENSE para mais detalhes.