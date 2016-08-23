<?php
// create_article_attribute.php <attribute> <value> <article_id>
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$newAttribute = $argv[1];
$newValue = $argv[2];
$articleId = $argv[3];

$article = $entityManager->find('Article', $articleId);
$articleAttribute = new ArticleAttribute($argv[1],$argv[2],$article);

$entityManager->persist($articleAttribute);
$entityManager->flush();

echo sprintf("- %s %s %s\n",
  $articleAttribute->getArticle(),
  $articleAttribute->getAttribute(),
  $articleAttribute->getValue());
