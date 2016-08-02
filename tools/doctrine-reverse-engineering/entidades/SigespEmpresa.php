<?php
/**
 * SigespEmpresa
 *
 * @Table(name="sigesp_empresa")
 * @Entity
 */
class SigespEmpresa
{
    /**
     * @var string
     *
     * @Column(name="codemp", type="string", length=4, nullable=false)
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="sigesp_empresa_codemp_seq", allocationSize=1, initialValue=1)
     */
    private $codemp;

    /**
     * @var string
     *
     * @Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @Column(name="titulo", type="string", length=100, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @Column(name="sigemp", type="string", length=50, nullable=true)
     */
    private $sigemp;

    /**
     * @var string
     *
     * @Column(name="direccion", type="string", length=254, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @Column(name="telemp", type="string", length=20, nullable=true)
     */
    private $telemp;

    /**
     * @var string
     *
     * @Column(name="faxemp", type="string", length=18, nullable=true)
     */
    private $faxemp;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="website", type="string", length=100, nullable=true)
     */
    private $website;

    /**
     * @var integer
     *
     * @Column(name="m01", type="smallint", nullable=false)
     */
    private $m01;

    /**
     * @var integer
     *
     * @Column(name="m02", type="smallint", nullable=false)
     */
    private $m02;

    /**
     * @var integer
     *
     * @Column(name="m03", type="smallint", nullable=false)
     */
    private $m03;

    /**
     * @var integer
     *
     * @Column(name="m04", type="smallint", nullable=false)
     */
    private $m04;

    /**
     * @var integer
     *
     * @Column(name="m05", type="smallint", nullable=false)
     */
    private $m05;

    /**
     * @var integer
     *
     * @Column(name="m06", type="smallint", nullable=false)
     */
    private $m06;

    /**
     * @var integer
     *
     * @Column(name="m07", type="smallint", nullable=false)
     */
    private $m07;

    /**
     * @var integer
     *
     * @Column(name="m08", type="smallint", nullable=false)
     */
    private $m08;

    /**
     * @var integer
     *
     * @Column(name="m09", type="smallint", nullable=false)
     */
    private $m09;

    /**
     * @var integer
     *
     * @Column(name="m10", type="smallint", nullable=false)
     */
    private $m10;

    /**
     * @var integer
     *
     * @Column(name="m11", type="smallint", nullable=false)
     */
    private $m11;

    /**
     * @var integer
     *
     * @Column(name="m12", type="smallint", nullable=false)
     */
    private $m12;

    /**
     * @var \DateTime
     *
     * @Column(name="periodo", type="date", nullable=false)
     */
    private $periodo;

    /**
     * @var integer
     *
     * @Column(name="vali_nivel", type="smallint", nullable=false)
     */
    private $valiNivel;

    /**
     * @var integer
     *
     * @Column(name="esttipcont", type="smallint", nullable=false)
     */
    private $esttipcont;

    /**
     * @var string
     *
     * @Column(name="formpre", type="string", length=30, nullable=false)
     */
    private $formpre;

    /**
     * @var string
     *
     * @Column(name="formcont", type="string", length=30, nullable=false)
     */
    private $formcont;

    /**
     * @var string
     *
     * @Column(name="formplan", type="string", length=30, nullable=false)
     */
    private $formplan;

    /**
     * @var string
     *
     * @Column(name="formspi", type="string", length=30, nullable=false)
     */
    private $formspi;

    /**
     * @var string
     *
     * @Column(name="activo", type="string", length=3, nullable=false)
     */
    private $activo;

    /**
     * @var string
     *
     * @Column(name="pasivo", type="string", length=3, nullable=false)
     */
    private $pasivo;

    /**
     * @var string
     *
     * @Column(name="ingreso", type="string", length=3, nullable=false)
     */
    private $ingreso;

    /**
     * @var string
     *
     * @Column(name="gasto", type="string", length=3, nullable=false)
     */
    private $gasto;

    /**
     * @var string
     *
     * @Column(name="resultado", type="string", length=3, nullable=false)
     */
    private $resultado;

    /**
     * @var string
     *
     * @Column(name="capital", type="string", length=3, nullable=false)
     */
    private $capital;

    /**
     * @var string
     *
     * @Column(name="c_resultad", type="string", length=25, nullable=false)
     */
    private $cResultad;

    /**
     * @var string
     *
     * @Column(name="c_resultan", type="string", length=25, nullable=false)
     */
    private $cResultan;

    /**
     * @var string
     *
     * @Column(name="orden_d", type="string", length=3, nullable=false)
     */
    private $ordenD;

    /**
     * @var string
     *
     * @Column(name="orden_h", type="string", length=3, nullable=false)
     */
    private $ordenH;

    /**
     * @var string
     *
     * @Column(name="soc_gastos", type="string", length=100, nullable=true)
     */
    private $socGastos;

    /**
     * @var string
     *
     * @Column(name="soc_servic", type="string", length=100, nullable=true)
     */
    private $socServic;

    /**
     * @var string
     *
     * @Column(name="gerente", type="string", length=50, nullable=true)
     */
    private $gerente;

    /**
     * @var string
     *
     * @Column(name="jefe_compr", type="string", length=50, nullable=true)
     */
    private $jefeCompr;

    /**
     * @var string
     *
     * @Column(name="activo_h", type="string", length=3, nullable=true)
     */
    private $activoH;

    /**
     * @var string
     *
     * @Column(name="pasivo_h", type="string", length=3, nullable=true)
     */
    private $pasivoH;

    /**
     * @var string
     *
     * @Column(name="resultado_h", type="string", length=3, nullable=true)
     */
    private $resultadoH;

    /**
     * @var string
     *
     * @Column(name="ingreso_f", type="string", length=3, nullable=true)
     */
    private $ingresoF;

    /**
     * @var string
     *
     * @Column(name="gasto_f", type="string", length=3, nullable=true)
     */
    private $gastoF;

    /**
     * @var string
     *
     * @Column(name="ingreso_p", type="string", length=3, nullable=true)
     */
    private $ingresoP;

    /**
     * @var string
     *
     * @Column(name="gasto_p", type="string", length=3, nullable=true)
     */
    private $gastoP;

    /**
     * @var string
     *
     * @Column(name="logo", type="string", length=500, nullable=true)
     */
    private $logo;

    /**
     * @var integer
     *
     * @Column(name="numniv", type="integer", nullable=true)
     */
    private $numniv;

    /**
     * @var string
     *
     * @Column(name="nomestpro1", type="string", length=40, nullable=true)
     */
    private $nomestpro1;

    /**
     * @var string
     *
     * @Column(name="nomestpro2", type="string", length=40, nullable=true)
     */
    private $nomestpro2;

    /**
     * @var string
     *
     * @Column(name="nomestpro3", type="string", length=40, nullable=true)
     */
    private $nomestpro3;

    /**
     * @var string
     *
     * @Column(name="nomestpro4", type="string", length=40, nullable=true)
     */
    private $nomestpro4;

    /**
     * @var string
     *
     * @Column(name="nomestpro5", type="string", length=40, nullable=true)
     */
    private $nomestpro5;

    /**
     * @var integer
     *
     * @Column(name="estvaltra", type="smallint", nullable=true)
     */
    private $estvaltra;

    /**
     * @var string
     *
     * @Column(name="rifemp", type="string", length=15, nullable=true)
     */
    private $rifemp;

    /**
     * @var string
     *
     * @Column(name="nitemp", type="string", length=15, nullable=true)
     */
    private $nitemp;

    /**
     * @var string
     *
     * @Column(name="estemp", type="string", length=50, nullable=true)
     */
    private $estemp;

    /**
     * @var string
     *
     * @Column(name="ciuemp", type="string", length=50, nullable=true)
     */
    private $ciuemp;

    /**
     * @var string
     *
     * @Column(name="zonpos", type="string", length=5, nullable=true)
     */
    private $zonpos;

    /**
     * @var integer
     *
     * @Column(name="estmodape", type="smallint", nullable=true)
     */
    private $estmodape;

    /**
     * @var integer
     *
     * @Column(name="estdesiva", type="smallint", nullable=true)
     */
    private $estdesiva;

    /**
     * @var integer
     *
     * @Column(name="estprecom", type="smallint", nullable=true)
     */
    private $estprecom = '0';

    /**
     * @var integer
     *
     * @Column(name="estmodsepsoc", type="smallint", nullable=true)
     */
    private $estmodsepsoc;

    /**
     * @var string
     *
     * @Column(name="codorgsig", type="string", length=5, nullable=true)
     */
    private $codorgsig = ' ';

    /**
     * @var integer
     *
     * @Column(name="socbieser", type="smallint", nullable=true)
     */
    private $socbieser = '1';

    /**
     * @var integer
     *
     * @Column(name="estmodest", type="smallint", nullable=true)
     */
    private $estmodest = '1';

    /**
     * @var float
     *
     * @Column(name="salinipro", type="float", precision=10, scale=0, nullable=true)
     */
    private $salinipro;

    /**
     * @var float
     *
     * @Column(name="salinieje", type="float", precision=10, scale=0, nullable=true)
     */
    private $salinieje;

    /**
     * @var string
     *
     * @Column(name="numordcom", type="string", length=15, nullable=false)
     */
    private $numordcom;

    /**
     * @var string
     *
     * @Column(name="numordser", type="string", length=15, nullable=false)
     */
    private $numordser;

    /**
     * @var string
     *
     * @Column(name="numsolpag", type="string", length=15, nullable=false)
     */
    private $numsolpag;

    /**
     * @var string
     *
     * @Column(name="nomorgads", type="string", length=254, nullable=true)
     */
    private $nomorgads;

    /**
     * @var string
     *
     * @Column(name="numlicemp", type="string", length=25, nullable=true)
     */
    private $numlicemp;

    /**
     * @var string
     *
     * @Column(name="modageret", type="string", length=1, nullable=true)
     */
    private $modageret;

    /**
     * @var string
     *
     * @Column(name="nomres", type="string", length=20, nullable=true)
     */
    private $nomres;

    /**
     * @var string
     *
     * @Column(name="concomiva", type="string", length=6, nullable=true)
     */
    private $concomiva;

    /**
     * @var string
     *
     * @Column(name="cedben", type="string", length=10, nullable=true)
     */
    private $cedben;

    /**
     * @var string
     *
     * @Column(name="nomben", type="string", length=100, nullable=true)
     */
    private $nomben;

    /**
     * @var string
     *
     * @Column(name="scctaben", type="string", length=25, nullable=true)
     */
    private $scctaben;

    /**
     * @var integer
     *
     * @Column(name="estmodiva", type="smallint", nullable=true)
     */
    private $estmodiva;

    /**
     * @var string
     *
     * @Column(name="activo_t", type="string", length=3, nullable=true)
     */
    private $activoT;

    /**
     * @var string
     *
     * @Column(name="pasivo_t", type="string", length=3, nullable=true)
     */
    private $pasivoT;

    /**
     * @var string
     *
     * @Column(name="resultado_t", type="string", length=3, nullable=true)
     */
    private $resultadoT;

    /**
     * @var string
     *
     * @Column(name="c_financiera", type="string", length=25, nullable=true)
     */
    private $cFinanciera;

    /**
     * @var string
     *
     * @Column(name="c_fiscal", type="string", length=25, nullable=true)
     */
    private $cFiscal;

    /**
     * @var string
     *
     * @Column(name="diacadche", type="string", length=3, nullable=true)
     */
    private $diacadche;

    /**
     * @var string
     *
     * @Column(name="codasiona", type="string", length=10, nullable=true)
     */
    private $codasiona;

    /**
     * @var integer
     *
     * @Column(name="loncodestpro1", type="integer", nullable=true)
     */
    private $loncodestpro1;

    /**
     * @var integer
     *
     * @Column(name="loncodestpro2", type="integer", nullable=true)
     */
    private $loncodestpro2;

    /**
     * @var integer
     *
     * @Column(name="loncodestpro3", type="integer", nullable=true)
     */
    private $loncodestpro3;

    /**
     * @var integer
     *
     * @Column(name="loncodestpro4", type="integer", nullable=true)
     */
    private $loncodestpro4;

    /**
     * @var integer
     *
     * @Column(name="loncodestpro5", type="integer", nullable=true)
     */
    private $loncodestpro5;

    /**
     * @var string
     *
     * @Column(name="candeccon", type="string", length=3, nullable=true)
     */
    private $candeccon;

    /**
     * @var integer
     *
     * @Column(name="tipconmon", type="smallint", nullable=true)
     */
    private $tipconmon;

    /**
     * @var integer
     *
     * @Column(name="redconmon", type="smallint", nullable=true)
     */
    private $redconmon;

    /**
     * @var string
     *
     * @Column(name="conrecdoc", type="string", length=1, nullable=true)
     */
    private $conrecdoc = '0';

    /**
     * @var string
     *
     * @Column(name="estvaldis", type="string", length=1, nullable=true)
     */
    private $estvaldis = '1';

    /**
     * @var string
     *
     * @Column(name="nroivss", type="string", length=15, nullable=true)
     */
    private $nroivss;

    /**
     * @var string
     *
     * @Column(name="nomrep", type="string", length=60, nullable=true)
     */
    private $nomrep;

    /**
     * @var string
     *
     * @Column(name="cedrep", type="string", length=10, nullable=true)
     */
    private $cedrep;

    /**
     * @var string
     *
     * @Column(name="telfrep", type="string", length=15, nullable=true)
     */
    private $telfrep;

    /**
     * @var string
     *
     * @Column(name="cargorep", type="string", length=80, nullable=true)
     */
    private $cargorep;

    /**
     * @var string
     *
     * @Column(name="estretiva", type="string", length=1, nullable=true)
     */
    private $estretiva = 'C';

    /**
     * @var integer
     *
     * @Column(name="clactacon", type="smallint", nullable=true)
     */
    private $clactacon;

    /**
     * @var integer
     *
     * @Column(name="estempcon", type="smallint", nullable=true)
     */
    private $estempcon = '0';

    /**
     * @var string
     *
     * @Column(name="codaltemp", type="string", length=4, nullable=true)
     */
    private $codaltemp;

    /**
     * @var string
     *
     * @Column(name="basdatcon", type="string", length=100, nullable=true)
     */
    private $basdatcon;

    /**
     * @var integer
     *
     * @Column(name="estcamemp", type="smallint", nullable=true)
     */
    private $estcamemp = '0';

    /**
     * @var integer
     *
     * @Column(name="estparsindis", type="smallint", nullable=true)
     */
    private $estparsindis = '0';

    /**
     * @var integer
     *
     * @Column(name="estciespg", type="smallint", nullable=true)
     */
    private $estciespg = '0';

    /**
     * @var integer
     *
     * @Column(name="estciespi", type="smallint", nullable=true)
     */
    private $estciespi = '0';

    /**
     * @var string
     *
     * @Column(name="basdatcmp", type="string", length=150, nullable=true)
     */
    private $basdatcmp;

    /**
     * @var string
     *
     * @Column(name="confinstr", type="string", length=1, nullable=true)
     */
    private $confinstr = 'N';

    /**
     * @var string
     *
     * @Column(name="estintcred", type="string", length=1, nullable=true)
     */
    private $estintcred = '0';

    /**
     * @var integer
     *
     * @Column(name="estciescg", type="smallint", nullable=true)
     */
    private $estciescg = '0';

    /**
     * @var integer
     *
     * @Column(name="estvalspg", type="smallint", nullable=true)
     */
    private $estvalspg = '0';

    /**
     * @var string
     *
     * @Column(name="ctaspgrec", type="string", length=254, nullable=true)
     */
    private $ctaspgrec;

    /**
     * @var string
     *
     * @Column(name="ctaspgced", type="string", length=254, nullable=true)
     */
    private $ctaspgced;

    /**
     * @var string
     *
     * @Column(name="estmodpartsep", type="string", length=1, nullable=true)
     */
    private $estmodpartsep = '0';

    /**
     * @var string
     *
     * @Column(name="estmodpartsoc", type="string", length=1, nullable=true)
     */
    private $estmodpartsoc = '0';

    /**
     * @var string
     *
     * @Column(name="estmanant", type="string", length=1, nullable=false)
     */
    private $estmanant = '0';

    /**
     * @var integer
     *
     * @Column(name="estpreing", type="smallint", nullable=true)
     */
    private $estpreing = '0';

    /**
     * @var string
     *
     * @Column(name="concommun", type="string", length=6, nullable=true)
     */
    private $concommun;

    /**
     * @var string
     *
     * @Column(name="confiva", type="string", length=1, nullable=true)
     */
    private $confiva = 'P';

    /**
     * @var integer
     *
     * @Column(name="casconmov", type="smallint", nullable=true)
     */
    private $casconmov = '0';

    /**
     * @var string
     *
     * @Column(name="estmodprog", type="string", length=1, nullable=false)
     */
    private $estmodprog = '0';

    /**
     * @var string
     *
     * @Column(name="confi_ch", type="string", length=1, nullable=true)
     */
    private $confiCh;

    /**
     * @var string
     *
     * @Column(name="dirvirtual", type="string", length=30, nullable=false)
     */
    private $dirvirtual = 'sigesp_ipsfa';

    /**
     * @var string
     *
     * @Column(name="ctaresact", type="string", length=25, nullable=false)
     */
    private $ctaresact = '';

    /**
     * @var string
     *
     * @Column(name="ctaresant", type="string", length=25, nullable=false)
     */
    private $ctaresant = '';

    /**
     * @var string
     *
     * @Column(name="estvaldisfin", type="string", length=1, nullable=false)
     */
    private $estvaldisfin = 'N';

    /**
     * @var string
     *
     * @Column(name="dedconproben", type="string", length=1, nullable=false)
     */
    private $dedconproben = '0';

    /**
     * @var string
     *
     * @Column(name="estaprsep", type="string", length=1, nullable=true)
     */
    private $estaprsep = '1';

    /**
     * @var string
     *
     * @Column(name="sujpasesp", type="string", length=1, nullable=true)
     */
    private $sujpasesp = '0';

    /**
     * @var string
     *
     * @Column(name="bloanu", type="string", length=1, nullable=true)
     */
    private $bloanu = '1';

    /**
     * @var string
     *
     * @Column(name="estretmil", type="string", length=1, nullable=true)
     */
    private $estretmil = 'C';

    /**
     * @var string
     *
     * @Column(name="concommil", type="string", length=6, nullable=true)
     */
    private $concommil;

    /**
     * @var integer
     *
     * @Column(name="contintmovban", type="smallint", nullable=true)
     */
    private $contintmovban = '0';

    /**
     * @var integer
     *
     * @Column(name="valinimovban", type="integer", nullable=true)
     */
    private $valinimovban = '0';

    /**
     * @var string
     *
     * @Column(name="estintban", type="string", length=1, nullable=true)
     */
    private $estintban = '0';

    /**
     * @var string
     *
     * @Column(name="cueproacu", type="string", length=3, nullable=true)
     */
    private $cueproacu;

    /**
     * @var string
     *
     * @Column(name="cuedepamo", type="string", length=3, nullable=true)
     */
    private $cuedepamo;

    /**
     * @var string
     *
     * @Column(name="valclacon", type="string", length=1, nullable=true)
     */
    private $valclacon = '0';

    /**
     * @var string
     *
     * @Column(name="valcomrd", type="string", length=1, nullable=true)
     */
    private $valcomrd = '0';

    /**
     * @var string
     *
     * @Column(name="ctaejeprecie", type="string", length=25, nullable=true)
     */
    private $ctaejeprecie;

    /**
     * @var string
     *
     * @Column(name="estaprsoc", type="string", length=1, nullable=true)
     */
    private $estaprsoc = '1';

    /**
     * @var string
     *
     * @Column(name="estaprcxp", type="string", length=1, nullable=true)
     */
    private $estaprcxp = '1';

    /**
     * @var string
     *
     * @Column(name="scforden_h", type="string", length=3, nullable=true)
     */
    private $scfordenH;

    /**
     * @var string
     *
     * @Column(name="scforden_d", type="string", length=3, nullable=true)
     */
    private $scfordenD;

    /**
     * @var string
     *
     * @Column(name="repcajchi", type="string", length=25, nullable=true)
     */
    private $repcajchi;

    /**
     * @var string
     *
     * @Column(name="estafenc", type="string", length=1, nullable=true)
     */
    private $estafenc = '0';

    /**
     * @var string
     *
     * @Column(name="blocon", type="string", length=1, nullable=false)
     */
    private $blocon = '1';

    /**
     * @var integer
     *
     * @Column(name="intblocon", type="integer", nullable=false)
     */
    private $intblocon = '3';

    /**
     * @var string
     *
     * @Column(name="capiva", type="string", length=1, nullable=true)
     */
    private $capiva = '0';

    /**
     * @var string
     *
     * @Column(name="parcapiva", type="string", length=100, nullable=true)
     */
    private $parcapiva;

    /**
     * @var string
     *
     * @Column(name="estciesem", type="string", length=1, nullable=false)
     */
    private $estciesem = '0';

    /**
     * @var string
     *
     * @Column(name="ciesem1", type="string", length=1, nullable=false)
     */
    private $ciesem1 = '0';

    /**
     * @var string
     *
     * @Column(name="ciesem2", type="string", length=1, nullable=false)
     */
    private $ciesem2 = '0';

    /**
     * @var string
     *
     * @Column(name="estceniva", type="string", length=1, nullable=false)
     */
    private $estceniva = '0';

    /**
     * @var string
     *
     * @Column(name="codestprocen1", type="string", length=25, nullable=true)
     */
    private $codestprocen1;

    /**
     * @var string
     *
     * @Column(name="codestprocen2", type="string", length=25, nullable=true)
     */
    private $codestprocen2;

    /**
     * @var string
     *
     * @Column(name="codestprocen3", type="string", length=25, nullable=true)
     */
    private $codestprocen3;

    /**
     * @var string
     *
     * @Column(name="codestprocen4", type="string", length=25, nullable=true)
     */
    private $codestprocen4;

    /**
     * @var string
     *
     * @Column(name="codestprocen5", type="string", length=25, nullable=true)
     */
    private $codestprocen5;

    /**
     * @var string
     *
     * @Column(name="esclacen", type="string", length=25, nullable=true)
     */
    private $esclacen;

    /**
     * @var string
     *
     * @Column(name="estspgdecimal", type="string", length=1, nullable=false)
     */
    private $estspgdecimal = '0';

    /**
     * @var integer
     *
     * @Column(name="nrodiascmp", type="integer", nullable=true)
     */
    private $nrodiascmp;
}
