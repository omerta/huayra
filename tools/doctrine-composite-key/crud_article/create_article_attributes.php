<?php
/**
 * CREATE SEQUENCE Article_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
 * CREATE TABLE Article (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id));
 * CREATE TABLE ArticleAttribute (article_id INT NOT NULL, attribute VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(article_id, attribute));
 * CREATE INDEX IDX_149CA72E7294869C ON ArticleAttribute (article_id);
 * ALTER TABLE ArticleAttribute ADD CONSTRAINT FK_149CA72E7294869C FOREIGN KEY (article_id) REFERENCES Article (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
 *
 *  Tabla «public.article»
 * Columna |          Tipo          | Modificadores
 * ---------+------------------------+---------------
 * id      | integer                | not null
 * title   | character varying(255) | not null
 * Índices:
 * "article_pkey" PRIMARY KEY, btree (id)
 * Referenciada por:
 * TABLE "articleattribute" CONSTRAINT "fk_149ca72e7294869c" FOREIGN KEY (article_id) REFERENCES article(id)  *
 *
 * Tabla «public.articleattribute»
 * Columna   |          Tipo          | Modificadores
 * ------------+------------------------+---------------
 * article_id | integer                | not null
 * attribute  | character varying(255) | not null
 * value      | character varying(255) | not null
 * Índices:
 * "articleattribute_pkey" PRIMARY KEY, btree (article_id, attribute)
 * "idx_149ca72e7294869c" btree (article_id)
 * Restricciones de llave foránea:
 * "fk_149ca72e7294869c" FOREIGN KEY (article_id) REFERENCES article(id)
 */

require_once "bootstrap.php";
require_once "entidades/Article.php";

$name = $argv[1];
$value = $argv[2];
$articulo = $argv[3];

$article = $entityManager->find('Article', $articulo);

$articleAttribute = new ArticleAttribute($name,$value,$article);
//$article->addAttribute($name, $value);

$entityManager->persist($articleAttribute);
$entityManager->flush();

echo "Created Article with ID " . $article->getId() . "\n";
