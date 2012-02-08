<?php
class paging
{
	function navigation($aTotal, $aUrl, $aItemsPerPage = 3, $aLinksPerPage = 5) //recibe el total de valores a ser mostrados, la direccion base a la cual ir, el número de items por página y la cantidad de páginas con números a mostrar, retorna un juego de enlaces listos para colocar en la página. Puede que haya que modificar los estilos.
	{
		if ($aTotal && $aTotal > $aItemsPerPage){
			$num_pages = ceil($aTotal / $aItemsPerPage);
			$current_page = (int)$_GET['page'];
			$current_page = ($current_page < 1) ? 1 : ($current_page > $num_pages ? $num_pages : $current_page);
	
			$left_offset = ceil($aLinksPerPage / 2) - 1;
			$first = $current_page - $left_offset;
			$first = ($first < 1) ? 1 : $first;
	
			$last = $first + $aLinksPerPage - 1;
			$last = ($last > $num_pages) ? $num_pages : $last;
	
			$first = $last - $aLinksPerPage + 1;
			$first = ($first < 1) ? 1 : $first;
	
			$pages = range($first, $last);
	
			$out = '<div class="navigation">';
	
			$out .= "Page {$current_page} of {$num_pages} ";
			list($aUrl,$anchor) = explode("#",$aUrl);
			$delim = ('.php' == strtolower(substr($aUrl, -4))) ? '?' : '&amp;';
			if($anchor) {
				$anchor = "#".$anchor;
			}
	
			// Previous, First links
			if ($current_page > 1)
			{
				$prev = $current_page - 1;
				$out .= "<a class=\"url\" href=\"{$aUrl}{$delim}page=1{$anchor}\" title=\"First Page\">&#171;&#171;</a>";
				$out .= "<a class=\"url\" href=\"{$aUrl}{$delim}page={$prev}{$anchor}\" title=\"Previous Page\">&#171;</a>";
			}
			foreach ($pages as $page){
				if ($current_page == $page){
					$out .= "<span class=\"a\" style=\"font-weight: bold; background-color: #DEDEDE;\">{$page}</span>";
				}
				else{
					$out .= "<a class=\"url\" href=\"{$aUrl}{$delim}page={$page}{$anchor}\">{$page}</a>";
				}
			}
	
			if ($current_page < $num_pages){
				$next = $current_page + 1;
				$out .= "<a class=\"url\" href=\"{$aUrl}{$delim}page={$next}{$anchor}\" title=\"Next Page\">&#187;</a>";
				$out .= "<a class=\"url\" href=\"{$aUrl}{$delim}page={$num_pages}{$anchor}\" title=\"Last Page\">&#187;&#187;</a>";
			}	
			$out .= '</div>';
		}
		return $out;
	}

	function getGets() //retorna el nombre de la pagina actual con todos los parametros pasados por GET que tiene
	{
		$page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		$return = "";
		$x = 0;
		$y = false;
		$z = true;
		foreach($_GET as $key => $value)
		{
			if ($x != 0 && $key != "page")
				$return .= "&";
			$return .= $key."=".$value;
			$x++;
		}
		return $page."?".$return;
	}
	
	function Ajaxnavigation($aTotal, $span, $Mypage, $aItemsPerPage = 3, $aLinksPerPage = 5) //recibe el total de valores a ser mostrados, la direccion base a la cual ir, el número de items por página y la cantidad de páginas con números a mostrar, retorna un juego de enlaces listos para colocar en la página. Puede que haya que modificar los estilos.
	{
		if ($aTotal && $aTotal > $aItemsPerPage)
		{
			$num_pages = ceil($aTotal / $aItemsPerPage);
			$current_page = (int)$_GET['page'];
			$current_page = ($current_page < 1) ? 1 : ($current_page > $num_pages ? $num_pages : $current_page);
	
			$left_offset = ceil($aLinksPerPage / 2) - 1;
			$first = $current_page - $left_offset;
			$first = ($first < 1) ? 1 : $first;
	
			$last = $first + $aLinksPerPage - 1;
			$last = ($last > $num_pages) ? $num_pages : $last;
	
			$first = $last - $aLinksPerPage + 1;
			$first = ($first < 1) ? 1 : $first;
	
			$pages = range($first, $last);
	
			$out = '<div class="PagingNavigation">';
			$out .= "Page {$current_page} of {$num_pages} ";

			$delim = ('.php' == strtolower(substr($aUrl, -4))) ? '?' : '&amp;';

			// Previous, First links
			if ($current_page > 1)
			{
				$prev = $current_page - 1;
				$out .= "<a class=\"PagingLink\" href=\"#\" onclick=\"ajax('$span','{$Mypage}&page=1',''); return false;\" title=\"First Page\">&#171;&#171;</a>";
				$out .= "<a class=\"PagingLink\" href=\"#\" onclick=\"ajax('$span','{$Mypage}&page={$prev}',''); return false;\" title=\"Previous Page\">&#171;</a>";
			}
			foreach ($pages as $page)
			{
				if ($current_page == $page)
				{
					$out .= "<span class=\"PagingCurrent\">{$page}</span>";
				}
				else
				{
					$out .= "<a class=\"PagingLink\" href=\"#\" onclick=\"ajax('$span','{$Mypage}&page={$page}',''); return false;\">{$page}</a>";
				}
			}
	
			if ($current_page < $num_pages)
			{
				$next = $current_page + 1;
				$out .= "<a class=\"PagingLink\" href=\"#\" onclick=\"ajax('$span','{$Mypage}&page={$next}',''); return false;\" title=\"Next Page\">&#187;</a>";
				$out .= "<a class=\"PagingLink\" href=\"#\" onclick=\"ajax('$span','{$Mypage}&page={$num_pages}',''); return false;\" title=\"Last Page\">&#187;&#187;</a>";
			}
			$out .= '</div>';
		}
		return $out;
	}

}
?>