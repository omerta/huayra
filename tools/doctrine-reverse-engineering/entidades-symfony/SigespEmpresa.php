<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SigespEmpresa
 *
 * @ORM\Table(name="sigesp_empresa")
 * @ORM\Entity
 */
class SigespEmpresa
{
    /**
     * @var string
     *
     * @ORM\Column(name="codemp", type="string", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sigesp_empresa_codemp_seq", allocationSize=1, initialValue=1)
     */
    private $codemp;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=100, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="sigemp", type="string", length=50, nullable=true)
     */
    private $sigemp;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=254, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telemp", type="string", length=20, nullable=true)
     */
    private $telemp;

    /**
     * @var string
     *
     * @ORM\Column(name="faxemp", type="string", length=18, nullable=true)
     */
    private $faxemp;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=100, nullable=true)
     */
    private $website;

    /**
     * @var integer
     *
     * @ORM\Column(name="m01", type="smallint", nullable=false)
     */
    private $m01;

    /**
     * @var integer
     *
     * @ORM\Column(name="m02", type="smallint", nullable=false)
     */
    private $m02;

    /**
     * @var integer
     *
     * @ORM\Column(name="m03", type="smallint", nullable=false)
     */
    private $m03;

    /**
     * @var integer
     *
     * @ORM\Column(name="m04", type="smallint", nullable=false)
     */
    private $m04;

    /**
     * @var integer
     *
     * @ORM\Column(name="m05", type="smallint", nullable=false)
     */
    private $m05;

    /**
     * @var integer
     *
     * @ORM\Column(name="m06", type="smallint", nullable=false)
     */
    private $m06;

    /**
     * @var integer
     *
     * @ORM\Column(name="m07", type="smallint", nullable=false)
     */
    private $m07;

    /**
     * @var integer
     *
     * @ORM\Column(name="m08", type="smallint", nullable=false)
     */
    private $m08;

    /**
     * @var integer
     *
     * @ORM\Column(name="m09", type="smallint", nullable=false)
     */
    private $m09;

    /**
     * @var integer
     *
     * @ORM\Column(name="m10", type="smallint", nullable=false)
     */
    private $m10;

    /**
     * @var integer
     *
     * @ORM\Column(name="m11", type="smallint", nullable=false)
     */
    private $m11;

    /**
     * @var integer
     *
     * @ORM\Column(name="m12", type="smallint", nullable=false)
     */
    private $m12;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="periodo", type="date", nullable=false)
     */
    private $periodo;

    /**
     * @var integer
     *
     * @ORM\Column(name="vali_nivel", type="smallint", nullable=false)
     */
    private $valiNivel;

    /**
     * @var integer
     *
     * @ORM\Column(name="esttipcont", type="smallint", nullable=false)
     */
    private $esttipcont;

    /**
     * @var string
     *
     * @ORM\Column(name="formpre", type="string", length=30, nullable=false)
     */
    private $formpre;

    /**
     * @var string
     *
     * @ORM\Column(name="formcont", type="string", length=30, nullable=false)
     */
    private $formcont;

    /**
     * @var string
     *
     * @ORM\Column(name="formplan", type="string", length=30, nullable=false)
     */
    private $formplan;

    /**
     * @var string
     *
     * @ORM\Column(name="formspi", type="string", length=30, nullable=false)
     */
    private $formspi;

    /**
     * @var string
     *
     * @ORM\Column(name="activo", type="string", length=3, nullable=false)
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="pasivo", type="string", length=3, nullable=false)
     */
    private $pasivo;

    /**
     * @var string
     *
     * @ORM\Column(name="ingreso", type="string", length=3, nullable=false)
     */
    private $ingreso;

    /**
     * @var string
     *
     * @ORM\Column(name="gasto", type="string", length=3, nullable=false)
     */
    private $gasto;

    /**
     * @var string
     *
     * @ORM\Column(name="resultado", type="string", length=3, nullable=false)
     */
    private $resultado;

    /**
     * @var string
     *
     * @ORM\Column(name="capital", type="string", length=3, nullable=false)
     */
    private $capital;

    /**
     * @var string
     *
     * @ORM\Column(name="c_resultad", type="string", length=25, nullable=false)
     */
    private $cResultad;

    /**
     * @var string
     *
     * @ORM\Column(name="c_resultan", type="string", length=25, nullable=false)
     */
    private $cResultan;

    /**
     * @var string
     *
     * @ORM\Column(name="orden_d", type="string", length=3, nullable=false)
     */
    private $ordenD;

    /**
     * @var string
     *
     * @ORM\Column(name="orden_h", type="string", length=3, nullable=false)
     */
    private $ordenH;

    /**
     * @var string
     *
     * @ORM\Column(name="soc_gastos", type="string", length=100, nullable=true)
     */
    private $socGastos;

    /**
     * @var string
     *
     * @ORM\Column(name="soc_servic", type="string", length=100, nullable=true)
     */
    private $socServic;

    /**
     * @var string
     *
     * @ORM\Column(name="gerente", type="string", length=50, nullable=true)
     */
    private $gerente;

    /**
     * @var string
     *
     * @ORM\Column(name="jefe_compr", type="string", length=50, nullable=true)
     */
    private $jefeCompr;

    /**
     * @var string
     *
     * @ORM\Column(name="activo_h", type="string", length=3, nullable=true)
     */
    private $activoH;

    /**
     * @var string
     *
     * @ORM\Column(name="pasivo_h", type="string", length=3, nullable=true)
     */
    private $pasivoH;

    /**
     * @var string
     *
     * @ORM\Column(name="resultado_h", type="string", length=3, nullable=true)
     */
    private $resultadoH;

    /**
     * @var string
     *
     * @ORM\Column(name="ingreso_f", type="string", length=3, nullable=true)
     */
    private $ingresoF;

    /**
     * @var string
     *
     * @ORM\Column(name="gasto_f", type="string", length=3, nullable=true)
     */
    private $gastoF;

    /**
     * @var string
     *
     * @ORM\Column(name="ingreso_p", type="string", length=3, nullable=true)
     */
    private $ingresoP;

    /**
     * @var string
     *
     * @ORM\Column(name="gasto_p", type="string", length=3, nullable=true)
     */
    private $gastoP;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=500, nullable=true)
     */
    private $logo;

    /**
     * @var integer
     *
     * @ORM\Column(name="numniv", type="integer", nullable=true)
     */
    private $numniv;

    /**
     * @var string
     *
     * @ORM\Column(name="nomestpro1", type="string", length=40, nullable=true)
     */
    private $nomestpro1;

    /**
     * @var string
     *
     * @ORM\Column(name="nomestpro2", type="string", length=40, nullable=true)
     */
    private $nomestpro2;

    /**
     * @var string
     *
     * @ORM\Column(name="nomestpro3", type="string", length=40, nullable=true)
     */
    private $nomestpro3;

    /**
     * @var string
     *
     * @ORM\Column(name="nomestpro4", type="string", length=40, nullable=true)
     */
    private $nomestpro4;

    /**
     * @var string
     *
     * @ORM\Column(name="nomestpro5", type="string", length=40, nullable=true)
     */
    private $nomestpro5;

    /**
     * @var integer
     *
     * @ORM\Column(name="estvaltra", type="smallint", nullable=true)
     */
    private $estvaltra;

    /**
     * @var string
     *
     * @ORM\Column(name="rifemp", type="string", length=15, nullable=true)
     */
    private $rifemp;

    /**
     * @var string
     *
     * @ORM\Column(name="nitemp", type="string", length=15, nullable=true)
     */
    private $nitemp;

    /**
     * @var string
     *
     * @ORM\Column(name="estemp", type="string", length=50, nullable=true)
     */
    private $estemp;

    /**
     * @var string
     *
     * @ORM\Column(name="ciuemp", type="string", length=50, nullable=true)
     */
    private $ciuemp;

    /**
     * @var string
     *
     * @ORM\Column(name="zonpos", type="string", length=5, nullable=true)
     */
    private $zonpos;

    /**
     * @var integer
     *
     * @ORM\Column(name="estmodape", type="smallint", nullable=true)
     */
    private $estmodape;

    /**
     * @var integer
     *
     * @ORM\Column(name="estdesiva", type="smallint", nullable=true)
     */
    private $estdesiva;

    /**
     * @var integer
     *
     * @ORM\Column(name="estprecom", type="smallint", nullable=true)
     */
    private $estprecom = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estmodsepsoc", type="smallint", nullable=true)
     */
    private $estmodsepsoc;

    /**
     * @var string
     *
     * @ORM\Column(name="codorgsig", type="string", length=5, nullable=true)
     */
    private $codorgsig = ' ';

    /**
     * @var integer
     *
     * @ORM\Column(name="socbieser", type="smallint", nullable=true)
     */
    private $socbieser = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="estmodest", type="smallint", nullable=true)
     */
    private $estmodest = '1';

    /**
     * @var float
     *
     * @ORM\Column(name="salinipro", type="float", precision=10, scale=0, nullable=true)
     */
    private $salinipro;

    /**
     * @var float
     *
     * @ORM\Column(name="salinieje", type="float", precision=10, scale=0, nullable=true)
     */
    private $salinieje;

    /**
     * @var string
     *
     * @ORM\Column(name="numordcom", type="string", length=15, nullable=false)
     */
    private $numordcom;

    /**
     * @var string
     *
     * @ORM\Column(name="numordser", type="string", length=15, nullable=false)
     */
    private $numordser;

    /**
     * @var string
     *
     * @ORM\Column(name="numsolpag", type="string", length=15, nullable=false)
     */
    private $numsolpag;

    /**
     * @var string
     *
     * @ORM\Column(name="nomorgads", type="string", length=254, nullable=true)
     */
    private $nomorgads;

    /**
     * @var string
     *
     * @ORM\Column(name="numlicemp", type="string", length=25, nullable=true)
     */
    private $numlicemp;

    /**
     * @var string
     *
     * @ORM\Column(name="modageret", type="string", length=1, nullable=true)
     */
    private $modageret;

    /**
     * @var string
     *
     * @ORM\Column(name="nomres", type="string", length=20, nullable=true)
     */
    private $nomres;

    /**
     * @var string
     *
     * @ORM\Column(name="concomiva", type="string", length=6, nullable=true)
     */
    private $concomiva;

    /**
     * @var string
     *
     * @ORM\Column(name="cedben", type="string", length=10, nullable=true)
     */
    private $cedben;

    /**
     * @var string
     *
     * @ORM\Column(name="nomben", type="string", length=100, nullable=true)
     */
    private $nomben;

    /**
     * @var string
     *
     * @ORM\Column(name="scctaben", type="string", length=25, nullable=true)
     */
    private $scctaben;

    /**
     * @var integer
     *
     * @ORM\Column(name="estmodiva", type="smallint", nullable=true)
     */
    private $estmodiva;

    /**
     * @var string
     *
     * @ORM\Column(name="activo_t", type="string", length=3, nullable=true)
     */
    private $activoT;

    /**
     * @var string
     *
     * @ORM\Column(name="pasivo_t", type="string", length=3, nullable=true)
     */
    private $pasivoT;

    /**
     * @var string
     *
     * @ORM\Column(name="resultado_t", type="string", length=3, nullable=true)
     */
    private $resultadoT;

    /**
     * @var string
     *
     * @ORM\Column(name="c_financiera", type="string", length=25, nullable=true)
     */
    private $cFinanciera;

    /**
     * @var string
     *
     * @ORM\Column(name="c_fiscal", type="string", length=25, nullable=true)
     */
    private $cFiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="diacadche", type="string", length=3, nullable=true)
     */
    private $diacadche;

    /**
     * @var string
     *
     * @ORM\Column(name="codasiona", type="string", length=10, nullable=true)
     */
    private $codasiona;

    /**
     * @var integer
     *
     * @ORM\Column(name="loncodestpro1", type="integer", nullable=true)
     */
    private $loncodestpro1;

    /**
     * @var integer
     *
     * @ORM\Column(name="loncodestpro2", type="integer", nullable=true)
     */
    private $loncodestpro2;

    /**
     * @var integer
     *
     * @ORM\Column(name="loncodestpro3", type="integer", nullable=true)
     */
    private $loncodestpro3;

    /**
     * @var integer
     *
     * @ORM\Column(name="loncodestpro4", type="integer", nullable=true)
     */
    private $loncodestpro4;

    /**
     * @var integer
     *
     * @ORM\Column(name="loncodestpro5", type="integer", nullable=true)
     */
    private $loncodestpro5;

    /**
     * @var string
     *
     * @ORM\Column(name="candeccon", type="string", length=3, nullable=true)
     */
    private $candeccon;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipconmon", type="smallint", nullable=true)
     */
    private $tipconmon;

    /**
     * @var integer
     *
     * @ORM\Column(name="redconmon", type="smallint", nullable=true)
     */
    private $redconmon;

    /**
     * @var string
     *
     * @ORM\Column(name="conrecdoc", type="string", length=1, nullable=true)
     */
    private $conrecdoc = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="estvaldis", type="string", length=1, nullable=true)
     */
    private $estvaldis = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="nroivss", type="string", length=15, nullable=true)
     */
    private $nroivss;

    /**
     * @var string
     *
     * @ORM\Column(name="nomrep", type="string", length=60, nullable=true)
     */
    private $nomrep;

    /**
     * @var string
     *
     * @ORM\Column(name="cedrep", type="string", length=10, nullable=true)
     */
    private $cedrep;

    /**
     * @var string
     *
     * @ORM\Column(name="telfrep", type="string", length=15, nullable=true)
     */
    private $telfrep;

    /**
     * @var string
     *
     * @ORM\Column(name="cargorep", type="string", length=80, nullable=true)
     */
    private $cargorep;

    /**
     * @var string
     *
     * @ORM\Column(name="estretiva", type="string", length=1, nullable=true)
     */
    private $estretiva = 'C';

    /**
     * @var integer
     *
     * @ORM\Column(name="clactacon", type="smallint", nullable=true)
     */
    private $clactacon;

    /**
     * @var integer
     *
     * @ORM\Column(name="estempcon", type="smallint", nullable=true)
     */
    private $estempcon = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="codaltemp", type="string", length=4, nullable=true)
     */
    private $codaltemp;

    /**
     * @var string
     *
     * @ORM\Column(name="basdatcon", type="string", length=100, nullable=true)
     */
    private $basdatcon;

    /**
     * @var integer
     *
     * @ORM\Column(name="estcamemp", type="smallint", nullable=true)
     */
    private $estcamemp = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estparsindis", type="smallint", nullable=true)
     */
    private $estparsindis = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estciespg", type="smallint", nullable=true)
     */
    private $estciespg = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estciespi", type="smallint", nullable=true)
     */
    private $estciespi = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="basdatcmp", type="string", length=150, nullable=true)
     */
    private $basdatcmp;

    /**
     * @var string
     *
     * @ORM\Column(name="confinstr", type="string", length=1, nullable=true)
     */
    private $confinstr = 'N';

    /**
     * @var string
     *
     * @ORM\Column(name="estintcred", type="string", length=1, nullable=true)
     */
    private $estintcred = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estciescg", type="smallint", nullable=true)
     */
    private $estciescg = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estvalspg", type="smallint", nullable=true)
     */
    private $estvalspg = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ctaspgrec", type="string", length=254, nullable=true)
     */
    private $ctaspgrec;

    /**
     * @var string
     *
     * @ORM\Column(name="ctaspgced", type="string", length=254, nullable=true)
     */
    private $ctaspgced;

    /**
     * @var string
     *
     * @ORM\Column(name="estmodpartsep", type="string", length=1, nullable=true)
     */
    private $estmodpartsep = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="estmodpartsoc", type="string", length=1, nullable=true)
     */
    private $estmodpartsoc = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="estmanant", type="string", length=1, nullable=false)
     */
    private $estmanant = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estpreing", type="smallint", nullable=true)
     */
    private $estpreing = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="concommun", type="string", length=6, nullable=true)
     */
    private $concommun;

    /**
     * @var string
     *
     * @ORM\Column(name="confiva", type="string", length=1, nullable=true)
     */
    private $confiva = 'P';

    /**
     * @var integer
     *
     * @ORM\Column(name="casconmov", type="smallint", nullable=true)
     */
    private $casconmov = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="estmodprog", type="string", length=1, nullable=false)
     */
    private $estmodprog = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="confi_ch", type="string", length=1, nullable=true)
     */
    private $confiCh;

    /**
     * @var string
     *
     * @ORM\Column(name="dirvirtual", type="string", length=30, nullable=false)
     */
    private $dirvirtual = 'sigesp_ipsfa';

    /**
     * @var string
     *
     * @ORM\Column(name="ctaresact", type="string", length=25, nullable=false)
     */
    private $ctaresact = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ctaresant", type="string", length=25, nullable=false)
     */
    private $ctaresant = '';

    /**
     * @var string
     *
     * @ORM\Column(name="estvaldisfin", type="string", length=1, nullable=false)
     */
    private $estvaldisfin = 'N';

    /**
     * @var string
     *
     * @ORM\Column(name="dedconproben", type="string", length=1, nullable=false)
     */
    private $dedconproben = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="estaprsep", type="string", length=1, nullable=true)
     */
    private $estaprsep = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="sujpasesp", type="string", length=1, nullable=true)
     */
    private $sujpasesp = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="bloanu", type="string", length=1, nullable=true)
     */
    private $bloanu = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="estretmil", type="string", length=1, nullable=true)
     */
    private $estretmil = 'C';

    /**
     * @var string
     *
     * @ORM\Column(name="concommil", type="string", length=6, nullable=true)
     */
    private $concommil;

    /**
     * @var integer
     *
     * @ORM\Column(name="contintmovban", type="smallint", nullable=true)
     */
    private $contintmovban = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="valinimovban", type="integer", nullable=true)
     */
    private $valinimovban = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="estintban", type="string", length=1, nullable=true)
     */
    private $estintban = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="cueproacu", type="string", length=3, nullable=true)
     */
    private $cueproacu;

    /**
     * @var string
     *
     * @ORM\Column(name="cuedepamo", type="string", length=3, nullable=true)
     */
    private $cuedepamo;

    /**
     * @var string
     *
     * @ORM\Column(name="valclacon", type="string", length=1, nullable=true)
     */
    private $valclacon = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="valcomrd", type="string", length=1, nullable=true)
     */
    private $valcomrd = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ctaejeprecie", type="string", length=25, nullable=true)
     */
    private $ctaejeprecie;

    /**
     * @var string
     *
     * @ORM\Column(name="estaprsoc", type="string", length=1, nullable=true)
     */
    private $estaprsoc = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="estaprcxp", type="string", length=1, nullable=true)
     */
    private $estaprcxp = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="scforden_h", type="string", length=3, nullable=true)
     */
    private $scfordenH;

    /**
     * @var string
     *
     * @ORM\Column(name="scforden_d", type="string", length=3, nullable=true)
     */
    private $scfordenD;

    /**
     * @var string
     *
     * @ORM\Column(name="repcajchi", type="string", length=25, nullable=true)
     */
    private $repcajchi;

    /**
     * @var string
     *
     * @ORM\Column(name="estafenc", type="string", length=1, nullable=true)
     */
    private $estafenc = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="blocon", type="string", length=1, nullable=false)
     */
    private $blocon = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="intblocon", type="integer", nullable=false)
     */
    private $intblocon = '3';

    /**
     * @var string
     *
     * @ORM\Column(name="capiva", type="string", length=1, nullable=true)
     */
    private $capiva = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="parcapiva", type="string", length=100, nullable=true)
     */
    private $parcapiva;

    /**
     * @var string
     *
     * @ORM\Column(name="estciesem", type="string", length=1, nullable=false)
     */
    private $estciesem = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ciesem1", type="string", length=1, nullable=false)
     */
    private $ciesem1 = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ciesem2", type="string", length=1, nullable=false)
     */
    private $ciesem2 = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="estceniva", type="string", length=1, nullable=false)
     */
    private $estceniva = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="codestprocen1", type="string", length=25, nullable=true)
     */
    private $codestprocen1;

    /**
     * @var string
     *
     * @ORM\Column(name="codestprocen2", type="string", length=25, nullable=true)
     */
    private $codestprocen2;

    /**
     * @var string
     *
     * @ORM\Column(name="codestprocen3", type="string", length=25, nullable=true)
     */
    private $codestprocen3;

    /**
     * @var string
     *
     * @ORM\Column(name="codestprocen4", type="string", length=25, nullable=true)
     */
    private $codestprocen4;

    /**
     * @var string
     *
     * @ORM\Column(name="codestprocen5", type="string", length=25, nullable=true)
     */
    private $codestprocen5;

    /**
     * @var string
     *
     * @ORM\Column(name="esclacen", type="string", length=25, nullable=true)
     */
    private $esclacen;

    /**
     * @var string
     *
     * @ORM\Column(name="estspgdecimal", type="string", length=1, nullable=false)
     */
    private $estspgdecimal = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="nrodiascmp", type="integer", nullable=true)
     */
    private $nrodiascmp;


}

