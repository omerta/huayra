$ php composer.phar require symfony/yaml


$ php vendor/bin/doctrine orm:convert-mapping --from-database annotation entidades/
Processing entity "SafTipoestructura"

Exporting "annotation" mapping information to "/var/www/demos/doctrine-reverse-engineering/entidades"

## Generar los *métodos* (getters y setters):

```bash
$ php vendor/bin/doctrine orm:generate-entities --generate-methods --filter=Car entidades/
Processing entity "Car"

Entity classes generated to "/var/www/demos/doctrine-composite-key-only-primitive/entidades"
```

## Generar los *métodos* (getters y setters)

$ php vendor/bin/doctrine orm:generate-entities --generate-methods --filter=Article entidades/
Processing entity "Article"
Processing entity "ArticleAttribute"

Entity classes generated to "/var/www/demos/doctrine-composite-key-only-primitive/entidades"
