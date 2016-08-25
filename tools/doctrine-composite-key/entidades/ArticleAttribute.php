<?php
use Doctrine\Common\Collections\ArrayCollection;
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

   public function getArticle()
   {
     return $this->article;
   }

   public function getAttribute()
   {
     return $this->attribute;
   }

   public function setAttribute($attribute)
   {
     $this->attribute = $attribute;
   }

   public function getValue()
   {
     return $this->value;
   }

   public function setValue($value)
   {
     $this->value = $value;
   }
}
