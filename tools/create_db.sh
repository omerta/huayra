#/bin/bash

## DESCRIPCIÓN:

## USO:

## Copyrigh 2016
## GPLv3

## global var
CONTACTOS=
nproc=`nproc`
touch /tmp/log_restore.log

if [[ -z "$1" ]]; then
   echo "Debe proveer el nombre de la base de datos."
   exit
else
    database=$1
fi

if [[ -z "$2" ]]; then
   echo "Debe proveer la base de datos (dump)."
   exit
else
    dump=$2
fi

if [[ -z "$3" ]]; then
   echo "Debe proveer el dueño de la base de datos (un usuario existente)."
   exit
else
    owner=$3
fi

# 0 not exist / 1 exist
DB=`psql -lqt | cut -d \| -f 1 | grep -w $database | wc -l`
if [[ $DB = 0 ]]; then
    echo "Create DB..."
    createdb $database --encoding=LATIN9 --encoding=LATIN9 --lc-collate=C --lc-ctype=C --template=template0
else
  echo "La base de datos ya existe."
fi

if [[ $DB = 1 ]]; then
    echo "Drop DB..."
    dropdb $database
    if [[ $? != 0 ]]; then
	     echo "Error $?: is not posible dropdb. Maybe, exists any current conexion on db."
	      exit
    fi
      echo "Create DB..."
      createdb $database --encoding=LATIN9 --lc-collate=C --lc-ctype=C --template=template0 --owner=$owner
fi

echo "Restore DB... (see details /tmp/log_restore.log)"
pg_restore -j $nproc -d $database $dump > /tmp/log_restore.log 2>&1

echo "Concediendo privilegios"
psql -d $database -c "GRANT ALL ON ALL TABLES IN SCHEMA public TO $owner"

/usr/bin/printf "%b" "\n\nUna base de datos fresca fue restaurada." | /usr/bin/mail -s "Base de datos" $dump $database $CONTACTOS
