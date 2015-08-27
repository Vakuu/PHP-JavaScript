function createXMLHttp(){
		if(typeof XMLHttpRequest != "undefined") return new XMLHttpRequest();
		else if(window.ActiveXObject){
			var aVersions = [
			                "MSXML2.XMLHttp.6.0", 
			                "MSXML2.XMLHttp.5.0",
							"MSXML2.XMLHttp.4.0",
							"MSXML2.XMLHttp.3.0",
							"MSXML2.XMLHttp",
							"Microsoft.XMLHttp" ];
			for(var i = 0; i < aVersions.length; i++){
				try{
					var oXMLHttp = new ActiveXObject(aVersions[i]);
					return oXMLHttp;
				}
				catch(oError)
				{}
			}
		}
		throw new Error("XMLHttp object could not be created.");
}
        
function VerifyEGN(egn)
{	var koef = "020408051009070306";
	var i = 0;
	if((egn.substr(0,10) == '0000000000')||
	(egn.substr(0,10) == '1111111111')||
	(egn.substr(0,10) == '2222222222')||
	(egn.substr(0,10) == '3333333333')||
	(egn.substr(0,10) == '4444444444')||
	(egn.substr(0,10) == '5555555555')||
	(egn.substr(0,10) == '6666666666')||
	(egn.substr(0,10) == '7777777777')||
	(egn.substr(0,10) == '8888888888')||
	(egn.substr(0,10) == '9999999999')||
	(egn.substr(0,10) == '123456789'))
	{	alert("Въведеното ЕГН е невалидно!");
		return false;
	}for (j = 0; j < egn.length - 1; j++)
		i += (egn.substr(j, 1) - '0') * ((koef.substr(j * 2, 1) - '0') * 10 + (koef.substr(j * 2 + 1, 1) - '0'));
	i %= 11;
	i %= 10;
	if (i != (egn.substr(9, 1) - '0'))
	{	alert("Въведеното ЕГН е невалидно!");
		return false;
	}
	return true;
}
	
function VerifyBulstat(bulstat)
{	var cod = new Array();
	cod[0] = new Array();
	cod[0][0] = 1;
	cod[0][1] = 3;
	cod[1] = new Array();
	cod[1][0] = 2;
	cod[1][1] = 4;
	cod[2] = new Array();
	cod[2][0] = 3;
	cod[2][1] = 5;
	cod[3] = new Array();
	cod[3][0] = 4;
	cod[3][1] = 6;
	cod[4] = new Array();
	cod[4][0] = 5;
	cod[4][1] = 7;
	cod[5] = new Array();
	cod[5][0] = 6;
	cod[5][1] = 8;
	cod[6] = new Array();
	cod[6][0] = 7;
	cod[6][1] = 9;
	cod[7] = new Array();
	cod[7][0] = 8;
	cod[7][1] = 10;
	cod[8] = new Array();
	cod[8][0] = 2;
	cod[8][1] = 4;
	cod[9] = new Array();
	cod[9][0] = 7;
	cod[9][1] = 9;
	cod[10] = new Array();
	cod[10][0] = 3;
	cod[10][1] = 5;
	cod[11] = new Array();
	cod[11][0] = 5;
	cod[11][1] = 7;
	var sum = 0;
	var result;
	for (i = 0; i < 8; i++)
	{	sum += (cod[i][0] * parseInt(bulstat.substr(i, 1)));
	}if ((sum % 11) == 10)
	{	sum = 0;
		for (i = 0; i < 8; i++)
		{	sum += (cod[i][1] * parseInt(bulstat.substr(i, 1)));
		}if ((sum % 11) == 10)
		{	sum = 0;
		}
	}var x = (sum % 11).toString();
	if (bulstat.length == 9)
	{	result = (x.substr(0, 1) == bulstat.substr(8, 1));
		if (!result) alert("Въведеният булстат е невалиден!");
		{	return result;
		}
	}else
	{	if ((x.substr(0, 1) == bulstat.substr(8, 1)) /*&& bulstat.length != 10*/)
		{	sum = 0;
			for (i = 8; i < bulstat.length - 1; i++)
			{	sum += (cod[i][0] * parseInt(bulstat.substr(i, 1)));
			}x = (sum % 11).toString();
			if ((sum % 11) == 10)
			{	sum = 0;
				for (i = 8; i < bulstat.length - 1; i++)
				{	sum += (cod[i][1] * parseInt(bulstat.substr(i, 1)));
				}if ((sum % 11) == 10)
				{	sum = 0;
				}x = (sum % 11).toString();
			}result = (x.substr(0, 1) == bulstat.substr(bulstat.length - 1, 1));
			if (!result)
			{	alert("Въведеният булстат е невалиден!");
			}return result;
		}else
		{	alert("Въведеният булстат е невалиден!");
			return false;
		}
		//	else
		//	if (VerifyEGN(bulstat))
		//  return true;
		//  else 
		//   { alert("Въведеният булстат е невалиден!");
		//	return false;
		//  }
	}
}
function OpenWindow(url, title, width, height) {
  var screen_width = screen.width;
  var screen_height = screen.height;

  var left = Math.ceil((screen_width - width) / 2);
  var top = Math.ceil((screen_height - height) / 2);

  window.open(url, title, 'left=' + left + ', top=' + top + ', width=' + width + ', height=' + height);
}

function inquire(page, width, height){
    OpenWindow(page, '', width, height);
}


function popup($page, $popup, $top, $left, $width, $height){	
  parent.document.getElementById($popup).style.top = $top;
  parent.document.getElementById($popup).style.left = $left;
  parent.document.getElementById($popup).style.width = $width;
  parent.document.getElementById($popup).style.height = $height;
  parent.document.getElementById($popup).style.zIndex = 3;
  parent.document.getElementById($popup).src=$page;
  parent.document.getElementById($popup).style.display='';
parent.document.getElementById($popup).style.overflowX = 'none';
}


function attachFile()
{	var asoc_id=document.getElementById('hid_asoc_id').value;
	var build_id=document.getElementById('hid_build_id').value;
   	 
	 popup('AttachFile.php?asoc_id='+asoc_id+'&build_id='+build_id ,'popup3', 0, 0, '100%', '');
}
function getAttachedFiles(){
	var asoc_id=document.getElementById('hid_asoc_id').value;
	popup('AttachedFiles.php?asoc_id='+asoc_id+'&flag=1','popup3', 0, 0, '100%', '');
}

function preebeteMiITaqFunc(divId, btnVal){
	if(btnVal == '+'){
		document.getElementById('docs_btn').value = '-';
		document.getElementById(divId).className = '';
	}else{
		document.getElementById('docs_btn').value = '+';
		document.getElementById(divId).className = 'hide';
	}
}

function displayHide(divID, btnID){
	if(btnID == '+'){
		if (divID.id=='build_form_container')
		{	document.getElementById('build_btn').value = '-';
			divID.className = '';
			document.getElementById('association_btn').value = '+';
			document.getElementById('represents_btn').value = '+';
			document.getElementById('association_form_container').className = 'hide';
			document.getElementById('people_form_container').className = 'hide';
			if (document.getElementById('hid_asoc_id').value!='')
			{	document.getElementById('asoc_ident_rn').value=document.getElementById('asoc_numbh').value;
				document.getElementById('asoc_ident_b').value=document.getElementById('bulstath').value;
			}
		}if (divID.id=='association_form_container')
		{	if (document.getElementById('hid_build_id').value!='')
			{	document.getElementById('build_identify').value=document.getElementById('build_identifyh').value;
				document.getElementById('association_btn').value = '-';
				divID.className = '';
				document.getElementById('build_btn').value = '+';
				document.getElementById('represents_btn').value = '-';
				document.getElementById('build_form_container').className = 'hide';
				document.getElementById('people_form_container').className = '';
			}else
			{	alert('Моля изберете/въведете сграда първо!');
				document.getElementById('build_identify').focus();
			}
		}if (divID.id=='people_form_container')
		{	if (document.getElementById('hid_asoc_id').value!='')
			{	document.getElementById('build_identify').value=document.getElementById('build_identifyh').value;
				document.getElementById('asoc_ident_rn').value=document.getElementById('asoc_numbh').value;
				document.getElementById('asoc_ident_b').value=document.getElementById('bulstath').value;
				document.getElementById('represents_btn').value = '-';
				divID.className = '';
				document.getElementById('build_btn').value = '+';
				document.getElementById('association_btn').value = '-';
				document.getElementById('build_form_container').className = 'hide';
				document.getElementById('association_form_container').className = '';
			}else
			{	alert('Моля изберете/въведете сдружение първо!');
				document.getElementById('asoc_ident_rt').focus();
			}
		}
	}else
	{	divID.className = 'hide';
		if (divID.id=='build_form_container')
		{	document.getElementById('build_btn').value = '+';
			document.getElementById('build_identify').value=document.getElementById('build_identifyh').value;
		}if (divID.id=='association_form_container')
		{	document.getElementById('association_btn').value = '+';
			document.getElementById('represents_btn').value = '+';
			document.getElementById('people_form_container').className = 'hide';
			document.getElementById('asoc_ident_rn').value=document.getElementById('asoc_numbh').value;
		}if (divID.id=='people_form_container')
		{	document.getElementById('represents_btn').value = '+';
			document.getElementById('association_btn').value = '+';
			document.getElementById('association_form_container').className = 'hide';
			document.getElementById('asoc_ident_rn').value=document.getElementById('asoc_numbh').value;
		}
	}
}
function getRegion()
{	//alert('getRegion');
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&element=region', false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					document.getElementById('raion_td').innerHTML = ajax.responseText;
//					ifstreet();
				}
			}
		ajax.send(null);
}function onchangeraion()
{	//alert('onchangeraion');
	var raion = document.getElementById('raion_sel').value;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&type=onchangeraion&raion='+raion, true);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					realresponse=ajax.responseText;
					var selects=realresponse.split('$');
					document.getElementById('nasel_td').innerHTML = selects[0];
					document.getElementById('hood_td').innerHTML = selects[1];
					document.getElementById('jk_td').innerHTML = selects[2];
					ifstreet();
				}
			}
	ajax.send(null);
}function onchangeraion2()
{	//alert('onchangeraion2');
	var raion = document.getElementById('raion_sel').value;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&type=onchangeraion&raion='+raion, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					realresponse=ajax.responseText;
					var selects=realresponse.split('$');
					document.getElementById('nasel_td').innerHTML = selects[0];
					document.getElementById('hood_td').innerHTML = selects[1];
					document.getElementById('jk_td').innerHTML = selects[2];
					//ifstreet();
				}
			}
	ajax.send(null);
}function constructionType(){
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&element=construction', false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					document.getElementById('construction').innerHTML = ajax.responseText;
				}
			}
		ajax.send(null);
}function getActivity(){
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&type=sdr&element=activity', false);
		ajax.onreadystatechange = function(){
			if((ajax.readyState == 4) && (ajax.status == 200)){
				document.getElementById('deinost').innerHTML = ajax.responseText;
			}
		}
	ajax.send(null);
}function getPredst(){
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&type=sdr&element=predst', false);
		ajax.onreadystatechange = function(){
			if((ajax.readyState == 4) && (ajax.status == 200)){
				document.getElementById('predstavitelstvo').innerHTML = ajax.responseText;
			}
		}
	ajax.send(null);
}function getRepresentators(){
	var ajax = new XMLHttpRequest();
	ajax.open('get', 'ajaxResults.php?file=register&element=predstaviteli', true);
	ajax.onreadystatechange = function(){
		if((ajax.readyState == 4) && (ajax.status == 200)){
			document.getElementById('predstaviteli').innerHTML = ajax.responseText;
		}
	}
	ajax.send(null);
}function getLength(id){
	var str = document.getElementById(id).value;
	var workstr = str.split('').length;
		if(workstr > 22){
			document.getElementById(id).setAttribute('style', 'width: 300px;');
		}
}function getOverIt(){
	document.getElementById('sdruj_name').value = document.getElementById('asoc_name').value;
}
function save_build(a)
{	var hid_build_id=document.getElementById('hid_build_id').value;
	var build_identify1=document.getElementById('build_identifyh').value;
	var raion=document.getElementById('raion_sel').value;
	var nasel=document.getElementById('nasel_sel').value;
	var hood=document.getElementById('hood_sel').value;
	var jk=document.getElementById('jk_sel').value;
	var build_numb=document.getElementById('build_numb').value;
	var vhodove=document.getElementById('vhodove').value;
	var numb_floors=document.getElementById('numb_floors').value;
	var numb_under_floors=document.getElementById('numb_under_floors').value;
	var numb_half_under=document.getElementById('numb_half_under').value;
	var numb_on_ground=document.getElementById('numb_on_ground').value;
	var all_objects=document.getElementById('all_objects').value;
	var object_fiz=document.getElementById('object_fiz').value;
	var object_comp=document.getElementById('object_comp').value;
	var object_os=document.getElementById('object_os').value;
	var object_ds=document.getElementById('object_ds').value;
	var object_trade=document.getElementById('object_trade').value;
	var year_of_const=document.getElementById('year_of_const').value;
	var construct_type=document.getElementById('construct_type').value;
	var pril_parts=document.getElementById('pril_parts').value;
	var secs=document.getElementById('secs').value;
	fill_hid_adr();
	var asoc_address=document.getElementById('asoc_address').innerHTML;
	if (document.getElementById('street_sel')!=null)
	{	var street=document.getElementById('street_sel').value;
	}else
	{	var street=document.getElementById('str_search').value;
	}
	var str_nom=document.getElementById('str_nom').value;
	var total_square=document.getElementById('total_square').value;
	var ajax = new XMLHttpRequest();
	ajax.open('get', 'ajaxResults.php?file=register&what=save_build&save_redact='+a+'&hid_build_id='+hid_build_id+'&build_identify='+build_identify1+'&raion='+raion+'&nasel='+nasel+'&hood='+hood+'&jk='+jk+'&build_numb='+build_numb+
		'&vhodove='+vhodove+'&numb_floors='+numb_floors+'&numb_under_floors='+numb_under_floors+'&numb_half_under='+numb_half_under+
		'&numb_on_ground='+numb_on_ground+'&all_objects='+all_objects+'&object_fiz='+object_fiz+'&object_comp='+object_comp+
		'&asoc_address='+asoc_address+'&object_os='+object_os+'&object_ds='+object_ds+'&object_trade='+object_trade+'&year_of_const='+year_of_const+
		'&construct_type='+construct_type+'&pril_parts='+pril_parts+'&total_square='+total_square+'&secs='+secs+'&street='+street+'&str_nom='+str_nom, false);
		ajax.onreadystatechange = function(){
			if((ajax.readyState == 4) && (ajax.status == 200)){
				var first=ajax.responseText.substr(0,14);
				var last=ajax.responseText.substr(14,ajax.responseText.length-1);
				if (first=="Успешен запис!")
				{	if (a==1)
					{	alert(first);
						document.getElementById('autocompletea').innerHTML="";
						document.getElementById('curedit').disabled=false;
						document.getElementById('curdel').disabled=false;
						FORM_CHANGEb = false;
						//fill_hid_adr();
					}if (a==2)
					{	alert('Успешна редакция!');
						FORM_CHANGEb = false;
					}
					document.getElementById('hid_build_id').value=last;
					document.getElementById('build_identify').value=document.getElementById('build_identifyh').value;
					document.getElementById('autocompleteb').innerHTML="";
					//fill_hid_adr();
				}else
				{	alert(ajax.responseText);
				}
				//document.getElementById('sql').innerHTML=ajax.responseText;
			}
		}
	ajax.send(null);
}
function delete_build()
{	var hid_build_id=document.getElementById('hid_build_id').value;
	var ajax = new XMLHttpRequest();
	ajax.open('get', 'ajaxResults.php?file=register&what=save_build&save_redact='+a, false);
		ajax.onreadystatechange = function(){
			if((ajax.readyState == 4) && (ajax.status == 200)){
			}
		}
	ajax.send(null);
}
function save_asoc(a)
{	var hid_build_id=document.getElementById('hid_build_id').value;
	var hid_asoc_id=document.getElementById('hid_asoc_id').value;
	//build_identify1=document.getElementById('build_identifyh').value;
	var asoc_numb=document.getElementById('esso2').innerHTML;
	asoc_numb+=document.getElementById('asoc_numbh').value;
	var bulstat=document.getElementById('bulstath').value;
	var asoc_name=document.getElementById('asoc_name').value;
//	if (document.getElementById('asoc_address')!=null)
//	{	
	var asoc_address=document.getElementById('asoc_address').innerHTML;
	var entries=document.getElementById('entries').value;
//	}
	var date_of_create=document.getElementById('date_of_create').value;
	var srok=document.getElementById('srok').value;
	var date_of_entry=document.getElementById('date_of_entry').value;
	var asoc_ideal_parts=document.getElementById('asoc_ideal_parts').value;
	var predmet=document.getElementById('predmet').value;
	var predst=document.getElementById('predst').value;
	var bl_secs=document.getElementById('bl_secs').value;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=save_asoc&save_redact='+a+'&hid_asoc_id='+hid_asoc_id+'&asoc_numb='+asoc_numb+'&bulstat='+bulstat+'&asoc_name='+asoc_name+
			'&asoc_address='+asoc_address+'&entries='+entries+'&date_of_create='+date_of_create+'&srok='+srok+'&date_of_entry='+date_of_entry+
			'&asoc_ideal_parts='+asoc_ideal_parts+'&predmet='+predmet+'&predst='+predst+'&hid_build_id='+hid_build_id+'&bl_secs='+bl_secs, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					var first=ajax.responseText.substr(0,14);
					var last=ajax.responseText.substr(14,ajax.responseText.length-1);
					if (first=="Успешен запис!")
					{	if (a==1)
						{	alert(first);
							FORM_CHANGEa = false;
							document.getElementById('request_container').className="";
							refresh_rq_co();
						}if (a==2)
						{	alert('Успешна редакция!');
							FORM_CHANGEa = false;
							refresh_rq_co();
						}
						document.getElementById('hid_asoc_id').value=last;
						document.getElementById('asoc_ident_rn').value=document.getElementById('asoc_numbh').value;
						document.getElementById('asoc_ident_b').value=document.getElementById('bulstath').value;
						document.getElementById('sdruj_name').value=document.getElementById('asoc_name').value;
						document.getElementById('autocompleteb').innerHTML="";
					}else
					{	alert(ajax.responseText);}
					document.getElementById('curedita').disabled=false;
					document.getElementById('curdela').disabled=false;
					document.getElementById('b11').disabled=false;
					document.getElementById('b5').disabled=false;
				}
			}
		ajax.send(null);
}
function ifbuild(sign)
{	build_identify1=document.getElementById('build_identify').value;
	document.getElementById('build_identifyh').value=build_identify1;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=ifbuild&sign='+sign+'&build_identify='+build_identify1, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					first=ajax.responseText.substr(0,1);
					realresponse=ajax.responseText.substr(1,ajax.responseText.length-1);
					if (first=='0')
					{	document.forms['build_form'].reset();
						document.getElementById('autocompleteb').innerHTML="";
						document.getElementById('build_identifyh').value=document.getElementById('build_identify').value;
						document.getElementById('curedit').disabled=true;
						document.getElementById('curdel').disabled=true;
						document.getElementById('request_container').className='hide';
						//alert('ifbuild-0');
					}
					if (first=='1')
					{	//alert('ifbuild-1');
						document.getElementById('curedit').disabled=false;
						document.getElementById('curdel').disabled=false;
						document.getElementById('autocompleteb').innerHTML="";
						var buildata=realresponse.split('@');
						if (buildata[3]==null)
						{	document.forms['build_form'].reset();
							document.getElementById('build_identifyh').value=document.getElementById('build_identify').value;
						}else
						{	document.getElementById('hid_build_id').value=buildata[0];
							document.getElementById('build_identifyh').value=buildata[1];
							//document.getElementById('build_identify').value=buildata[1];
							document.getElementById('raion_sel').value=buildata[5];
							onchangeraion2();
							//document.getElementById('asoc_ident_rn').value="ЕССО"+buildata[5]+"-";
							//document.getElementById('asoc_numbh').value="ЕССО"+buildata[5]+"-";
							document.getElementById('nasel_sel').value=buildata[6];
							document.getElementById('hood_sel').value=buildata[7];
							document.getElementById('jk_sel').value=buildata[8];
							document.getElementById('build_numb').value=buildata[4];
							document.getElementById('vhodove').value=buildata[9];
							document.getElementById('numb_floors').value=buildata[10];
							document.getElementById('numb_under_floors').value=buildata[11];
							document.getElementById('numb_half_under').value=buildata[12];
							document.getElementById('numb_on_ground').value=buildata[13];
							document.getElementById('all_objects').value=buildata[14];
							document.getElementById('object_fiz').value=buildata[15];
							document.getElementById('object_comp').value=buildata[16];
							document.getElementById('object_os').value=buildata[17];
							document.getElementById('object_ds').value=buildata[18];
							document.getElementById('object_trade').value=buildata[19];
							document.getElementById('year_of_const').value=buildata[20];
							document.getElementById('construct_type').value=buildata[21];
							document.getElementById('pril_parts').value=buildata[23];
							document.getElementById('total_square').value=buildata[22];
							document.getElementById('secs').value=buildata[24];
							document.getElementById('str_search').value=buildata[25];
							ifstreet();
							document.getElementById('str_nom').value=buildata[26];
							if (sign!='=')
							{	//fill_hid_adr();
							}
						}
					}if (first=='2')
					{	//alert('ifbuild-2');
						document.getElementById('curedit').disabled=false;
						document.getElementById('curdel').disabled=false;
						document.getElementById('autocompleteb').innerHTML=realresponse;
						fillformb();
						//fill_hid_adr();
					}
				}
			}
		ajax.send(null);
}
function fill_hid_adr()
{	//alert('fill_hid_adr');
	//document.getElementById('adr').innerHTML='<input type="text" name="asoc_address" id="asoc_adress" cols="35" rows="2">';
	var e = document.getElementById("raion_sel");
	if (e.options[e.selectedIndex].text!='')
	{	var raio1=e.options[e.selectedIndex].text.toUpperCase();
		raio1=raio1.substr(3,raio1.length);
		var raio='Район '+raio1+', ';
	}else
	{	var raio='';}
	var e = document.getElementById("nasel_sel");
	if (e.options[e.selectedIndex].text!='')
	{	var nasel=e.options[e.selectedIndex].text+', ';	
	}else
	{	var nasel='';
	}var e = document.getElementById("hood_sel");											
	if (e.options[e.selectedIndex].text!='')
	{	var kvarta=e.options[e.selectedIndex].text+', ';
	}else
	{	var kvarta='';
	}var e = document.getElementById("jk_sel");
	if (e.options[e.selectedIndex].text!='')
	{	var jk=e.options[e.selectedIndex].text+', ';	
	}else
	{	var jk='';
	}if (document.getElementById('street_sel')!=null)
	{	var street=document.getElementById('street_sel').value+', ';
	}else
	{	var street=document.getElementById('str_search').value+', ';
	}if (document.getElementById("str_nom").value!='')
	{	if (street!='')
		{	street=street.substr(0,street.length-2);
			var snumber=' № '+document.getElementById("str_nom").value+', ';
		}else
		{	var snumber='№ '+document.getElementById("str_nom").value+', ';
		}
	}else
	{	var snumber='';
	}if (document.getElementById("build_numb").value!='')
	{	var bnumber='бл. '+document.getElementById("build_numb").value+', ';
	}else
	{	var bnumber='';
	}niz=raio+nasel+kvarta+jk+street+snumber+bnumber;
	if (niz.substr(niz.length-2,2)==', ')
	{	niz=niz.substr(0,niz.length-2);
	}document.getElementById('asoc_address').innerHTML=niz;
	essogen();
}
function essogen()
{	var rai=document.getElementById("raion_sel").value;
	if (rai<10)
	{rai='0'+rai;}
	document.getElementById('esso').innerHTML='ЕССО'+rai+'-';
	document.getElementById('esso2').innerHTML='ЕССО'+rai+'-';
}
function ifasoc(sign)
{	var hid_build_id=document.getElementById('hid_build_id').value;
	document.getElementById('asoc_list').className="hide";
	if (hid_build_id!="")
	{	asoc_ident_rn1=document.getElementById('esso').innerHTML+document.getElementById('asoc_ident_rn').value;
		document.getElementById('asoc_numbh').value=asoc_ident_rn1;
		asoc_ident_b1=document.getElementById('asoc_ident_b').value;
		document.getElementById('bulstath').value=asoc_ident_b1;
		var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=ifasoc&sign='+sign+'&asoc_ident_rn='+asoc_ident_rn1+'&asoc_ident_b='+asoc_ident_b1+'&hid_build_id='+hid_build_id, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					first=ajax.responseText.substr(0,1);
					realresponse=ajax.responseText.substr(1,ajax.responseText.length-1);
					document.getElementById('autocompletea').innerHTML="";
					if (first=='0')
					{	//alert('ifasoc-0');
						document.forms['asoc_form'].reset();
						document.getElementById('bulstath').value=document.getElementById('asoc_ident_b').value;
						document.getElementById('asoc_numbh').value=document.getElementById('asoc_ident_rn').value;
						document.getElementById('curedita').disabled=true;
						document.getElementById('curdela').disabled=true;
						document.getElementById('b11').disabled=true;
						document.getElementById('b5').disabled=true;
						document.getElementById('autocompletea').innerHTML="";
						fill_hid_adr();
						refreshlist();
						document.getElementById('request_container').className='hide';					
					}
					if (first=='1')
					{	//alert('ifasoc-1');
						document.getElementById('curedita').disabled=false;
						document.getElementById('curdela').disabled=false;
						document.getElementById('b5').disabled=false;
						document.getElementById('b11').disabled=false;
						document.getElementById('autocompletea').innerHTML="";
						var buildata=realresponse.split('@');
						if (buildata[3]==null)
						{	document.forms['asoc_form'].reset();
							document.getElementById('asoc_numbh').value=document.getElementById('asoc_ident_rn').value;
							document.getElementById('bulstath').value=document.getElementById('asoc_ident_b').value;
						}else
						{	document.getElementById('hid_asoc_id').value=buildata[0];
							var builddata3m=buildata[3].split('-');
							var builddata3=builddata3m[1]+"-"+builddata3m[2];
							document.getElementById('esso').innerHTML=builddata3m[0]+"-";
							document.getElementById('esso2').innerHTML=builddata3m[0]+"-";
							document.getElementById('asoc_numbh').value=builddata3;
							if (document.getElementById('association_btn').value=='+')
							{	document.getElementById('asoc_ident_rn').value=builddata3;
							}
							document.getElementById('bulstath').value=buildata[4];
							document.getElementById('asoc_ident_b').value=buildata[4];
							document.getElementById('asoc_name').value=buildata[5];
							document.getElementById('asoc_address').innerHTML=buildata[6];
							document.getElementById('entries').value=buildata[7];
							document.getElementById('date_of_create').value=buildata[8];
							document.getElementById('srok').value=buildata[9];
							document.getElementById('date_of_entry').value=buildata[10];
							document.getElementById('predmet').value=buildata[11];
							document.getElementById('predst').value=buildata[12];
							document.getElementById('asoc_ideal_parts').value=buildata[14];
							document.getElementById('sdruj_name').value=document.getElementById('asoc_name').value;
							document.getElementById('attached').value=buildata[21];
							document.getElementById('bl_secs').value=buildata[20];
							refreshlist();
							refresh_rq_co();
						}
					}if (first=='2')
					{	//alert('ifasoc-2');
						document.getElementById('curedita').disabled=false;
						document.getElementById('curdela').disabled=false;
						document.getElementById('b11').disabled=false;
						document.getElementById('b5').disabled=false;
						document.getElementById('autocompletea').innerHTML=realresponse;
						fillforma();
						refresh_rq_co();
					}
				}
			}
		ajax.send(null);
	}else
	{	document.getElementById('autocompletea').innerHTML="";
		//fill_hid_adr();
	}
}
function ifstreet()
{	//alert('ifstreet');
	var e = document.getElementById("nasel_sel");
	if (e.options[e.selectedIndex].text=='гр. София')
	{	var nasel='grs';
	}else
	{	var nasel=document.getElementById('nasel_sel').value;
	}
	if (document.getElementById('str_search')!==null)
	{	var str_search=document.getElementById('str_search').value;
		var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=ifstreet&nasel='+nasel+'&str_search='+str_search, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					var first=ajax.responseText.substr(0,1);
					var realresponse=ajax.responseText.substr(1,ajax.responseText.length-1);
					if (first=='0')
					{	document.getElementById('autocompletes').innerHTML='';
						//alert('Няма намерени улици отговарящи на въведения низ в комбинация с избраните район и/или квартал');
					}
					if (first=='1')
					{	document.getElementById('autocompletes').innerHTML=realresponse;
					}
					if (first=='2')
					{	document.getElementById('autocompletes').innerHTML=realresponse;
					}
				}
			}
		ajax.send(null);
	}
	else
	{
	}
}

function fillformb()
{	var buildata=document.getElementById('manyb').value.split('@');
	document.getElementById('hid_build_id').value=buildata[0];
	document.getElementById('build_identifyh').value=buildata[1];
	//document.getElementById('build_identify').value=buildata[1];
	document.getElementById('raion_sel').value=buildata[5];
	onchangeraion2();
	//document.getElementById('asoc_ident_rn').value="ЕССО"+buildata[5]+"-";
	//document.getElementById('asoc_numbh').value="ЕССО"+buildata[5]+"-";
	document.getElementById('nasel_sel').value=buildata[6];
	document.getElementById('hood_sel').value=buildata[7];
	document.getElementById('jk_sel').value=buildata[8];
	document.getElementById('build_numb').value=buildata[4];
	document.getElementById('vhodove').value=buildata[9];
	document.getElementById('numb_floors').value=buildata[10];
	document.getElementById('numb_under_floors').value=buildata[11];
	document.getElementById('numb_half_under').value=buildata[12];
	document.getElementById('numb_on_ground').value=buildata[13];
	document.getElementById('all_objects').value=buildata[14];
	document.getElementById('object_fiz').value=buildata[15];
	document.getElementById('object_comp').value=buildata[16];
	document.getElementById('object_os').value=buildata[17];
	document.getElementById('object_ds').value=buildata[18];
	document.getElementById('object_trade').value=buildata[19];
	document.getElementById('year_of_const').value=buildata[20];
	document.getElementById('construct_type').value=buildata[21];
	document.getElementById('pril_parts').value=buildata[23];
	document.getElementById('total_square').value=buildata[22];
	document.getElementById('secs').value=buildata[24];
	document.getElementById('str_search').value=buildata[25];
	ifstreet();
	document.getElementById('str_nom').value=buildata[26];
}
function fillforma()
{	var asocdata=document.getElementById('manya').value.split('@');
	document.getElementById('hid_asoc_id').value=asocdata[0];
	var builddata3m=asocdata[3].split('-');
	var asocdata3=builddata3m[1]+"-"+builddata3m[2];
	document.getElementById('esso').innerHTML=builddata3m[0]+"-";
	document.getElementById('esso2').innerHTML=builddata3m[0]+"-";
	document.getElementById('asoc_numbh').value=asocdata3;
	if (document.getElementById('association_btn').value=='+')
	{	document.getElementById('asoc_ident_rn').value=asocdata3;
	}
	document.getElementById('bulstath').value=asocdata[4];
	//document.getElementById('asoc_ident_b').value=asocdata[4];
	document.getElementById('asoc_name').value=asocdata[5];
	document.getElementById('asoc_address').innerHTML=asocdata[6];
	document.getElementById('entries').value=asocdata[7];
	document.getElementById('date_of_create').value=asocdata[8];
	document.getElementById('srok').value=asocdata[9];
	document.getElementById('date_of_entry').value=asocdata[10];
	document.getElementById('predmet').value=asocdata[11];
	document.getElementById('predst').value=asocdata[12];
	document.getElementById('asoc_ideal_parts').value=asocdata[14];
//	alert(asocdata[13]);
//	alert(asocdata[15]);
//	alert(asocdata[16]);
//	alert(asocdata[17]);
//	alert(asocdata[18]);
//	alert(asocdata[19]);
	document.getElementById('sdruj_name').value=document.getElementById('asoc_name').value;
	document.getElementById('attached').value=asocdata[21];
	document.getElementById('bl_secs').value=asocdata[20];
	//document.getElementById('adr').innerHTML=document.getElementById('hid_adr').value+'<br>'+document.getElementById('autocompletes').innerHTML;
//	fill_hid_adr();
	refreshlist();
}
function saveRep(a)
{	//hid_build_id=document.getElementById('hid_build_id').value;
	//hid_asoc_id=document.getElementById('hid_asoc_id').value;
	//build_identify1=document.getElementById('build_identifyh').value;
	name=document.getElementById('name').value;
	address=document.getElementById('address').value;
	phone=document.getElementById('phone').value;
	email=document.getElementById('email').value;
	type=document.getElementById('type').value;
	asoc_id=document.getElementById('hid_asoc_id').value;
	people_id=document.getElementById('persons').value;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=save_rep&save_redact='+a+'&name='+name+'&address='+address+'&phone='+phone+'&email='+email+
			'&type='+type+'&asoc_id='+asoc_id+'&people_id='+people_id, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
						alert(ajax.responseText);
						refreshlist();
						FORM_CHANGEp = false;
						document.getElementById('name').value='';
						document.getElementById('address').value='';
						document.getElementById('phone').value='';
						document.getElementById('email').value='';
						document.getElementById('cureditp').disabled=true;
						document.getElementById('curdelp').disabled=true;
					//document.getElementById('sql').innerHTML=ajax.responseText;
				}
			}
		ajax.send(null);
}
function ifpeople()
{	var people_id=document.getElementById('persons').value;
	var ajax = new XMLHttpRequest();
	ajax.open('get', 'ajaxResults.php?file=register&what=ifpeople&people_id='+people_id, true);
		ajax.onreadystatechange = function(){
			if((ajax.readyState == 4) && (ajax.status == 200)){
				var first=ajax.responseText.substr(0,1);
				var realresponse=ajax.responseText.substr(1,ajax.responseText.length-1);
				if (first=='0')
				{	//alert('ifpeople-0');
					document.forms['represents'].reset();
					getOverIt();
					document.getElementById('cureditp').disabled=true;
					document.getElementById('curdelp').disabled=true;
					FORM_CHANGEp=false;
				}
				if (first=='1')
				{	//alert('ifpeople-1');
					document.getElementById('cureditp').disabled=false;
					document.getElementById('curdelp').disabled=false;
					var peopledata=realresponse.split('~');
					document.getElementById('name').value=peopledata[1];
					document.getElementById('address').value=peopledata[2];
					document.getElementById('phone').value=peopledata[3];
					document.getElementById('email').value=peopledata[4];
					document.getElementById('type').value=peopledata[5];
					FORM_CHANGEp=false;
				}
			}
		}
	ajax.send(null);
}
function refreshlist()
{	//alert('refreshlist');
	asoc_id=document.getElementById('hid_asoc_id').value;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=refresh_list&asoc_id='+asoc_id, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					document.getElementById('personstd').innerHTML=ajax.responseText;
					document.getElementById('cureditp').disabled=true;
					document.getElementById('curdelp').disabled=true;
				}
			}
		ajax.send(null);
}
function refresh_rq_co()
{	//alert('refresh_rq_co');
	document.getElementById('request_container').className="";
	var asoc_id=document.getElementById('hid_asoc_id').value;
	var build_id=document.getElementById('hid_build_id').value;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=refresh_rq_co&asoc_id='+asoc_id+'&build_id='+build_id, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					var first=ajax.responseText.substr(0,1);
					var realresponse=ajax.responseText.substr(1,ajax.responseText.length-1);
					var spisyk=realresponse.split('$');
					//alert(first);
					//alert(realresponse);
					document.getElementById('rq_co_table').innerHTML=spisyk[0];
					document.getElementById('asoc_list').innerHTML=spisyk[1];
				}
			}
		ajax.send(null);
}
function petko()
{	//alert('petko');
	asoc_id=document.getElementById('hid_asoc_id').value;
	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=attaching&asoc_id='+asoc_id, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					var first=ajax.responseText.substr(0,14);
					var last=ajax.responseText.substr(14,ajax.responseText.length-1);
					if (first=="Успешен запис!")
					{	document.getElementById('attached').value=last;
						alert(first);
					}else
					{	alert(ajax.responseText);
					}
				}
			}
		ajax.send(null);
}
function save_rq(save_up)
{	var asoc_id=document.getElementById('hid_asoc_id').value;
	var build_id=document.getElementById('hid_build_id').value;
	var doc_status=document.getElementById('doc_status').value;
	var rq_numb=document.getElementById('rq_numb').value;
	var theirs_date=document.getElementById('theirs_date').value;
	if (document.getElementById('theirs2_date')!=null)
	{	var theirs2_date=document.getElementById('theirs2_date').value;
	}if (document.getElementById('doc_hid_id')!=null)
	{	var doc_hid_id=document.getElementById('doc_hid_id').value;
	}else
	{	var doc_hid_id=''}
	var description=document.getElementById('description').value;
	var what_att=document.getElementById('what_att').value;
	var broq4=0;
	var str="";
	var str2="";
	for (broq4=1;broq4<10;broq4++)
	{	if (document.getElementById('ch'+broq4)!=null)
		{	if (document.getElementById('ch'+broq4).checked==true)
			{	str+=document.getElementById('ch'+broq4).value;
				str+=',';
			}else
			{	str2+=document.getElementById('ch'+broq4).value;
				str2+=',';
			}
		}
	}if (str.substr(str.length-1,1)==',')
	{	str=str.substr(0,str.length-1);
	}if (str2.substr(str2.length-1,1)==',')
	{	str2=str2.substr(0,str2.length-1);
	}//alert(str+'---'+str2);
	if (what_att=='5')
	{	if (str=='')
		{	alert('Не сте отбелязали към кое сдружение е заявлението!')
			return false;
		}
	}if (document.getElementById('doc_type')!=null)
	{	var doc_type=document.getElementById('doc_type').value;
	}
	if (asoc_id=='')
	{	alert('Моля изберете/ въведете сдружение първо!')
	}else
	{	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=rq_save&asoc_id='+asoc_id+'&build_id='+build_id+'&doc_status='+doc_status+'&rq_numb='+rq_numb+'&theirs_date='+theirs_date+'&theirs2_date='+theirs2_date+'&description='+description+'&what_att='+what_att+'&save_up='+save_up+'&doc_hid_id='+doc_hid_id+'&doc_type='+doc_type+'&str='+str+'&str2='+str2, false);
			ajax.onreadystatechange = function(){
				if((ajax.readyState == 4) && (ajax.status == 200)){
					alert(ajax.responseText);
					refresh_rq_co();
					if (save_up=='save')
					{	if (what_att=='5')
						{	document.getElementById('contr_zaqv').className="hide";
							document.getElementById('save_rq_button').disabled=true;
						}else
						{	if (what_att=='50')
							{
							}
						}
					}
				}
			}
		ajax.send(null);
	}
}
function ifvalid_date(elementid)
{	var date_patt = /^[0-9]{2}-[0-9]{2}-[0-9]{4}$/;
	if(date_patt.test(document.getElementById(elementid).value) == true)
	{	return true;
	}else
	{	alert('Въведете коректна дата на заявление/договор!');
		document.getElementById(elementid).focus();
		return false;
	}
}
/* ********************************************************************** */
function validateForm(formName, btnName)
{	switch(formName)
	{	case "rq_form":
			if	(btnName == 'vtori')
			{	var parts=document.getElementById('manyrc').value.split('@');
				var nomen=parts[5];
				var save_up='up';
			}else
			{	var nomen=document.getElementById('what_att').value;
				var save_up='save';
			}
			if (document.forms.rq_form.rq_numb.value == '')
			{	if (nomen=='5')
				{	alert('Моля въведете номер на заявлението!');
				}else
				{	if (nomen=='50')
					{	alert('Моля въведете номер на договора!');
					}
				}
				document.forms.rq_form.rq_numb.focus();
				return false;
			}else{
			}
			
			if (ifvalid_date('theirs_date')){
			}else{
				return false;
			}
			
			if(document.forms.rq_form.doc_status.value == ''){
				if(nomen=='5'){
					alert('Изберете статус на заявлението!');
					return false;
				}else{
					if(nomen=='50'){
						alert('Изберете статус на договора!');
						return false;
					}
				}
			}else{
			}
			
			if(document.forms.rq_form.doc_type == ''){
				if(nomen=='50'){
					alert('Изберете вид на договора!');
					return false;
				}
			}else{
			}
				save_rq(save_up);
			break;
		case "build_form":
			var kad_pattern = /^[0-9]{5}\.[0-9]{3}\.[0-9]{3}\.[0-9]{1,}$/;// s kadastralna karta
			var not_kad_pattern = /^[0-9]{2}\.[0-9]{1,}$/g;// bez kadastralna karta
			if (document.forms.build_form.build_identifyh.value == '')
			{	alert('Въведете Идентификатор на сграда');
				document.forms.build_form.build_identifyh.focus();
				return false;
			}else
			{	if(kad_pattern.test(document.forms.build_form.build_identifyh.value) == true)
				{
				}else
				{	if(not_kad_pattern.test(document.forms.build_form.build_identifyh.value) == true)
					{	var raionpart=parseInt(document.getElementById('build_identifyh').value.substr(0,2));
						var raionreal=document.getElementById('raion_sel').value;
						if (raionpart!=raionreal)
						{	alert('Въведения идентификатор не съответства на района ви!');
							document.forms.build_form.build_identifyh.focus();
							return false;
						}
					}else
					{	alert('Въведете коректен идентификатор на сграда');
						document.forms.build_form.build_identifyh.focus();
						return false;
					}
				}
			}var selRaion = document.forms.build_form.raion_sel.value;
			if(selRaion == '')
			{	alert('Изберете район');
				return false;
			}else
			{
			}var selNasel = document.forms.build_form.nasel_sel.value;
			if(selNasel == '')
			{	alert('Изберете населено място!');
				return false;
			}
			var kvarta=document.getElementById('hood_sel').value;
			var jk=document.getElementById('jk_sel').value;
			var str_search=document.getElementById('str_search').value;						
			if ((kvarta!='')||(jk!='')||(str_search!=''))
			{	var str_nom=document.getElementById('str_nom').value;
				var build_numb=document.getElementById('build_numb').value;
				if ((str_nom=='')&&(build_numb==''))
				{	alert('Въвели сте квартал, ж.к. или улица следователно трябва да въведете и номер на улица или блок!');
					return false;
				}
			}else
			{	alert('Въвеждането на данни в поне едно от полетата "Ж.к.","Квартал" или "Улица" е задължително!');
				return false;
			}
			if(btnName == 'save_build'){save_build(1);}
			if(btnName == 'curedit'){save_build(2);}
					break;
		case "asoc_form":
			var sdruj_patt = /^[0-9]{2}-[0-9]{1,}$/;
			var date_patt = /^[0-9]{2}-[0-9]{2}-[0-9]{4}$/;
			
				if(document.forms.asoc_form.asoc_numbh.value == ''){
					alert('Моля, въведете регистрационен номер на сграда!');
						document.forms.asoc_form.asoc_numbh.focus();
							return false;
				}else{
					if(sdruj_patt.test(document.forms.asoc_form.asoc_numbh.value) == true){
					}else{
						alert('Въведете коректен регистрационен номер на сдружение!');
						document.forms.asoc_form.asoc_numbh.focus();
						return false;
					}
				}
				if(document.forms.asoc_form.bulstath.value != '')
				{	if (document.forms.asoc_form.bulstath.value.length<9)
					{	alert('Броя символи на булстат не е достатъчен!');
						document.forms.asoc_form.bulstath.focus();
						return false;
					}else
					{	if (VerifyBulstat(document.forms.asoc_form.bulstath.value)==false)
						{	document.forms.asoc_form.bulstath.focus();
							return false;
						}
					}
				}else
				{
				}
				if(document.forms.asoc_form.date_of_create.value != ''){
					if(date_patt.test(document.forms.asoc_form.date_of_create.value) == true){
					}else{
						alert('Въведете коректна дата на учредяване!');
							document.forms.asoc_form.date_of_create.focus();
								return false;
					}
				}else{
					alert('Въведете дата на учредяване!');
					document.forms.asoc_form.date_of_create.focus();
					return false;
				}				
				if(document.forms.asoc_form.date_of_entry.value != ''){
					if(date_patt.test(document.forms.asoc_form.date_of_entry.value) == true){
					}else{
						alert('Въведете коректна дата на вписване!');
							document.forms.asoc_form.date_of_entry.focus();
								return false;
					}
				}else{
					alert('Въведете дата на вписване!');
					document.forms.asoc_form.date_of_entry.focus();
					return false;
				}				
				if(document.forms.asoc_form.srok.value == ''){
					alert('Изберете срок на учредяване!');
					return false;
				}else{
				}
				if(document.forms.asoc_form.asoc_name.value == ''){
					alert('Въведете наименование на сдружението!');
					document.forms.asoc_form.asoc_name.focus();
					return false;
				}else{
				}
				if(document.forms.asoc_form.entries.value == ''){
					alert('Въведете вход/ове!');
					document.forms.asoc_form.entries.focus();
					return false;
				}else{
				}
				if(document.forms.asoc_form.asoc_ideal_parts.value == ''){
					alert('Въведете идеални части в %!');
					document.forms.asoc_form.asoc_ideal_parts.focus();
					return false;
				}else{
				}				
				if(document.forms.asoc_form.predst.value == ''){
					alert('Въведете начин на представителство!');
					return false;
				}else{
				}				
				if(document.forms.asoc_form.predmet.value == ''){
					alert('Въведете предмет на дейност!');
					return false;					
				}else{
				}				
				
				if(btnName == 'save_asoca'){save_asoc(1);} 
				if(btnName == 'curedita'){save_asoc(2);}
			break;
		case "represents": 
			if(document.forms.represents.name.value == ''){
				alert('Въведете име!');
					document.forms.represents.name.focus();
						return false;
			}
			if(document.forms.represents.address.value == ''){
				alert('Въведете адрес!');
					document.forms.represents.address.focus();
						return false;
			}else{
			}
			if(document.forms.represents.phone.value !== ''){
				if(isNaN(document.forms.represents.phone.value) === false){
				}else{
					alert('Въведете коректен телефонен номер!');
					document.forms.represents.phone.value = '';
					document.forms.represents.phone.focus();
					return false;
				}
			}
			
			if(document.forms.represents.email.value !== ''){
				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
					if(re.test(document.forms.represents.email.value) == true){
					}else{
						alert('Въведете коректен Е-майл!');
							document.forms.represents.email.focus();
								return false;
					}
			}else{
			}
			
			
			if(btnName == 'saveRepresentator')
			{	
				if (document.getElementById('hid_asoc_id').value == '')
				{	alert('Не може! Но може да си запишете някое сдружение ако искате!');
					//alert('Не може да записвате представител на сдружение в базата данни, ако самото сдружение все още не е записано в базата данни, защото ако запишем потребителя към текущо въведения вече регистрационен номер във формата на сдружението по горе, и ако след като запишете този представител, забележите, че сте допуснали грешка и си поправите регистрационния номер на сдружение, и тогава запишете сдружението, записания представител, няма да принадлежи към това сдружение с верния номер, а ще принадлежи към онова с грешката, което така и никога не сте записвали в базата, т.е. представителя ще е към несъществуващо сдружение, така че първо си запишете сдружението! Послепис: Това положение е така, защото представителите на сдружението не са една данна, а даже не се знае колко елелемнта от тип представители ще запишете към това сдружение, те не са данна от сдружението, която или я има или я няма, както са останалите данни на сдружението, те са множество от тип данна(представител)!');
				}
				else
				{	saveRep(1);
				}
			} 
			if(btnName == 'cureditp'){saveRep(2);}
				break;
	}
}
function getwoman(nomen,target)
{	//alert('getwoman');
	if (nomen.length>3)
	{	var parts=nomen.split('@');
		document.getElementById('doc_hid_id').value=parts[0];
		document.getElementById('rq_numb').value=parts[1];
		document.getElementById('theirs_date').value=parts[2];
		selected_status=parts[3];
		document.getElementById('description').value=parts[4];
		nom_code=parts[5];
		if (parts[6]!=null)
		{	var theirs2_date=parts[6];
		}else
		{	var theirs2_date='';
		}
		if (nom_code<10)
		{	nom_code='0'+nom_code;
		}if (parts[7]!=null)
		{	var selected_doc_type=parts[7];
		}else
		{	var selected_doc_type='';
		}
	}else
	{	var theirs2_date='';
		selected_status='';
		if (nomen<10)
		{	nom_code='0'+nomen;
		}else
		{	nom_code=nomen;
		}
	}
	if ((nom_code=='50')||(nom_code=='05')||(nom_code=='55'))
	{	document.getElementById('contr_zaqv').className="";
		if (nom_code=='05')
		{	document.getElementById('asoc_list').className="";
		}else
		{	document.getElementById('asoc_list').className="hide";
		}
		var asoc_id=document.getElementById('hid_asoc_id').value;
		var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=getnomen&nom_code='+nom_code+'&asoc_id='+asoc_id+'&selected_status='+selected_status+'&selected_doc_type='+selected_doc_type, false);
		ajax.onreadystatechange = function(){
			if(ajax.readyState == 4 && ajax.status == 200){
				if (nom_code=='05')
				{	var first=ajax.responseText.substr(0,4);
					if (first=="Вече")
					{	document.getElementById('contr_zaqv').className="hide";
						alert(ajax.responseText+" Изберете друга опция!");
						document.getElementById('save_rq_button').disabled=true;
						document.getElementById('asoc_list').className="hide";
					}else
					{	document.getElementById('reg_date').innerHTML="Дата на подаване:<span class='red'>*</span>";
						document.getElementById(target+'_name').innerHTML = "Статус:<span class='red'>*</span>";
						document.getElementById(target).innerHTML = ajax.responseText;
						rq_status_efect();
						document.getElementById('type_section').className="hide";
						document.getElementById('type_section_name').className="hide";
					}
				}else
					if (nom_code=='50')
					{	document.getElementById('reg_date').innerHTML="Дата на сключване:<span class='red'>*</span>";
						document.getElementById(target+'_name').innerHTML = "Статус:<span class='red'>*</span>";
						var selects=ajax.responseText.split('@');
						document.getElementById(target).innerHTML = selects[0];
						doc_status_efect();
						document.getElementById('type_section').className="";
						document.getElementById('type_section_name').className="";
						document.getElementById('type_section').innerHTML=selects[1];
						document.getElementById('type_section_name').innerHTML="Вид договор:<span class='red'>*</span>";
					}else
						if (nom_code=='55')
						{	document.getElementById('reg_date').innerHTML='Дата на подаване:';
							document.getElementById('acc_rej_date').innerHTML='';
							document.getElementById(target+'_name').innerHTML = 'Вид_документ:';
							document.getElementById(target).innerHTML = ajax.responseText;
							document.getElementById('type_section').className="hide";
							document.getElementById('type_section_name').className="hide";
						}
			}
		}
		ajax.send(null);
	}else
	{	if (selected_status=='')
		{	document.getElementById('save_rq_button').disabled=true;
			document.getElementById('contr_zaqv').className="hide";
			document.getElementById('asoc_list').className="hide";
			return false;
		}else
		{	document.getElementById('save_rq_button2').disabled=true;
			return false;
			
		}
	}
}
function doc_status_efect()
{	//alert('doc_status_efect');
	var theirs2_date='';
	if (document.getElementById('doc_status').value==3)
	{	//alert('doc_status_efect3');
		document.getElementById('acc_rej_date').innerHTML=
			'Дата на прекратяване:<input type="text" name="theirs2_date" maxlength="10" style="width:73px;" value="'+theirs2_date+'" id="theirs2_date"/>';
	}else
	{	if (document.getElementById('doc_status').value==2)
		{	//alert('doc_status_efect2');
			document.getElementById('acc_rej_date').innerHTML=
				'Дата на изпълнение:<input type="text" name="theirs2_date" maxlength="10" style="width:73px;" value="'+theirs2_date+'" id="theirs2_date"/>';
		}else
		{	//alert('doc_status_efectelse');
			document.getElementById('acc_rej_date').innerHTML="";
		}
	}
}function rq_status_efect()
{	//alert('rq_status_efect');
	var theirs2_date='';
	if (document.getElementById('doc_status').value==3)
	{	//alert('rq_status_efect3');
		document.getElementById('acc_rej_date').innerHTML=
			'Дата на отхвърляне:<input type="text" name="theirs2_date" maxlength="10" style="width:73px;" value="'+theirs2_date+'" id="theirs2_date"/>';
	}else
	{	if (document.getElementById('doc_status').value==2)
		{	//alert('rq_status_efect2');
			document.getElementById('acc_rej_date').innerHTML=
				'Дата на одобрение:<input type="text" name="theirs2_date" maxlength="10" style="width:73px;" value="'+theirs2_date+'" id="theirs2_date"/>';
		}else
		{	//alert('rq_status_efectelse');
			document.getElementById('acc_rej_date').innerHTML="";
		}
	}
}
/* **************************************************************************************************** */
function generateDocuments(id){
	//alert('generateDocuments');
	var sdr_num = document.getElementById('hid_asoc_id').value;
	if(sdr_num == '')
	{	alert('Моля изберете/ въведете сдружение първо!');
		return false;
	}else{
		if(id == 11){
			window.open('print.php?id='+ id + '&as_id=' + sdr_num, '_blank', 'width=800, height=600, left=200, top=50, scrollbars=yes').print();
		}
		if(id == 12){
			window.open('print.php?id='+ id + '&as_id=' + sdr_num, '_blank', 'width=800, height=600, left=200, top=50, scrollbars=yes').print();
		}
		if(id == 13){
			window.open('print.php?id='+ id + '&as_id=' + sdr_num, '_blank', 'width=800, height=600, left=200, top=50, scrollbars=yes').print();
		}
	}
}
function delete_build()
{	var build_id=document.getElementById('hid_build_id').value;
	if(build_id == '')
	{	alert('Моля изберете/ въведете сграда първо!');
		return false;
	}else
	{	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=delete_build&build_id='+build_id, false);
		ajax.onreadystatechange = function(){
			if(ajax.readyState == 4 && ajax.status == 200){
				alert("Успешно изтриване!")
				window.location.reload();
			}
		}
		ajax.send(null);
	}
}function delete_asoc()
{	var asoc_id=document.getElementById('hid_asoc_id').value;
	if(asoc_id == '')
	{	alert('Моля изберете/ въведете сдружение първо!');
		return false;
	}else
	{	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=delete_asoc&asoc_id='+asoc_id, false);
		ajax.onreadystatechange = function(){
			if(ajax.readyState == 4 && ajax.status == 200){
				alert("Успешно изтриване!");
				document.forms['asoc_form'].reset();
				document.forms['represents'].reset();
				document.forms['rq_form'].reset();
				document.getElementById('contr_zaqv').className='hide';
				document.getElementById('asoc_ident_rn').value='';
				document.getElementById('asoc_ident_b').value='';
				ifbuild('like');
				ifasoc('like');
				getOverIt();
			}
		}
		ajax.send(null);
	}
}function delete_person()
{	var person_id=document.getElementById('persons').value;
	if(person_id == '')
	{	alert('Моля изберете/ въведете член първо!');
		return false;
	}else
	{	var ajax = new XMLHttpRequest();
		ajax.open('get', 'ajaxResults.php?file=register&what=delete_person&person_id='+person_id, false);
		ajax.onreadystatechange = function(){
			if(ajax.readyState == 4 && ajax.status == 200){
				alert("Успешно изтриване!")
				refreshlist();
				document.forms['represents'].reset();
				getOverIt();
				document.getElementById('curdelp').disabled=true;
			}
		}
		ajax.send(null);
	}
}