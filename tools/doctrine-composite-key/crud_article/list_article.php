<?php
// list_article.php
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$articleRepository = $entityManager->getRepository('Article');
$articles = $articleRepository->findAll();

foreach ($articles as $article) {
    echo sprintf("-%s %s\n", $article->getId(), $article->getTitle());
}
