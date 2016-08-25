<?php
/**
 * @Entity
 * @Table(name="saf_tipoestructura")
 */
class SafTipoestructura
{
    /**
     * @ManyToOne(targetEntity="SigespEmpresa")
     * @JoinColumn(name="codemp", referencedColumnName="codemp")
     */
    private $codemp;
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $codtipest;
    /**
     * @Column(length=50)
     */
    private $dentipest;

    public function getCodemp()
    {
      return $this->codemp;
    }

    public function SetCodemp($codemp)
    {
      $this->codemp = $codemp;
    }

    public function getCodtipest()
    {
      return $this->codtipest;
    }

    public function setDentipest($dentipest)
    {
      $this->dentipest = $dentipest;
    }

    public function getDentipest()
    {
      return $this->dentipest;
    }
}
 ?>
