<?php
// update_article.php <id> <new-title>
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$id = $argv[1];
$newTitle = $argv[2];

$article = $entityManager->find('Article', $id);

if ($article === null) {
    echo "Article $id does not exist.\n";
    exit(1);
}

$article->setTitle($newTitle);

$entityManager->flush();

echo sprintf("-%s %s\n",
  $article->getId(),
  $article->getTitle());
