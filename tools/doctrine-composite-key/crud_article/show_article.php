<?php
// show_article.php <id>
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$id = $argv[1];
$article = $entityManager->find('Article', $id);

if ($article === null) {
    echo "No article found.\n";
    exit(1);
}

echo sprintf("-%s %s\n", $article->getId(), $article->getTitle());
