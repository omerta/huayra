<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 */
 class Article
 {
   /**
    * @Id @Column(type="integer")
    * @GeneratedValue
    */
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

    public function getId()
    {
      return $this->id;
    }

    public function getTitle()
    {
      return $this->title;
    }

    public function setTitle($title)
    {
      $this->title = $title;
    }

    public function __toString()
    {
      return $this->id.' '.$this->title;
    }
}
