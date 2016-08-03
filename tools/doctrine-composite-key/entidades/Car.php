<?php
/**
 * @Entity
 */
 class Car
 {
   /** @Id @Column(type="string") */
   private $name;
   /** @Id @Column(type="integer") */
   private $year;

   public function __construct($name, $year)
   {
     $this->name = $name;
     $this->year = $year;
   }

   public function getModelName()
   {
     return $this->name;
   }

   public function getYearOfProduction()
   {
     return $this->year;
   }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Car
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Car
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }
}
