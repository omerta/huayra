<?php
// update_article_attribute.php <article_id> <attribute> <new_attribute> <new_value>
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$article = $argv[1];
$attribute = $argv[2];
$newAttribute = $argv[3];
$newValue = $argv[4];

$articleAttribute = $entityManager->find('ArticleAttribute', array(
  "article" => $article, "attribute" => $attribute));

if ($articleAttribute === null) {
    echo "Article $article and $newAttrinute does not exist.\n";
    exit(1);
}

$articleAttribute->setAttribute($newAttribute);
$articleAttribute->setValue($newValue);

$entityManager->flush();

echo sprintf("-%s %s %s\n",
  $articleAttribute->getArticle(),
  $articleAttribute->getAttribute(),
  $articleAttribute->getValue());
