<?php
/**
 * @Entity
 */
 class Article
 {
   /** @Id @Column(type="integer") @GeneratedValue */
   private $id;
   /** @Column(type="string") */
   private $title;

   /**
    * @OneToMany(targetEntity="ArticleAttribute", mappedBy="article", cascade={"ALL"}, indexBy="attribute")
    */
    private $attributes;

    public function addAttribute($name, $value)
    {
      $this->attributes[$name] = new ArticleAttribute($name, $value, $this);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
     public function setTitle($title)
     {
         $this->title = $title;

         return $this;
     }

     /**
      * Get title
      *
      * @return string
      */
     public function getTitle()
     {
         return $this->title;
     }
 }

 /**
  * @Entity
  */
  class ArticleAttribute
  {
    /** @Id @ManyToOne(targetEntity="Article", inversedBy="attributes") */
    private $article;

    /** @Id @Column(type="string") */
    private $attribute;

    /** @Column(type="string") */
    private $value;

    public function __construct($name, $value, $article)
    {
      $this->attribute = $name;
      $this->value = $value;
      $this->article = $article;
    }

    /**
     * Remove attribute
     *
     * @param \ArticleAttribute $attribute
     */
    public function removeAttribute(\ArticleAttribute $attribute)
    {
        $this->attributes->removeElement($attribute);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /** Get $attribute
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->atribute;
    }
}
