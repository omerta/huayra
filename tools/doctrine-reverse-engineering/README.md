Dependencias

* symfony/yaml

Instalación:

```bash
$ php composer.phar require symfony/yaml
```

# Ejemplo, Generar la entidad de la tabla *saf_tipoestructura*



## Generar la entidad *SigespEmpresa*

Editar el archivo **cli-config.php** editando el *setFilterSchemaAssetsExpression* para que
solo importe la tabla *saf_tipoestructura*:

```bash
$conn->getConfiguration()->setFilterSchemaAssetsExpression("~^(saf_tipoestructura$)~");
```

Se importa la tabla *saf_tipoestructura* para generar la entidad *SafTipoestructura*:

```bash
$ php vendor/bin/doctrine orm:convert-mapping --from-database annotation entidades/
Processing entity "SafTipoestructura"

Exporting "annotation" mapping information to "/var/www/demos/doctrine-reverse-engineering/entidades"
```

Reemplazar las incidencias `@ORM\` por `@`.

Generar los *métodos* (getters y setters):

```bash
$ php vendor/bin/doctrine orm:generate-entities --generate-methods --filter=SafTipoestructura entidades/
Processing entity "SafTipoestructura"

Entity classes generated to "/var/www/demos/doctrine-reverse-engineering/entidades"
```

## Generar la entidad *SigespEmpresa* (FK de saf_tipoestructura)

Editar el archivo **cli-config.php** editando el *setFilterSchemaAssetsExpression* para que
solo importe la tabla *sigesp_empresa*:

```bash
$conn->getConfiguration()->setFilterSchemaAssetsExpression("~^(sigesp_empresa$)~");
```

Importar la tabla *sigesp_empresa* generando la entidad *SigespEmpresa*:

```bash
$ php vendor/bin/doctrine orm:convert-mapping --from-database annotation entidades/
Processing entity "SigespEmpresa"

Exporting "annotation" mapping information to "/var/www/demos/doctrine-reverse-engineering/entidades"
```
