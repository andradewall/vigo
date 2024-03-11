# Laragon
1. [Link - baixar o full](https://laragon.org/download/index.html)
2. Abrir o Laragon e minimizar

# Baixar  arquivos binários do PHP
1. [Link](https://windows.php.net/downloads/releases/php-8.2.13-Win32-vs16-x64.zip)
2. Descompactar pasta
3. Mover pasta descompactada para `C:\laragon\bin\php`
4. Dentro dessa pasta de destino, devem ficar as seguintes pastas:
	- `php-8.1.10-Win32-vs16-x64`
	- `php-8.2.13-Win32-vs16-x64`

# Iniciar serviços do Laragon
1. Abrir o Laragon
2. Clicar em `Iniciar Tudo`
3. Autorizar todos os serviços que forem solicitados

# Mudar versão do PHP no Laragon
O Laragon fica executando na Barra de Tarefas.
Quando ele está com os serviços desativados, ele é um quadrado verde.
1. Clique com o botão direito no ícone do Laragon e selecione a opção `PHP > Version [php-8.1.10-Win32-vs16-x64] > php-8.2.13-Win32-vs16-x64`
2. Reiniciar o Laragon através da janela dele clicando em `Reload` (ou clicando em `Pausar Tudo` e depois `Iniciar Tudo`)

# Baixar sistema
1. Abrir o Terminal do Laragon
2. O terminal irá abrir na pasta `C:\laragon\www`
3. Rodar o comando:
```bash
git clone https://github.com/andradewall/vigo.git
```

# Config sistema
1. Abrir o Terminal do Laragon
2. Digitar os comandos:
3. Entrar na pasta:
```bash
cd vigo 
```
4. Instalar pacotes PHP (esse pode demorar)
```bash
composer install --prefer-dist --no-dev -o
```
5. Instalar pacotes Javascript (esse pode demorar)
```bash
npm install
```
6. Criar arquivo das variáveis de ambiente
```bash
cp .env.example .env
```
7. Editar arquivo criado
```bash
nano .env
```
8. Editar as seguintes variáveis para o seguinte valor:
```bash
APP_NAME=Vigo
APP_ENV=production
# ...
APP_DEBUG=false
APP_URL=http://vigo.test
# ...
```
9. Apertar `CTRL + O` e depois `ENTER` para salvar
10. Apertar `CTRL + X` para sair da edição do arquivo
11. Gerar a chave do sistema
```bash
php artisan key:generate
```
12. Gerar as tabelas do banco de dados
    1. Vão aparecer algumas perguntas com as alternativas `yes/no`. Digite `yes` para tudo
```bash
php artisan migrate
```
13. Compilar arquivos
```bash
npm run build
```
14. Limpar cache
```bash
php artisan optimize:clear
```
15. Otimizar
```bash
php artisan route:cache && php artisan view:cache && php artisan config:cache && php artisan event:cache
```
	
# Testar sistema
1. O link para o sistema é `http://vigo.test`

# Limpar testes
1. Abrir o terminal do Laragon
2. Rodar comando
```bash
php artisan migrate:fresh
```

# Criar o atalho na Área de Trabalho para o link do sistema

# Configurações do Laragon
1. Abrir janela do Laragon e clicar na engrenagem (ícone de configuração no canto superior direito)
2. Marcar a opção `Rodar minimizado` (Run minimized)
