<?php
// create_article.php
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$newTitle = $argv[1];

$article = new Article();
$article->setTitle($newTitle);

$entityManager->persist($article);
$entityManager->flush();

echo "Created Product with ID " . $article->getId() . "\n";
