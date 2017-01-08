huayra/sigesp/sugau
======

* [Manual del Programador](doc/manual_desarrollador.adoc)

## Instalación

# Base de datos Postgresql

* Instarlar el manejador de base de datos.

```bash
# aptitude install postgresql php5-pgsql
```

* Crear un usuario

```bash
(postgres)$ createuser -P usuario_db -l -e
CREATE ROLE usuario_db PASSWORD 'md59244d5f06520dfa68b23bd40937646d1' NOSUPERUSER NOCREATEDB NOCREATEROLE INHERIT LOGIN;
```

* Cargar la base de datos inicial o la base de datos legada. Puede usar el script
tools/create_db.sh.

```bash
(postgres)$ bash sugau/tools/create_db.sh <DATABSE_NAME> <DATABASE_DUMP>.dump <usuario_db>
```

Se debe guardar la contraseña md5 para configurar el archivo *sigesp_config.php*.

* Activar el registro de sucesos de Postgresql (log), etc. Descomentar las
lines 59, 327, 329, 321 y 356 del archivo */etc/postgresql/9.4/main/postgresql.conf*:

```bash
listen_addresses = 'localhost'

logging_collector = on

log_directory = 'pg_log'

log_filename = 'postgresql-%Y-%m-%d_%H%M%S.log'

client_min_messages = log
```

Reiniciar la base de datos:

```bash
# systemctl restart postgresql
```

Nota: se puede ver el registro de sucesos en la siguiente ubicación.
```bash
# tail -f /var/lib/postgresql/9.4/main/pg_log/postgresql-2016-05-27_145743.log
```

* Ajusar el *PostgreSQL Client Authentication Configuration File*
(/etc/postgresql/9.4/main/pg_hba.conf).

```bash
host    <DATABSE_NAME>       <USER_NAME>      127.0.0.1/32            md5
```

Causar la relectura del archivo pg_hba.conf.

```bash
# systemctl reload postgresql
```

# Servidos Web Apache2

* Insalar apache2

```bash
# aptitude install apache2 libapache2-mod-php5
```

* Crear el VirtaulHost, ver *huayra/doc/apache2/002-huayra.conf*.
* Activar el VirtalHost
```bash
# a2ensite 002-huayra.conf
```

Causar la lectura del los sitios virutal disponibles.

```bash
# systemctl reload apache2
```

* (Opcional) si es un entorno local se debe editar el /etc/hosts.

# El archivo *sigesp_config.php*

* El gestor puede tener los siguientes valores: POSTGRES, INFORMIX.

# Twig

```bash
huayra/shared$ php composer.phar require twig/twig
```
