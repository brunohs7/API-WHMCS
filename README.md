# Script de Monitoramento de E-mails para Domínios com API WHMCS

Este script PHP foi desenvolvido para monitorar a caixa de entrada de um e-mail específico (via IMAP), buscar mensagens relacionadas a domínios registrados, extrair informações dos e-mails e, com base nos dados do domínio, consultar a API do WHMCS para verificar se o domínio está associado a um cliente. Caso o domínio não esteja registrado, o script irá exibir informações relevantes ou realizar ações específicas conforme as regras definidas.

## Funcionalidades
- Conecta-se ao servidor de e-mail via IMAP.
- Verifica os e-mails não lidos com assuntos específicos, relacionados a domínios registrados.
- Extrai informações do assunto e corpo do e-mail.
- Verifica o estado do domínio registrado por meio da API WHMCS.
- Realiza ações com base nos dados do domínio e estado da conta do cliente no WHMCS.
- Exibe informações detalhadas sobre os domínios processados.

## Requisitos
- Servidor com PHP instalado.
- Extensão IMAP habilitada no PHP.
- Conta de e-mail configurada para acesso IMAP.
- Acesso à API do WHMCS (URL, nome de usuário e senha para autenticação).
- Certifique-se de ter as credenciais e configurações da API do WHMCS corretamente configuradas.

## Configuração
1. Configuração de e-mail (IMAP)
- Substitua as variáveis $login e $senha com suas credenciais de e-mail para conexão IMAP.
- Verifique a conexão IMAP, especialmente a URL do servidor, como por exemplo imap.gmail.com:993/imap/ssl/novalidate-cert para contas do Gmail.

2. Configuração da API WHMCS
- Substitua as variáveis $url, $username, e $password com as credenciais da API WHMCS:
- - $url: URL do arquivo da API do WHMCS.
- - $username: Nome de usuário de administração.
- - $password: Senha de administração.

3. Assuntos de E-mail
- O script verifica e-mails com assuntos relacionados a domínios, como:
- - "Extensão de prazo de pagamento"
- - "Fatura de registro"
- - "Aviso de descongelamento"
- - Outros associados a registros de domínios no Registro.br.

## Como Usar
1. Configure as credenciais de e-mail e a API do WHMCS conforme descrito na seção de configuração.
2. Execute o script em seu servidor PHP.
3. O script irá:
- Conectar-se à caixa de entrada de e-mail.
- Buscar e-mails não lidos com assuntos específicos.
- Processar as informações de cada e-mail, como o domínio registrado.
- Consultar a API do WHMCS para verificar o status do domínio e exibir os resultados.
4. A resposta da API WHMCS será analisada para determinar se o domínio está associado a um cliente e exibir as informações relevantes.

## Exemplo de Saída
- Assunto: Extensão de prazo de pagamento
- Domínio: example.com
- ID do Cliente: 12345
- Status do Domínio: Pendente de pagamento

## Observações
- Segurança: Certifique-se de proteger as credenciais da API e do e-mail.
- Erros de Conexão: Caso o script não consiga se conectar ao servidor de e-mail ou à API, ele exibirá mensagens de erro. Certifique-se de que as configurações de rede e os serviços necessários estão funcionando corretamente.
- Depuração: O script pode ser modificado para adicionar registros de depuração ou mais informações conforme necessário.