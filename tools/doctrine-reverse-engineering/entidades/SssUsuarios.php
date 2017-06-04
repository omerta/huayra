<?php
/**
 * SssUsuarios
 *
 * @Table(name="sss_usuarios")
 * @Entity
 */
class SssUsuarios
{
    /**
     * @var string
     *
     * @Column(name="codemp", type="string", length=4, nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $codemp;

    /**
     * @var string
     *
     * @Column(name="codusu", type="string", length=30, nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $codusu;

    /**
     * @var string
     *
     * @Column(name="cedusu", type="string", length=8, nullable=true)
     */
    private $cedusu;

    /**
     * @var string
     *
     * @Column(name="nomusu", type="string", length=100, nullable=false)
     */
    private $nomusu;

    /**
     * @var string
     *
     * @Column(name="apeusu", type="string", length=50, nullable=false)
     */
    private $apeusu;

    /**
     * @var string
     *
     * @Column(name="pwdusu", type="string", length=50, nullable=false)
     */
    private $pwdusu;

    /**
     * @var string
     *
     * @Column(name="telusu", type="string", length=20, nullable=true)
     */
    private $telusu;

    /**
     * @var string
     *
     * @Column(name="nota", type="text", nullable=true)
     */
    private $nota;

    /**
     * @var integer
     *
     * @Column(name="actusu", type="smallint", nullable=true)
     */
    private $actusu;

    /**
     * @var integer
     *
     * @Column(name="blkusu", type="smallint", nullable=true)
     */
    private $blkusu;

    /**
     * @var integer
     *
     * @Column(name="admusu", type="smallint", nullable=true)
     */
    private $admusu;

    /**
     * @var \DateTime
     *
     * @Column(name="ultingusu", type="date", nullable=true)
     */
    private $ultingusu;

    /**
     * @var string
     *
     * @ORM\Column(name="fotousu", type="string", length=254, nullable=true)
     */
    private $fotousu;



    /**
     * Set codemp
     *
     * @param string $codemp
     *
     * @return SssUsuarios
     */
    public function setCodemp($codemp)
    {
        $this->codemp = $codemp;

        return $this;
    }

    /**
     * Get codemp
     *
     * @return string
     */
    public function getCodemp()
    {
        return $this->codemp;
    }

    /**
     * Set codusu
     *
     * @param string $codusu
     *
     * @return SssUsuarios
     */
    public function setCodusu($codusu)
    {
        $this->codusu = $codusu;

        return $this;
    }

    /**
     * Get codusu
     *
     * @return string
     */
    public function getCodusu()
    {
        return $this->codusu;
    }

    /**
     * Set cedusu
     *
     * @param string $cedusu
     *
     * @return SssUsuarios
     */
    public function setCedusu($cedusu)
    {
        $this->cedusu = $cedusu;

        return $this;
    }

    /**
     * Get cedusu
     *
     * @return string
     */
    public function getCedusu()
    {
        return $this->cedusu;
    }

    /**
     * Set nomusu
     *
     * @param string $nomusu
     *
     * @return SssUsuarios
     */
    public function setNomusu($nomusu)
    {
        $this->nomusu = $nomusu;

        return $this;
    }

    /**
     * Get nomusu
     *
     * @return string
     */
    public function getNomusu()
    {
        return $this->nomusu;
    }

    /**
     * Set apeusu
     *
     * @param string $apeusu
     *
     * @return SssUsuarios
     */
    public function setApeusu($apeusu)
    {
        $this->apeusu = $apeusu;

        return $this;
    }

    /**
     * Get apeusu
     *
     * @return string
     */
    public function getApeusu()
    {
        return $this->apeusu;
    }

    /**
     * Set pwdusu
     *
     * @param string $pwdusu
     *
     * @return SssUsuarios
     */
    public function setPwdusu($pwdusu)
    {
        $this->pwdusu = $pwdusu;

        return $this;
    }

    /**
     * Get pwdusu
     *
     * @return string
     */
    public function getPwdusu()
    {
        return $this->pwdusu;
    }

    /**
     * Set telusu
     *
     * @param string $telusu
     *
     * @return SssUsuarios
     */
    public function setTelusu($telusu)
    {
        $this->telusu = $telusu;

        return $this;
    }

    /**
     * Get telusu
     *
     * @return string
     */
    public function getTelusu()
    {
        return $this->telusu;
    }

    /**
     * Set nota
     *
     * @param string $nota
     *
     * @return SssUsuarios
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota
     *
     * @return string
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set actusu
     *
     * @param integer $actusu
     *
     * @return SssUsuarios
     */
    public function setActusu($actusu)
    {
        $this->actusu = $actusu;

        return $this;
    }

    /**
     * Get actusu
     *
     * @return integer
     */
    public function getActusu()
    {
        return $this->actusu;
    }

    /**
     * Set blkusu
     *
     * @param integer $blkusu
     *
     * @return SssUsuarios
     */
    public function setBlkusu($blkusu)
    {
        $this->blkusu = $blkusu;

        return $this;
    }

    /**
     * Get blkusu
     *
     * @return integer
     */
    public function getBlkusu()
    {
        return $this->blkusu;
    }

    /**
     * Set admusu
     *
     * @param integer $admusu
     *
     * @return SssUsuarios
     */
    public function setAdmusu($admusu)
    {
        $this->admusu = $admusu;

        return $this;
    }

    /**
     * Get admusu
     *
     * @return integer
     */
    public function getAdmusu()
    {
        return $this->admusu;
    }

    /**
     * Set ultingusu
     *
     * @param \DateTime $ultingusu
     *
     * @return SssUsuarios
     */
    public function setUltingusu($ultingusu)
    {
        $this->ultingusu = $ultingusu;

        return $this;
    }

    /**
     * Get ultingusu
     *
     * @return \DateTime
     */
    public function getUltingusu()
    {
        return $this->ultingusu;
    }
}
