# PHP7

## Instalar phpbrew

```bash
curl -L -O https://github.com/phpbrew/phpbrew/raw/master/phpbrew
chmod +x phpbrew

# Mover phpbrew a un lugar donde pueda ser encontrado por $PATH
sudo mv phpbrew /usr/local/bin/phpbrew
```

## Configurar phpbrew

Iniciar un script bash en nuestra terminal:

```bash
phpbrew init
```

Agregar las siguientes lineas al archivo ~/.bashrc y ejecutar una nueva
consola:

```bash
export PHPBREW_SET_PROMPT=1
export PHPBREW_RC_ENABLE=1
source /home/prometeo/.phpbrew/bashrc
```

Dependencias del SO:

# aptitude install libbz2-dev libmcrypt-dev libxslt1-dev

## Instalar PHP7

Actualizar lista de versiones disponibles:

```bash
$ phpbrew know
```

Instalar PHP7:

```bash
$ phpbrew install 7.1 +default
```

## Usar phpbrew

Activar la versión de PHP7:

```bash
$ phpbrew switch php-7.1.1
```

Iniciar el servidor:

```bash
/var/www/huayra/$ php -S 127.0.0.1:8000
```
