<link href="css/tablas.css" rel="stylesheet" type="text/css">
<style type="text/css">
.innerb {height:10em; overflow:auto; width:635px; background-color:#FFFFFF;}
</style>
<?php
require_once("class_mensajes.php");
class grid_param
{
	var $numrows;
	var $titles;
	var $align;
	var $size;
	var $maxlength;
	var $validaciones;
	var $widthtable;
	var $titletable;
	function grid_param()
    {
    }

	function makegrid($rows,$titulos,$object,$widthtable,$titletable,$name)
	{
		$this->numrows=$rows;
		$this->titles=$titulos;
		$this->widthtable=$widthtable;
		$this->titletable=$titletable;
		$totcols=count($this->titles);
		print "<table width=".$this->widthtable." border=0 cellspacing=1 cellpadding=1 id=".$name." class=fondo-tabla>";
		print "<tr class=titulo-celda >";
		print "<td colspan=".$totcols.">".$this->titletable."</td>";
		print "</tr>";
		print "<tr class=titulo-celdanew>";

		for($i=1;$i<=$totcols;$i++)
		{
			print "<td align=center>".$this->titles[$i]."</td>";
		}
		print "</tr>";

		for($z=1;$z<=$this->numrows;$z++)
		{
			print "<tr class=celdas-blancas>";
			for($y=1;$y<=$totcols;$y++)
			{
				$txt="txt".$this->titles[$y].$z;
				$alineacion=$this->align[$y];
				$tama�o=$this->size[$y];
				$max=$this->maxlength[$y];
				$valida=$this->validaciones[$y];
				print "<td class=celdas-blancas >".$object[$z][$y]."</td>";
			}
		print "</tr>";
	  }
	  print "</table>";
	  print "<br>";
	}

	/**
	 * Genera una tabla
	 *
	 * @param string $rows Número de filas
	 * @param array $titulos Arreglo con los titulos de las columnas
	 * @param array $object Arreglo multidimencional con código html
	 * @param string $widthtable Ancho de la tabla
	 * @param string $titletable Titulo de la tabla
	 * @param string $name Id de la etiqueta label
	 *
	 * @return string
	 */
	 function makegrid2(&$rows,$titulos,&$object,$widthtable,$titletable,$name)
 	{
 		$this->numrows=$rows;
 		$this->titles=$titulos;
 		$this->widthtable=$widthtable;
 		$this->titletable=$titletable;
 		$totcols=count($this->titles);

		$tabla = "<table class=\"table table-hover\" id=".$name." width=".$widthtable.">";
 		$tabla .= "<caption class=titulo-celda>".$this->titletable."</caption>";
		//$tabla .= "<thead>";
		$tabla .= "<tr class=\"titulo-celdanew\">";
 		for($i=1;$i<=$totcols;$i++)
 		{
 			if($i==1)
 			{
 				$tabla .= "<th><input type=checkbox name=checkall id=checkall value=1 size=10 style=text-align:left class=sin-borde onclick='javascript:uf_checkall();'></th>";
 			}
 			else
 			{
 				$tabla .= "<th align=center>".$this->titles[$i]."</th>";
 			}
 		}
 		$tabla .= "</tr>";
		//$tabla .= "</thead>";
		//$tabla .= "<tbody>";
 		for($z=1;$z<=$this->numrows;$z++)
 		{
 			$tabla .= "<tr>";
 			for($y=1;$y<=$totcols;$y++)
 			{
 				$txt="txt".$this->titles[$y].$z;
 				$alineacion=$this->align[$y];
 				$tamano=$this->size[$y];
 				$max=$this->maxlength[$y];
 				$valida=$this->validaciones[$y];
 				$tabla .= "<td class=\"celdas-blancas\">".$object[$z][$y]."</td>";
 			}
			$tabla .= "</tr>";
 	  }
 	  $tabla .= "<tr><td><input type='hidden' name = 'txtnumrow' id ='txtnumrow' value ='{$z}'></td></tr>";
		//$tabla .= "</tbody>";
 	  $tabla .= "</table>";

		return $tabla;
 	}

	function make_gridScroll($rows,$titulos,$object,$widthtable,$titletable,$name,$alto_tabla)
	{
		print "<style type=text/css>";
              print ".innerb {height:10em; overflow:auto; width:".$widthtable."px; background-color:#FFFFFF;}";
		print "</style>";
		$this->numrows=$rows;
		$this->titles=$titulos;
		$this->widthtable=$widthtable;
		$this->titletable=$titletable;
		$totcols=count($this->titles);
		print "<table width=".$this->widthtable." id=".$name." class=fondo-tabla align=center>";
			print "<thead > ";
				print "<tr class=titulo-celda >";
					print "<td colspan=".$totcols.">".$this->titletable."</td>";
				print "</tr>";

			print "</thead>";
			print "<tbody class=fondo-tabla> ";
				print "<tr class=fondo-tabla><td colspan=".$totcols." class=fondo-tabla>";
					print "<div class='innerb' style='height:".$alto_tabla."px;' >";
						print "<table class=fondo-tabla border=0 cellspacing=1 cellpadding=0>";
						print "<tr class=titulo-celdanew>";
							for($i=1;$i<=$totcols;$i++)
							{
								print "<td align=center >".$this->titles[$i]."</td>";
							}
						print "</tr>";
						for($z=1;$z<=$this->numrows;$z++)
						{
							print "<tr id=celda".$z." name=celda".$z." class=celdas-blancas>";
							for($y=1;$y<=$totcols;$y++)
							{
								$txt="txt".$this->titles[$y].$z;
								$alineacion=$this->align[$y];
								$tama�o=$this->size[$y];
								$max=$this->maxlength[$y];
								$valida=$this->validaciones[$y];
								print "<td class=celdas-blancas  >".$object[$z][$y]."</td>";
							}
							print "</tr>";
					   }
					   print "</table>";
				  print "</div>";
			  print "</td>"	;
			  print "</tr>";
		  print "</tbody> ";
	  print "</table>";
	  print "<br>";
	}

}
?>

<link href="css/general.css" rel="stylesheet" type="text/css">
