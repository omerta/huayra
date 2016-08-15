<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * SafTipoestructura
 *
 * @Table(name="saf_tipoestructura", indexes={@Index(name="IDX_241FFE6D5ECE3182", columns={"codemp"})})
 * @Entity
 */
class SafTipoestructura
{
    /**
     * @var string
     *
     * @Column(name="codtipest", type="string", length=4, nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $codtipest;

    /**
     * @var string
     *
     * @Column(name="dentipest", type="string", length=50, nullable=true)
     */
    private $dentipest;

    /**
     * @Column(name="codemp", type="string", length=4, nullable=false)
     */
    private $codemp;

    /**
     * Set codtipest
     *
     * @param string $codtipest
     *
     * @return SafTipoestructura
     */
    public function setCodtipest($codtipest)
    {
        $this->codtipest = $codtipest;

        return $this;
    }

    /**
     * Get codtipest
     *
     * @return string
     */
    public function getCodtipest()
    {
        return $this->codtipest;
    }

    /**
     * Set dentipest
     *
     * @param string $dentipest
     *
     * @return SafTipoestructura
     */
    public function setDentipest($dentipest)
    {
        $this->dentipest = $dentipest;

        return $this;
    }

    /**
     * Get dentipest
     *
     * @return string
     */
    public function getDentipest()
    {
        return $this->dentipest;
    }

    /**
     * Set codemp
     *
     * @param \SigespEmpresa $codemp
     *
     * @return SafTipoestructura
     */
    public function setCodemp($codemp)
    {
        $this->codemp = $codemp;

        return $this;
    }

    /**
     * Get codemp
     *
     * @return \SigespEmpresa
     */
    public function getCodemp()
    {
        return $this->codemp;
    }
}
