<?php
/**
 * SssRegistroEventos
 *
 * @Table(name="sss_registro_eventos")
 * @Entity
 */
class SssRegistroEventos
{
    /**
     * @var integer
     *
     * @Column(name="numeve", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="sss_registro_eventos_numeve_seq", allocationSize=1, initialValue=171422)
     */
    private $numeve;

    /**
     * @var string
     *
     * @Column(name="codemp", type="string", length=4, nullable=true)
     */
    private $codemp;

    /**
     * @var string
     *
     * @Column(name="codusu", type="string", length=30, nullable=true)
     */
    private $codusu;

    /**
     * @var string
     *
     * @Column(name="codsis", type="string", length=3, nullable=true)
     */
    private $codsis;

    /**
     * @var string
     *
     * @Column(name="evento", type="string", length=10, nullable=true)
     */
    private $evento;

    /**
     * @var string
     *
     * @Column(name="nomven", type="string", length=80, nullable=true)
     */
    private $nomven;

    /**
     * @var string
     *
     * @Column(name="codintper", type="string", length=126, nullable=true)
     */
    private $codintper;

    /**
     * @var \DateTime
     *
     * @Column(name="fecevetra", type="datetime", nullable=true)
     */
    private $fecevetra;

    /**
     * @var string
     *
     * @Column(name="equevetra", type="string", length=60, nullable=true)
     */
    private $equevetra;

    /**
     * @var string
     *
     * @Column(name="desevetra", type="text", nullable=true)
     */
    private $desevetra;

    /**
     * @var string
     *
     * @Column(name="ususisoper", type="string", length=60, nullable=true)
     */
    private $ususisoper;

    /**
     * Get numeve
     *
     * @return integer
     */
    public function getNumeve()
    {
        return $this->numeve;
    }

    /**
     * Set codemp
     *
     * @param string $codemp
     *
     * @return SssRegistroEventos
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
     * @return SssRegistroEventos
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
     * Set codsis
     *
     * @param string $codsis
     *
     * @return SssRegistroEventos
     */
    public function setCodsis($codsis)
    {
        $this->codsis = $codsis;

        return $this;
    }

    /**
     * Get codsis
     *
     * @return string
     */
    public function getCodsis()
    {
        return $this->codsis;
    }

    /**
     * Set evento
     *
     * @param string $evento
     *
     * @return SssRegistroEventos
     */
    public function setEvento($evento)
    {
        $this->evento = $evento;

        return $this;
    }

    /**
     * Get evento
     *
     * @return string
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     * Set nomven
     *
     * @param string $nomven
     *
     * @return SssRegistroEventos
     */
    public function setNomven($nomven)
    {
        $this->nomven = $nomven;

        return $this;
    }

    /**
     * Get nomven
     *
     * @return string
     */
    public function getNomven()
    {
        return $this->nomven;
    }

    /**
     * Set codintper
     *
     * @param string $codintper
     *
     * @return SssRegistroEventos
     */
    public function setCodintper($codintper)
    {
        $this->codintper = $codintper;

        return $this;
    }

    /**
     * Get codintper
     *
     * @return string
     */
    public function getCodintper()
    {
        return $this->codintper;
    }

    /**
     * Set fecevetra
     *
     * @param \DateTime $fecevetra
     *
     * @return SssRegistroEventos
     */
    public function setFecevetra($fecevetra)
    {
        $this->fecevetra = $fecevetra;

        return $this;
    }

    /**
     * Get fecevetra
     *
     * @return \DateTime
     */
    public function getFecevetra()
    {
        return $this->fecevetra;
    }

    /**
     * Set equevetra
     *
     * @param string $equevetra
     *
     * @return SssRegistroEventos
     */
    public function setEquevetra($equevetra)
    {
        $this->equevetra = $equevetra;

        return $this;
    }

    /**
     * Get equevetra
     *
     * @return string
     */
    public function getEquevetra()
    {
        return $this->equevetra;
    }

    /**
     * Set desevetra
     *
     * @param string $desevetra
     *
     * @return SssRegistroEventos
     */
    public function setDesevetra($desevetra)
    {
        $this->desevetra = $desevetra;

        return $this;
    }

    /**
     * Get desevetra
     *
     * @return string
     */
    public function getDesevetra()
    {
        return $this->desevetra;
    }

    /**
     * Set ususisoper
     *
     * @param string $ususisoper
     *
     * @return SssRegistroEventos
     */
    public function setUsusisoper($ususisoper)
    {
        $this->ususisoper = $ususisoper;

        return $this;
    }

    /**
     * Get ususisoper
     *
     * @return string
     */
    public function getUsusisoper()
    {
        return $this->ususisoper;
    }
}
