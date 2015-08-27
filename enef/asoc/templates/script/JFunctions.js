

function ChangeSize()
{
 type_identity=document.getElementById("type_identity");
 //alert(type_identity.value);
 if (type_identity.value==0)
 	{
 	if (document.getElementById('varegn').value !='') document.getElementById('egn').value=document.getElementById('egn').value; 
 	else document.getElementById('egn').value='';
	//document.getElementById('egn').setAttribute('maxLength','10');
	document.getElementById('egn').maxLength = 10;
//	document.getElementById('egn').readonly = false;
//	document.getElementById('egn').setAttribute("readonly","false");
	document.getElementById('type_identity_selected').value=0;
 	}
	else
	{
	//document.getElementById('egn').setAttribute('maxLength','12');
	document.getElementById('egn').maxLength = 12;
	//document.getElementById('egn').setAttribute("readonly","true");
	document.getElementById('type_identity_selected').value=1;
	get_prefix("get_prefix.php"); 
	document.getElementById('egn').readonly = true;
	//document.getElementById('egn').value='';
	}
	//document.getElementById('egn').value='';
}


var http_request = false;
function makePOSTRequest(url, parameters) {
    var params = parameters
    
	http_request = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			// set type accordingly to anticipated content type
			http_request.overrideMimeType('text/html');
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!http_request) {
		alert('Cannot create XMLHTTP instance');
		return false;
	}
	//alert(params);
	http_request.onreadystatechange = alertContents;
	
	http_request.open('POST', encodeURIComponent(url), true);
	http_request.setRequestHeader("Content-Type", "application/x-www-form-URLencoded");
	//http_request.setRequestHeader("Content-Type", "text/xml; charset=windows-1251");   
    http_request.setRequestHeader("Content-length", params.length);
	http_request.setRequestHeader("Connection", "close");
	http_request.send(params);
}

function alertContents() {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			result = http_request.responseText;
			//alert(result);
			document.getElementById("egn").value = result;
			//alert(document.getElementById("egn").value)
		} else {
			alert('There was a problem with the request.');
		}
	}
}

function get_prefix(scr) {

	var queryString = ""
	var type_identity=document.getElementById("type_identity");
	var egn=document.getElementById("egn").value;
	var varegn=document.getElementById("varegn").value;
	var varname=document.getElementById("name").value;
	//alert(document.getElementById("varegn").value);
	if (type_identity.value==1){
		queryString += "&";
		queryString +="type_identity="+encodeURI(type_identity.value);
		queryString += "&";
		queryString +="egn="+encodeURI(egn);
	}
		if (varegn!='')
		{
		queryString += "&";
		queryString +="varegn="+encodeURI(varegn);
		}
		if (varname!=0)
		{
	    queryString += "&";
		queryString +="varname="+encodeURI(varname);
		}
	
	makePOSTRequest(scr, queryString);
	}



function OpenWindow(url, title, width, height) {
  var screen_width = screen.width;
  var screen_height = screen.height;

  var left = Math.ceil((screen_width - width) / 2);
  var top = Math.ceil((screen_height - height) / 2);

  window.open(url, title, 'left=' + left + ', top=' + top + ', width=' + width + ', height=' + height + ' + ');
}

var previous_element = '';

function LmOverOut(form, element, id, color1, color2) {
  if (document.forms[form].data.value != id) {
    element.style.backgroundColor = color1;
  }
  else {
    element.style.backgroundColor = color2;
  }
}

function LmDown(form, value, element, cookie_flag) {
  if (previous_element) {
    previous_element.style.backgroundColor = '';
  }
  previous_element = element;

  document.forms[form].data.value = value;

  if (cookie_flag) {
    document.cookie = "subcontr_id=" + value;
  }
}

function ConfirmAction(message) {
  if (confirm(message)) {
    return true;
  }
  else {
    return false;
  }
}

function Split2Str(flag, str) {
  var result = str.split("|");

  switch (flag) {
    case 0: return result[0]; break;
    case 1: return result[1]; break;
  }
}

function ValidateKeyChar(object, special1, special2, special3) {
  if (!((window.event.keyCode >= 65  && window.event.keyCode <= 90) ||
        (window.event.keyCode >= 97  && window.event.keyCode <= 122) ||
        (window.event.keyCode >= 1040  && window.event.keyCode <= 1103) ||
        (window.event.keyCode == 32) || (window.event.keyCode == special1) ||
        (window.event.keyCode == special2) || (window.event.keyCode == special3))) {
    window.event.keyCode = 0;
    object.focus();
  }
}

function ValidateKeyNumb(object, special1, special2, special3) {
  if (!((window.event.keyCode >= 48  && window.event.keyCode <= 57) ||
        (window.event.keyCode == special1) || (window.event.keyCode == special2) || (window.event.keyCode == special3))) {
    window.event.keyCode = 0;
    object.focus();
  }
}

function ValidateKeyCharNumb(object, special1, special2, special3, special4, special5) {
  if (!((window.event.keyCode >= 65  && window.event.keyCode <= 90) ||
        (window.event.keyCode >= 97  && window.event.keyCode <= 122) ||
        (window.event.keyCode >= 1040  && window.event.keyCode <= 1103) ||
        (window.event.keyCode == 32) ||
        (window.event.keyCode >= 48  && window.event.keyCode <= 57) ||
        (window.event.keyCode == special1) || (window.event.keyCode == special2) ||
        (window.event.keyCode == special3) || (window.event.keyCode == special4) ||
                (window.event.keyCode == special5))) {
    window.event.keyCode = 0;
    object.focus();
  }
}

function VerifyForBlank(form, element, message) {
  if (document.forms[form].elements[element].value == "") {
    alert(message);
    document.forms[form].elements[element].focus();
    return false;
  }
  return true;
}

function VerifyForLength(form, element, message, delta_length) {
  if (document.forms[form].elements[element].value.length < (document.forms[form].elements[element].maxLength - delta_length)) {
    alert(message);
    document.forms[form].elements[element].focus();
    return false;
  }
  return true;
}

function VerifyEGN(egn) {
  var koef = "020408051009070306";
  var i = 0;

        if(egn.substr(0,10) == '0000000000')
        {
                return false;
        }

  for (j = 0; j < egn.length - 1; j++)
    i += (egn.substr(j, 1) - '0') * ((koef.substr(j * 2, 1) - '0') * 10 + (koef.substr(j * 2 + 1, 1) - '0'));
  i %= 11;
  i %= 10;
  if (i != (egn.substr(9, 1) - '0')) {
    //alert("Въведеното ЕГН е невалидно!");
    return false;
  }
  return true;
}

function VerifyPNF(pnf)
{
        var koef = "211917131109070301";
        var i = 0;

        if(pnf.length == 0 || pnf.substr(0,10) == '0000000000')
        {
                alert("Въведеното ЕГН/ЛНЧ е невалидно!");
                return false;
        }
        for (j = 0; j < pnf.length - 1; j++)
                i += (pnf.substr(j, 1) - '0') * ((koef.substr(j * 2, 1) - '0') * 10 + (koef.substr(j * 2 + 1, 1) - '0'));
        i %= 10;
        i %= 10;
        if (i != (pnf.substr(9, 1) - '0'))
        {
                alert("Въведеното ЕГН/ЛНЧ е невалидно!");
                return false;
        }
        return true;
}


function VerifyRateNumber(RateNumber) {
  var pNx, pNy, pNz;
  var pNb = "";

  var Tf = new Array();

  Tf[0] = 4;
  Tf[1] = 3;
  Tf[2] = 2;
  Tf[3] = 7;
  Tf[4] = 6;
  Tf[5] = 5;
  Tf[6] = 4;
  Tf[7] = 3;
  Tf[8] = 2;

  pNx = 0;
  pNy = 0;
  pNz = 0;

  do {
    pNb = RateNumber.substr(pNz, 1);

    if ((parseInt(pNb) < 0) || (parseInt(pNb) > 9)) {
      alert("Въведеният данъчен номер е невалиден!");
      return false;
    }

    pNx = parseInt(pNb);

    if (pNz < 9) {
      pNy = pNy + pNx * Tf[pNz];
    }

    pNz = pNz + 1;

  } while (pNz < 10);
  pNy = pNy % 11;
  pNy = 11 - pNy;
  if (pNy == 11) {
    pNy = 0;
  }
  if (pNx != pNy) {
    alert("Въведеният данъчен номер е невалиден!");
    return false;
  }
  else {
    return true;
  }
}

function VerifyBulstat(pBulstat) {
  var arKod = new Array();

  arKod[0] = new Array();
  arKod[0][0] = 1;
  arKod[0][1] = 3;
  arKod[1] = new Array();
  arKod[1][0] = 2;
  arKod[1][1] = 4;
  arKod[2] = new Array();
  arKod[2][0] = 3;
  arKod[2][1] = 5;
  arKod[3] = new Array();
  arKod[3][0] = 4;
  arKod[3][1] = 6;
  arKod[4] = new Array();
  arKod[4][0] = 5;
  arKod[4][1] = 7;
  arKod[5] = new Array();
  arKod[5][0] = 6;
  arKod[5][1] = 8;
  arKod[6] = new Array();
  arKod[6][0] = 7;
  arKod[6][1] = 9;
  arKod[7] = new Array();
  arKod[7][0] = 8;
  arKod[7][1] = 10;
  arKod[8] = new Array();
  arKod[8][0] = 2;
  arKod[8][1] = 4;
  arKod[9] = new Array();
  arKod[9][0] = 7;
  arKod[9][1] = 9;
  arKod[10] = new Array();
  arKod[10][0] = 3;
  arKod[10][1] = 5;
  arKod[11] = new Array();
  arKod[11][0] = 5;
  arKod[11][1] = 7;

  var nConsum = 0;

  for (i = 0; i < 8; i++) {
    nConsum += (arKod[i][0] * parseInt(pBulstat.substr(i, 1)))
  }

  if ((nConsum % 11) == 10) {
    nConsum = 0;
    for (i = 0; i < 8; i++) {
      nConsum += (arKod[i][1] * parseInt(pBulstat.substr(i, 1)))
    }

    if ((nConsum % 11) == 10) {
      nConsum = 0;
    }
  }

  var temp = (nConsum % 11).toString();
  var result;

  if (pBulstat.length == 9) {
    result = (temp.substr(0, 1) == pBulstat.substr(pBulstat.length - 1, 1));

    if (!result) alert("Въведеният булстат е невалиден!");

    return result;
  }
  else if (temp.substr(0, 1) == pBulstat.substr(8, 1)) {
    nConsum = 0;
    for (i = 8; i < pBulstat.length - 1; i++) {
      nConsum += (arKod[i][0] * parseInt(pBulstat.substr(i, 1)))
    }

    temp = (nConsum % 11).toString();
    if ((nConsum % 11) == 10) {
      nConsum = 0;
      for (i = 8; i < pBulstat.length - 1; i++) {
        nConsum += (arKod[i][1] * parseInt(pBulstat.substr(i, 1)))
      }
    }
    result = (temp.substr(0, 1) == pBulstat.substr(pBulstat.length - 1, 1));

    if (!result) alert("Въведеният булстат е невалиден!");

    return result;
  }
  else {
    alert("Въведеният булстат е невалиден!");
    return false;
  }
}

function VerifyDate(form, element, message) {
  var str_date = document.forms[form].elements[element].value.split("-");
  var result = true;

  if ((str_date[0].length < 2) || (str_date[0].length > 2)) {
    result = false;
  } else if ((str_date[1].length < 2) || (str_date[1].length > 2)) {
    result = false;
  } else if (str_date[2].length < 4) {
    result = false;
  }

  var days_in_month = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

  if (parseInt(str_date[1]) == 2) {
    a = Math.floor(parseInt(str_date[2]) - 100 * Math.floor(parseInt(str_date[2]) / 100));
    b = Math.floor(parseInt(str_date[2]) - 4 * Math.floor(parseInt(str_date[2]) / 4));
    c = Math.floor(parseInt(str_date[2]) - 400 * Math.floor(parseInt(str_date[2]) / 400));

    if (b == 0) {
      if (!(a == 0 && c != 0)) days_in_month[1] = 29;
    }
  }

  if ((str_date[1] < '01') || (str_date[1] > '12')) result = false;
  if ((str_date[0] < '01') || (parseInt(str_date[0]) > days_in_month[parseInt(str_date[1]) - 1])) result = false;
  if ((str_date[2] < '1900') || (str_date[2] > '3000')) result = false;

  if (result == false) {
    alert(message);
    document.forms[form].elements[element].focus();
  }

  return result;
}

function VerifyGratisPeriod(form, message) {
  var date1 = document.forms[form].elements['gratis_period'].value;
  var date2 = document.forms[form].elements['first_date'].value;

  var d1, m1, y1, d2, m2, y2;
  var result = false;

  d1 = date1.substr(0, 2);
  m1 = date1.substr(3, 2);
  y1 = date1.substr(6, 4);

  d2 = date2.substr(0, 2);
  m2 = date2.substr(3, 2);
  y2 = date2.substr(6, 4);

  if (y1 > y2) {
    result = true;
  } else if (y1 == y2) {
    if (m1 > m2) {
      result = true;
    } else if (m1 == m2) {
      if (d1 >= d2) {
        result = true;
      }
    }
  }

  if (result == false) {
    alert(message);
    document.forms[form].elements['gratis_period'].focus();
  }

  return result;
}

function UpdateFinalDate(form, first_date, period, limit) {
  var days_in_month = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

  if (first_date != '') {
    var day = parseInt(first_date.substr(0, 2), 10);
    var month = parseInt(first_date.substr(3, 2), 10);
    var year = parseInt(first_date.substr(6, 4));

    switch (parseInt(limit)) {
      case 1: year += parseInt(period); break;
      case 2:
        month += parseInt(period);
        while (parseInt(month) > 12) {
          year += 1;
          month -= 12;
        }
      break;
      case 3:
        document.forms[form].period.value = "0";
        document.forms[form].final_date.value = "";
      break;
    }

    if (parseInt(limit) != 3) {
      if ((period != "") && (limit != "")) {
        day = parseInt(day) - 1;
        if (parseInt(day) == 0) {
          month--;
          if (month < 1) {
            month += 12;
            year--;
          }
          day = days_in_month[month - 1];
        }

        if (parseInt(month) == 2) {
          a = Math.floor(parseInt(year) - 100 * Math.floor(parseInt(year) / 100));
          b = Math.floor(parseInt(year) - 4 * Math.floor(parseInt(year) / 4));
          c = Math.floor(parseInt(year) - 400 * Math.floor(parseInt(year) / 400));

          if (b == 0) {
            if (!(a == 0 && c != 0)) day++;
          }
        }

        if (parseInt(day) < 10) day = "0" + day;
        if (parseInt(month) < 10) month = "0" + month;

        document.forms[form].final_date.value = day + "-" + month + "-" + year;
      }
      else {
        document.forms[form].final_date.value = "";
      }
    }
  } else {
    document.forms[form].final_date.value = "";
  }
}

function Round(number, x) {
  x = (!x ? 2 : x);

  return Math.round(number * Math.pow(10, x)) / Math.pow(10, x);
}

function CalcRent(form, element, total_area, area1, area2, rent_area) {
  var result1, result2;

  var result = rent_area.split("/");

  if (total_area != "0.00") {
    temp_area1 = total_area;
    temp_area2 = total_area;
  } else {
    temp_area1 = area1;
    temp_area2 = area2;
  }

  if (result[0] || result[1]) {
    if (result[0] && !result[1]) {
      result1 = Round(temp_area1 * result[0], 2);
      result2 = Round(temp_area2 * result[0], 2);
    } else {
      result1 = Round(temp_area1 * result[0], 2);
      result2 = Round(temp_area2 * result[1], 2);
    }
  } else {
    result1 = temp_area1;
    result2 = temp_area2;
  }

  if (result1 == result2) {
    document.forms[form].elements[element].value = result1;
  } else {
    document.forms[form].elements[element].value = result1 + " / " + result2;
  }
}

function CalcFinalBalance(form, month_pays, month_debt, interest, forfeit) {
  var sum;

  sum = (parseFloat(month_pays) - (parseFloat(month_debt) + parseFloat(interest) + parseFloat(forfeit)));

  document.forms[form].final_balance.value = Round(sum, 2);
}

function CalcPeriod(form, period_from, period_to) {
  var days_in_month = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

  if (period_from != "") {
    date = period_from.split("-");

    day = parseInt(date[0], 10) - 1;
    month = parseInt(date[1], 10);
    if (parseInt(day, 10) < 1) {
      month = parseInt(month, 10) - 1;
      if (parseInt(month, 10) < 1) {
        month += 12;
      }
      day = days_in_month[month - 1];
    }
    if (day < 10) { day = "0" + day; }
    if (month < 10) { month = "0" + month; }

    document.forms[form].summer_to.value = day + "-" + month;
  }

  if (period_to != "") {
    date = period_to.split("-");

    day = parseInt(date[0], 10) + 1;
    month = parseInt(date[1], 10);
    if (parseInt(day, 10) > days_in_month[month - 1]) {
      month = parseInt(month, 10) + 1;
      if (parseInt(month, 10) > 12) {
        month -= 12;
      }
      day = "1";
    }
    if (day < 10) { day = "0" + day; }
    if (month < 10) { month = "0" + month; }

    document.forms[form].summer_from.value = day + "-" + month;
  }
}

function VerifyValidData(form) {
  var result = false;

  switch (form) {
         case "globa_fish" :
         result = VerifyForBlank('add', 'act_no', 'Полето указващо № на фиша не може да бъде празно!');
         //if (result) result = VerifyForLength('add', 'act_no', 'Полето указващо № на акта не може да съдържа по-малко от 10 символа', 0);
         if (result) result = VerifyForBlank('add', 'act_date', 'Полето указващо датата на фиша не може да бъде празно!');
         if (result) {
            if (document.forms['add'].elements['act_date'].value != "")
               result = VerifyDate('add', 'act_date', 'Полето указващо датата на фиша съдържа невалидна дата!');
            else
               result = true;
         }
         if (result) result = VerifyForBlank('add', 'act_maker_name', 'Полето указващо имената на съставилия фиша  не може да бъде празно!');
         if (result) result = VerifyForBlank('add', 'act_maker_position', 'Полето указващо длъжността на съставилия фиша не може да бъде празно!');
         if (result) result = VerifyForBlank('add', 'offender_name', 'Полето указващо нарушителя не може да бъде празно!');
         if (result) result = VerifyForBlank('add', 'reg_car_numb', 'Полето указващо  рег.номер на МПС на нарушителя не може да бъде празно!');
      break;
      
      
      
      case "addact" :
         result = VerifyForBlank('add', 'act_no', 'Полето указващо № на акта не може да бъде празно');
         //if (result) result = VerifyForLength('add', 'act_no', 'Полето указващо № на акта не може да съдържа по-малко от 10 символа', 0);
         if (result) result = VerifyForBlank('add', 'act_date', 'Полето указващо датата на акта не може да бъде празно');
         if (result) {
            if (document.forms['add'].elements['act_date'].value != "")
               result = VerifyDate('add', 'act_date', 'Полето указващо датата на акта съдържа невалидна дата');
            else
               result = true;
         }
         if (result) result = VerifyForBlank('add', 'act_maker_name', 'Полето указващо имената на актосъставителя не може да бъде празно');
         if (result) result = VerifyForBlank('add', 'act_maker_position', 'Полето указващо длъжността на актосъставителя не може да бъде празно');
         if (result) result = VerifyForBlank('add', 'offender_name', 'Полето указващо нарушителя не може да бъде празно');
      break;

      case "addnp" :
         result = VerifyForBlank('add', 'act_no', 'Полето указващо № на акта не може да бъде празно');
         //if (result) result = VerifyForLength('add', 'act_no', 'Полето указващо № на акта не може да съдържа по-малко от 10 символа', 0);
         if (result) result = VerifyForBlank('add', 'act_date', 'Полето указващо датата на акта не може да бъде празно');
         if (result) {
            if (document.forms['add'].elements['act_date'].value != "")
               result = VerifyDate('add', 'act_date', 'Полето указващо датата на акта съдържа невалидна дата');
            else
               result = true;
         }
         if (result) result = VerifyForBlank('add', 'act_maker_name', 'Полето указващо имената на актосъставителя не може да бъде празно');
         if (result) result = VerifyForBlank('add', 'act_maker_position', 'Полето указващо длъжността на актосъставителя не може да бъде празно');
         if (result) result = VerifyForBlank('add', 'offender_name', 'Полето указващо нарушителя не може да бъде празно');
         if (result) result = VerifyForBlank('add', 'np_no', 'Полето указващо № на НП не може да бъде празно');
         //if (result) result = VerifyForLength('add', 'np_no', 'Полето указващо № на НП не може да съдържа по-малко от 10 символа', 0);
         if (result) result = VerifyForBlank('add', 'np_date', 'Полето указващо датата на НП не може да бъде празно');
         if (result) {
            if (document.forms['add'].elements['np_date'].value != "")
               result = VerifyDate('add', 'np_date', 'Полето указващо датата на НП съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.add.act_inst.options[document.add.act_inst.selectedIndex].value == "1111111") {
               alert("Изберете институцията издала!");
               return false;
            }
         }
         if (result) {
            if (document.forms['add'].elements['receipt_date_notification'].value != "")
               result = VerifyDate('add', 'receipt_date_notification', 'Полето указващо датата на връчване на НП съдържа невалидна дата');
            else
               result = true;
         }
      break;

      case "search" :
         if (document.forms['add'].elements['act_date_begin'].value != "")
               result = VerifyDate('add', 'act_date_begin', 'Полето указващо началната дата на търсене за акта съдържа невалидна дата');
            else
               result = true;
         if (result) {
            if (document.forms['add'].elements['act_date_end'].value != "")
               result = VerifyDate('add', 'act_date_end', 'Полето указващо крайната дата на търсене за акта съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['np_date_begin'].value != "")
               result = VerifyDate('add', 'np_date_begin', 'Полето указващо началната дата на търсене за НП съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['np_date_end'].value != "")
               result = VerifyDate('add', 'np_date_end', 'Полето указващо крайната дата на търсене за НП съдържа невалидна дата');
            else
               result = true;
         }
////////////////
		if (result) {
            if (document.forms['add'].elements['receipt_date_notification_begin'].value != "")
               result = VerifyDate('add', 'receipt_date_notification_begin', 'Полето указващо началната дата на търсене за дата на връчване на НП съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['receipt_date_notification_end'].value != "")
               result = VerifyDate('add', 'receipt_date_notification_end', 'Полето указващо крайната дата на търсене за  дата на връчване на НП съдържа невалидна дата');
            else
               result = true;
         }
         
 		if (result) {
            if (document.forms['add'].elements['visible_date_begin'].value != "")
               result = VerifyDate('add', 'visible_date_begin', 'Полето указващо началната дата на търсене за дата на активно НП съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['visible_date_end'].value != "")
               result = VerifyDate('add', 'visible_date_end', 'Полето указващо крайната дата на търсене за  дата на активно НП съдържа невалидна дата');
            else
               result = true;
         }
         
///////////////
         if (result) {
            var cb = 0;
            if (document.add.cb_act_no.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_act_date.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_act_inst.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_act_maker_name.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_offence_date.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_offence.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_laws.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_offender_name.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_offender_position.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_np_no.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_np_date.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_np_maker_name.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_punishment_type.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_appeal.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_end.checked) {
               cb = cb + 1;
            }
            if (document.add.cb_del.checked) {
               cb = cb + 1;
            }
	    if (document.add.cb_punishment_degree.checked) {
               cb = cb + 1;
            }
	    if (document.add.cb_paid_amount.checked) {
               cb = cb + 1;
            }
        if (document.add.cb_visible_status.checked) {
               cb = cb + 1;
            }
        if (document.add.cb_visible_date.checked) {
               cb = cb + 1;
            }
        if (document.add.cb_receipt_date_notification.checked) {
               cb = cb + 1;
            }
            if (cb == "0") {
               alert ('Трябва да има поне 1 маркирано поле, което да бъде визуализирано при справката');
               return false;
            }
            if (cb > "7") {
               alert ('Трябва да има не повече от 7 маркирани полета, които да бъдат визуализирани при справката');
               return false;
            }
            return true;
         }
      break;

      case "edit" :
         result = VerifyForBlank('add', 'act_no', 'Полето указващо № на акта не може да бъде празно');
         if (result) result = VerifyForBlank('add', 'act_date', 'Полето указващо датата на акта не може да бъде празно');
         if (result) {
            if (document.forms['add'].elements['act_date'].value != "")
               result = VerifyDate('add', 'act_date', 'Полето указващо датата на акта съдържа невалидна дата');
            else
               result = true;
         }
         if (result) result = VerifyForBlank('add', 'act_maker_name', 'Полето указващо имената на актосъставителя не може да бъде празно');
         if (result) result = VerifyForBlank('add', 'act_maker_position', 'Полето указващо длъжността на актосъставителя не може да бъде празно');
         //if (result) result = VerifyForBlank('add', 'np_no', 'Полето указващо № на НП не може да бъде празно');
         //if (result) result = VerifyForBlank('add', 'np_date', 'Полето указващо датата на НП не може да бъде празно');
         if (result) {
            if (document.forms['add'].elements['np_date'].value != "")
               result = VerifyDate('add', 'np_date', 'Полето указващо датата на НП съдържа невалидна дата');
            else
               result = true;
         }
         /*if (result) {
            if (document.add.act_inst.options[document.add.act_inst.selectedIndex].value == "1111111") {
               alert("Изберете институцията издала!");
               return false;
            }
         }*/
         //-----------
         if (result) {
            if (document.forms['add'].elements['bill_date'].value != "")
               result = VerifyDate('add', 'bill_date', 'Полето указващо датата на квитанцията съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['receipt_date_notification'].value != "")
               result = VerifyDate('add', 'receipt_date_notification', 'Полето указващо датата на предаване на уведомлението съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['receipt_date_invitation'].value != "")
               result = VerifyDate('add', 'receipt_date_invitation', 'Полето указващо датата на предаване на поканата съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['invitation_letter_date1'].value != "")
               result = VerifyDate('add', 'invitation_letter_date1', 'Полето указващо датата на първото уведомително писмо съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['invitation_letter_date2'].value != "")
               result = VerifyDate('add', 'invitation_letter_date2', 'Полето указващо датата на второто уведомително писмо съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['giving_date'].value != "")
               result = VerifyDate('add', 'giving_date', 'Полето указващо датата на предаване съдържа невалидна дата');
            else
               result = true;
         }
         if (result) {
            if (document.forms['add'].elements['end_date'].value != "")
               result = VerifyDate('add', 'end_date', 'Полето указващо датата на прекратяване съдържа невалидна дата');
            else
               result = true;
         }
         //-----------
         if (result) {
            if (document.add.bill_no.value!="" || document.add.bill_date.value!="" || document.add.end.checked || document.add.end_date.value!="") {
               if (document.add.bill_no.value=="" || document.add.bill_date.value=="" || !document.add.end.checked || document.add.end_date.value=="") {
                  if (document.add.bill_no.value=="") {
                     alert("Полето указващо № на квитанцията не може да бъде празно");
                     result=false;
                     return false;
                  }
                  if (document.add.bill_date.value=="") {
                     alert("Полето указващо датата на квитанцията не може да бъде празно");
                     result=false;
                     return false;
                  }
                  if (!document.add.end.checked) {
                     alert("Полето 'Прекратено' трябва да бъде маркирано");
                     result=false;
                     return false;
                  }
                  if (document.add.end_date.value=="") {
                     alert("Полето указващо датата на прекратяване не може да бъде празно");
                     result=false;
                     return false;
                  }
               }
               else {
                  result=true;
               }
            }
         }
         if (result) {
            if (document.add.giving.options[document.add.giving.selectedIndex].value!="1111111" || document.add.giving_date.value!="") {
               if (document.add.giving.options[document.add.giving.selectedIndex].value=="1111111" || document.add.giving_date.value=="") {
                  if (document.add.giving.options[document.add.giving.selectedIndex].value=="1111111") {
                     alert("Изберете институцията, на която е било предадено НП");
                     return false;
                  }
                  if (document.add.giving_date.value=="") {
                     alert("Полето указващо датата на предаване не може да бъде празно");
                     return false;
                  }
               }
               else {
                  return true;
               }
            }
         }
      break;

    case "ftownsfolk":
      result = VerifyForBlank(form, 'name', 'Полето указващо име на гражданин не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'egn', 'Полето указващо ЕГН на гражданин не може да бъде празно');
      if (result) result = VerifyForLength(form, 'egn', 'Полето указващо ЕГН на гражданин не може да съдържа по-малко от 10 символа', 0);
      if (result) result = VerifyEGN(document.forms['ftownsfolk'].elements['egn'].value);
      if (result) {
        if (document.forms['ftownsfolk'].elements['pass_data'].value != "")
          result = VerifyDate(form, 'pass_data', 'Полето указващо дата на издаване на паспорт на гражданин съдържа невалидна дата');
        else
          result = true;
      }
        else
        {
                result = VerifyPNF(document.forms['ftownsfolk'].elements['egn'].value);
                if(result)
                {
                        if(document.forms['ftowsfolk'].elements['pass_data'].value != "")
                                result = VerifyDate(form,'pass_data','Полето указващо дата на издаване на паспорт на гражданин съдържа невалидна дата');
                        else
                                result = true;
                }
        }
    break;
    case "ftownsfolk_data":
      result = VerifyForBlank(form, 'name', 'Полето указващо име на гражданин не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'egn', 'Полето указващо ЕГН на гражданин не може да бъде празно');
      if (result) result = VerifyForLength(form, 'egn', 'Полето указващо ЕГН на гражданин не може да съдържа по-малко от 10 символа', 0);
      if (result) result = VerifyEGN(document.forms['ftownsfolk_data'].elements['egn'].value);
      if (result) {
        if (document.forms['ftownsfolk_data'].elements['pass_data'].value != "")
          result = VerifyDate(form, 'pass_data', 'Полето указващо дата на издаване на паспорт на гражданин съдържа невалидна дата');
        else
          result = true;
      }
        else
        {
                result = VerifyPNF(document.forms['ftownsfolk_data'].elements['egn'].value);
                if(result)
                {
                        if(document.forms['ftownsfolk_data'].elements['pass_data'].value != "")
                                result = VerifyDate(form, 'pass_data', 'Полето указващо дата на издаване на паспорт на гражданин съдържа невалидна дата');
                        else
                                result = true;
                }
        }

    break;
    case "fcompany":
      result = VerifyForBlank(form, 'firm_name', 'Полето указващо име на юридическо лице не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'firm_type', 'Полето указващо тип на юридическо лице не може да бъде празно');
      if(document.forms[form].elements['rate'].value != "")
        {
        if (result) result = VerifyForLength(form, 'rate', 'Полето указващо данъчен номер на юридическо лице не може да съдържа по-малко от 10 символа', 0);
        if (result) result = VerifyRateNumber(document.forms['fcompany'].elements['rate'].value);
      }
        if (result) result = VerifyForBlank(form, 'bulstat', 'Полето указващо булстат на юридическо лице не може да бъде празно');
      if (result) result = VerifyForLength(form, 'bulstat', 'Полето указващо булстат на юридическо лице не може да съдържа по-малко от 9 символа', 4);
      if (result) result = VerifyBulstat(document.forms['fcompany'].elements['bulstat'].value);
      //if (result) result = VerifyForBlank(form, 'manager', 'Полето указващо име на управител не може да бъде празно');
    break;
    case "fcompany_data":
      result = VerifyForBlank(form, 'firm_name', 'Полето указващо име на юридическо лице не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'firm_type', 'Полето указващо тип на юридическо лице не може да бъде празно');
      if(document.forms[form].elements['rate_numb'].value != "")
        {
        if (result) result = VerifyForLength(form, 'rate_numb', 'Полето указващо данъчен номер на юридическо лице не може да съдържа по-малко от 10 символа', 0);
                if (result) result = VerifyRateNumber(document.forms['fcompany_data'].elements['rate_numb'].value);
      }
        if (result) result = VerifyForBlank(form, 'bulstat', 'Полето указващо булстат на юридическо лице не може да бъде празно');
      if (result) result = VerifyForLength(form, 'bulstat', 'Полето указващо булстат на юридическо лице не може да съдържа по-малко от 9 символа', 4);
      if (result) result = VerifyBulstat(document.forms['fcompany_data'].elements['bulstat'].value);
      if(document.forms[form].elements['dds_reg_flag'][0].checked)
	{
		if(result) result = VerifyForBlank(form, 'dds_id', 'Полето, указващо ИН по ДДС не може да бъде празно! За да промените това, отбележете, че юридическото лице няма регистрация по ДДС.');
	}
	
      if (result) result = VerifyForBlank(form, 'property', 'Полето указващо собсвеност на юридическо лице не може да бъде празно');
      //if (result) result = VerifyForBlank(form, 'manager', 'Полето указващо име на управител не може да бъде празно');
    break;
    case "faddress":
      result = VerifyForBlank(form, 'region', 'Полето указващо област не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'municipality', 'Полето указващо община не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'populated_towns', 'Полето указващо населено място не може да бъде празно');
    break;
    case "fagents_data":
      result = VerifyForBlank(form, 'name', 'Полето указващо име на представител не може да бъде празно');
      if (result) {
        if (document.forms['fagents_data'].elements['pleni_data'].value != "")
          result = VerifyDate(form, 'pleni_data', 'Полето указващо дата на пълномощно на представител съдържа невалидна дата');
        else
          result = true;
      }
    break;
    case "faccounts_data":
      result = VerifyForBlank(form, 'bank_code', 'Полето указващо код на банката не може да бъде празно');
      if (result) result = VerifyForLength(form, 'bank_code', 'Полето указващо код на банката не може да съдържа по-малко от 8 символа', 0);
      if (result) result = VerifyForBlank(form, 'bank_name', 'Полето указващо име на банката не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'bank_account', 'Полето указващо номер на банкова сметка не може да бъде празно');
      if (result) result = VerifyForLength(form, 'bank_account', 'Полето указващо номер на банкова сметка не може да съдържа по-малко от 10 символа', 0);
    break;
    case "fobject":
      result = VerifyForBlank(form, 'number', 'Полето указващо номер на обект не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'object_name', 'Полето указващо име на обект не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'object_mode', 'Полето указващо вид на обект не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'zone', 'Полето указващо зона на обект не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'gauge_area', 'Полето указващо мярка за площ на обект не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'total_area', 'Полето указващо обща площ на обект не може да бъде празно');
    break;
    case "fterrain":
      result = VerifyForBlank(form, 'number', 'Полето указващо номер на терен не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'object_name', 'Полето указващо име на терен не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'terrain_mode', 'Полето указващо вид на терен не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'zone', 'Полето указващо зона на терен не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'gauge_area', 'Полето указващо мярка за площ на терен не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'total_area', 'Полето указващо обща площ на терен не може да бъде празно');
    break;
    case "fhouse":
      result = VerifyForBlank(form, 'number', 'Полето указващо номер на жилище не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'object_name', 'Полето указващо име на жилище не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'house_mode', 'Полето указващо вид на жилище не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'zone', 'Полето указващо зона на жилище не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'gauge_area', 'Полето указващо мярка за площ на жилище не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'total_area', 'Полето указващо обща площ на жилище не може да бъде празно');
    break;
    case "fcontract":
      result = VerifyForBlank(form, 'contr_date', 'Полето указващо дата на договор не може да бъде празно');
      if (result) result = VerifyDate(form, 'contr_date', 'Полето указващо дата на договор съдържа невалидна дата');
      if (result) result = VerifyForBlank(form, 'contr_state', 'Полето указващо състояние на договор не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'contr_rent', 'Полето указващо наем не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'use_mode', 'Полето указващо вид използване не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'first_date', 'Полето указващо начална дата на договор не може да бъде празно');
      if (result) result = VerifyDate(form, 'first_date', 'Полето указващо начална дата на договор съдържа невалидна дата');
      if (result) result = VerifyForBlank(form, 'period', 'Полето указващо срок на договор не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'period_limit', 'Полето указващо мярка за срок на договор не може да бъде празно');
      if (result) {
        if (document.forms['fcontract'].elements['final_date'].value != "")
          result = VerifyDate(form, 'final_date', 'Полето указващо крайна дата на договор съдържа невалидна дата');
        else
          result = true;
      }
      if (result) {
        if (document.forms['fcontract'].elements['order_date'].value != "")
          result = VerifyDate(form, 'order_date', 'Полето указващо дата на Настанителна заповед съдържа невалидна дата');
        else
          result = true;
      }
      if (result) {
        if (document.forms['fcontract'].elements['report_date'].value != "")
          result = VerifyDate(form, 'report_date', 'Полето указващо дата на ПП протокол съдържа невалидна дата');
        else
          result = true;
      }
      if (result) result = VerifyForBlank(form, 'pay_time', 'Полето указващо дата на плащане на договор не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'pay_month', 'Полето указващо дата на плащане на договор не може да бъде празно');
      if (result) {
        if (document.forms['fcontract'].elements['gratis_period'].value != "")
          result = VerifyDate(form, 'gratis_period', 'Полето указващо гратисен период съдържа невалидна дата');
          if (result) {
            if (document.forms['fcontract'].elements['gratis_period'].value != "") {
              result = VerifyGratisPeriod(form, 'Полето указващо гратисен период не може да съдържа дата по малка от датата на договора');
            }
          }
        else
          result = true;
      }
    break;
    case "fcontr_view":
      result = VerifyForBlank(form, 'contr_date', 'Полето указващо дата на договор не може да бъде празно');
      if (result) result = VerifyDate(form, 'contr_date', 'Полето указващо дата на договор съдържа невалидна дата');
      if (result) result = VerifyForBlank(form, 'contr_state', 'Полето указващо състояние на договор не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'contr_rent', 'Полето указващо наем не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'use_mode', 'Полето указващо вид използване не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'first_date', 'Полето указващо начална дата на договор не може да бъде празно');
      if (result) result = VerifyDate(form, 'first_date', 'Полето указващо начална дата на договор съдържа невалидна дата');
      if (result) result = VerifyForBlank(form, 'period', 'Полето указващо срок на договор не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'period_limit', 'Полето указващо мярка за срок на договор не може да бъде празно');
      if (result) {
        if (document.forms['fcontr_view'].elements['final_date'].value != "")
          result = VerifyDate(form, 'final_date', 'Полето указващо крайна дата на договор съдържа невалидна дата');
        else
          result = true;
      }
      if (result) {
        if (document.forms['fcontr_view'].elements['order_date'].value != "")
          result = VerifyDate(form, 'order_date', 'Полето указващо дата на Настанителна заповед съдържа невалидна дата');
        else
          result = true;
      }
      if (result) {
        if (document.forms['fcontr_view'].elements['report_date'].value != "")
          result = VerifyDate(form, 'report_date', 'Полето указващо дата на ПП протокол съдържа невалидна дата');
        else
          result = true;
      }
      if (result) result = VerifyForBlank(form, 'pay_time', 'Полето указващо дата на плащане на договор не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'pay_month', 'Полето указващо дата на плащане на договор не може да бъде празно');
      if (result) {
        if (document.forms['fcontr_view'].elements['gratis_period'].value != "") {
          result = VerifyDate(form, 'gratis_period', 'Полето указващо гратисен период съдържа невалидна дата');
          if (result) {
            if (document.forms['fcontr_view'].elements['gratis_period'].value != "") {
              result = VerifyGratisPeriod(form, 'Полето указващо гратисен период не може да съдържа дата по малка от датата на договора');
            }
          }
        }
        else
          result = true;
      }
    break;
    case "fpay_systems":
      result = VerifyForBlank(form, 'pay_time', 'Полето указващо число на плащане не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'pay_month', 'Полето указващо месец на плащане не може да бъде празно');
    break;
    case "fbalances_data":
      result = VerifyForBlank(form, 'month', 'Полето указващо месец не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'year', 'Полето указващо година не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'month_debt', 'Полето указващо месечни задължения не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'interest', 'Полето указващо лихва не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'forfeit', 'Полето указващо неустойки не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'month_pays', 'Полето указващо месечни плащания не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'final_balance', 'Полето указващо крайно салдо не може да бъде празно');
    break;
    case "fannexes_data":
      result = VerifyForBlank(form, 'annex_numb', 'Полето указващо номер на анекс не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'annex_date', 'Полето указващо дата на анекс не може да бъде празно');
      if (result) result = VerifyDate(form, 'annex_date', 'Полето указващо дата на анекс съдържа невалидна дата');
      if (result) result = VerifyForBlank(form, 'first_date', 'Полето указващо начална дата на анекс не може да бъде празно');
      if (result) result = VerifyDate(form, 'first_date', 'Полето указващо начална дата на анекс съдържа невалидна дата');
      if (result) {
        date1 = document.forms['fannexes_data'].elements['first_date'].value.split("-");
        new_date1 = date1[2] + "-" + date1[1] + "-" + date1[0];
        date2 = document.forms['fannexes_data'].elements['old_first_date'].value.split("-");
        new_date2 = date2[2] + "-" + date2[1] + "-" + date2[0];
        if (new_date2 > new_date1) {
          alert('Полето указващо начална дата на анекс не може да съдържа дата по-малка от датата на предишния анекс');
          document.forms['fannexes_data'].elements['first_date'].focus();
          result = false;
        }
        else result = true;
      }
      if (result) result = VerifyForBlank(form, 'period', 'Полето указващо срок на анекс не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'period_limit', 'Полето указващо мярка за срок на анекс не може да бъде празно');
      if (result) {
        if (document.forms['fannexes_data'].elements['final_date'].value != "")
          result = VerifyDate(form, 'final_date', 'Полето указващо крайна дата на анекс съдържа невалидна дата');
        else
          result = true;
      }
      if (result) result = VerifyForBlank(form, 'new_rent', 'Полето указващо нов наем не може да бъде празно');
    break;
    case "fmunicip_systems":
      result = VerifyForBlank(form, 'municipality', 'Полето указващо име на община не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'mayor', 'Полето указващо име на кмет не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'bulstat', 'Полето указващо булстат не може да бъде празно');
      //if (result) result = VerifyForBlank(form, 'rate_numb', 'Полето указващо данъчен номер не може да бъде празно');
    break;
  }

  return result;
}

var previous_element = '';
function LmOverOut(form, element, id, color1, color2) {
  if (document.forms[form].data.value != id) {
    element.style.backgroundColor = color1;
  } else {
    element.style.backgroundColor = color2;
  }
}

function LmDown(form, value, element, cookie_flag) {
  if (previous_element) {
    previous_element.style.backgroundColor = '';
  }
  previous_element = element;

  document.forms[form].data.value = value;

  if (cookie_flag) {
    document.cookie = "subcontr_id1=" + value;
    document.cookie = "subcontr_id2=" + value;
  }
}


//////////////////////////////////////////////////////////////////////////////////////////
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
/////////

function select_more($sel,$name,$cod_cod_array){
//	var cod_array= $cod_cod_array.split("|");
 for (var i = 0; i < document.fsearch_pokana.elements.length; i++) {
     while (document.fsearch_pokana.elements[i].id != $name) {
        i++;
        if (!document.fsearch_pokana.elements[i]) return;
     }
     document.fsearch_pokana.elements[i].checked = $sel;
  }
}

function enable_p_type(){
  if	(document.getElementById('add_punishment').checked==true)
	{
		document.getElementById('p_type_1').disabled=false;
		document.getElementById('sum_degree_1').disabled=false;
		document.getElementById('p_type_2').disabled=false;
		document.getElementById('sum_degree_2').disabled=false;
	}
	else
	{
		document.getElementById('p_type_1').disabled=true;
		document.getElementById('sum_degree_1').disabled=true;
		document.getElementById('p_type_2').disabled=true;
		document.getElementById('sum_degree_2').disabled=true;
	}
//i tazi funkciq da se napravi s cikal for ot 1 do n za n na broj pla6taniq	
}