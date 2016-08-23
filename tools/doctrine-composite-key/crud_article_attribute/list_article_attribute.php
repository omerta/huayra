<?php
// list_article_attributes.php
require_once "../bootstrap.php";
require_once "../entidades/Article.php";
require_once "../entidades/ArticleAttribute.php";

$articleRepository = $entityManager->getRepository('ArticleAttribute');
$articles = $articleRepository->findAll();

foreach ($articles as $article) {
    echo sprintf("-%s %s %s\n", $article->getArticle(), $article->getAttribute(), $article->getValue());
}
