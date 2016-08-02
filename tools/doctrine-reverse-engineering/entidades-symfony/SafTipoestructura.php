<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * SafTipoestructura
 *
 * @ORM\Table(name="saf_tipoestructura", indexes={@ORM\Index(name="IDX_241FFE6D5ECE3182", columns={"codemp"})})
 * @ORM\Entity
 */
class SafTipoestructura
{
    /**
     * @var string
     *
     * @ORM\Column(name="codtipest", type="string", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $codtipest;

    /**
     * @var string
     *
     * @ORM\Column(name="dentipest", type="string", length=50, nullable=true)
     */
    private $dentipest;

    /**
     * @var \SigespEmpresa
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SigespEmpresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codemp", referencedColumnName="codemp")
     * })
     */
    private $codemp;
}
