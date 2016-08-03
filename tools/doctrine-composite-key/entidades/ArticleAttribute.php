<?php



/**
 * ArticleAttribute
 */
class ArticleAttribute
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $value;

    /**
     * @var \Article
     */
    private $article;


    /**
     * Set attribute
     *
     * @param string $attribute
     *
     * @return ArticleAttribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return ArticleAttribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set article
     *
     * @param \Article $article
     *
     * @return ArticleAttribute
     */
    public function setArticle(\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}

