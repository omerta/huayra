<?php
// show_article_attribute.php <article_id> <attribute>
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$article = $argv[1];
$attribute = $argv[2];

$articleAttribute = $entityManager->find('ArticleAttribute', array(
  "article" => $article, "attribute" => $attribute));


if ($articleAttribute === null) {
    echo "No article attribute found.\n";
    exit(1);
}

echo sprintf("-%s %s %s\n",
  $articleAttribute->getArticle(),
  $articleAttribute->getAttribute(),
  $articleAttribute->getValue());
