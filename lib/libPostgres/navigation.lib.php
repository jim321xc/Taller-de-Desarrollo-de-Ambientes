<?php
class navigation
{
	function showpie()
	{
		$class = new template;
		$class->SetTemplate('html/pie.html');
		return $class->Display();
	}
	function showmenuadm()
	{
		$class = new template;
		$class->SetTemplate('html/menuadm.html');
		return $class->Display();
	}
	function showregistro()
	{
		$class = new template;
		$class->SetTemplate('html/registro.html');
		return $class->Display();
	}
	function showcalendario()
	{
		$class = new template;
		$class->SetTemplate('html/calendario.html');
		return $class->Display();
	}	
	function showmenajes()
	{
		$class = new template;
		$class->SetTemplate('html/mensajes.html');
		return $class->Display();
	}
	
	function showFeaturedPakages()
	{
		$class = new template;
		$class->SetTemplate('tpl/featuredPakages.html');
		$query = new query;
		$rows = $query -> getRows("HomeId, HomeName, HomeImage","homes", "ORDER BY RAND()");
		for ($i = 0; $i < 3; $i++)
		{
			$class->SetParameter('img'.$i,"./images/jpg.php?maxHeight=130&amp;maxWidth=190&amp;name={$rows[$i]['HomeImage']}&amp;fixedWidthAspect=190&amp;fixedHeightAspect=130&amp;fillRed=255&amp;fillGreen=255&amp;fillBlue=255");
			$class->SetParameter('text'.$i,$rows[$i]['HomeName']);
			$class->SetParameter('url'.$i,$rows[$i]['HomeId']);
		}
		return $class->Display();
	}
	
	function showFooter()
	{
		$class = new template;
		$class->SetTemplate('tpl/footer.html');
		$class->SetParameter('profile',($_SESSION['UserId'] != "" ? "\n<li><a href=\"edit_profile.php\">My Profile</a></li>" : ""));
		return $class->Display();
	}
	
	function showUpperMenu()
	{
		$class = new template;
		$class->SetTemplate('tpl/upperMenu.html');
		$class->SetParameter('signup',($_SESSION['UserId'] == "" ? "\n<li><a href=\"signUp.php\">Sign Up</a></li>" : ""));
		$class->SetParameter('signup',($_SESSION['UserType'] == "1" ? "\n<li><a href=\"admin/index.php\" target=\"_blank\"><b>Admin</b></a></li>" : ($class -> parameter['signup']) ));
		return $class->Display();
	}
	
	function showSearchBar()
	{
		$class = new template;
		$query = new query;
		$class->SetTemplate('tpl/searchBar.html');
		$resultType = $query->getRows("*","typeitems");
        foreach($resultType as $key) 
		{
            $checkType .= '<input style="display:none;" type="checkbox" checked name="typeitem[]" value="'.$key['TypeItemId'].'">';
        }
		$class->SetParameter('types',$checkType);
		return $class->Display();
	}
	
	function showParents()
	{
		$pages = array ("insert_cliente.php");
		$names = array ("Sign Up");
		
		$class = new template;
		$class->SetTemplate('html/history.html');
		$page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		if (array_search($page,$pages) === false)
			$name = "Unknown";
		else
			$name = $names[array_search($page,$pages)];
		$content = "<a href=\"$page\">$name</a>";
		if (count($_GET) > 0)
		{
			$return = "";
			$x = 0;
			foreach($_GET as $key => $value)
			{
				if ($x != 0 && $key != "page")
					$return .= "&";
				$return .= $key."=".$value;
				$x++;
			}
			$content .= " / <a href=\"{$page}?{$return}\">Current page</a>";
		}
		$class->SetParameter('contenido',$content);
		return $class->Display();
	}
	
	function rotateBanner()
	{
    $banner_path = "./banners/";
    $dir = opendir($banner_path);
    $banner_array = array ();
    while ($filename = readdir($dir))
    {
    	if ($filename != "." && $filename != "..")
    		$banner_array[] = $filename;
    }
    $banner = array_rand($banner_array);
    $banner = $banner_array[rand(1,count($banner_array)) - 1];
    
    return "images/jpg.php?name=../banners/".$banner."&fixedHeight=206&fixedWidth=714";
  }
	
	function sitePal()
	{
		return "";
	}
	
}
?>