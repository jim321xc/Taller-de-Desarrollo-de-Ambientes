var xmlHttp=null;

function GetXmlHttpObject()
{
	try
	{// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{//Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		result = xmlHttp.responseText;
		document.getElementById(span).innerHTML = result;    
	} 
}

function ajax(span1,url,poststr)
{
	span=span1;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open('POST',url,true);
	xmlHttp.send(poststr);
}

function closeajax(span1)
{
	document.getElementById(span1).innerHTML = '';
}