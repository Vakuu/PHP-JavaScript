var single_invoices_exit_flag = 0;

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

function ConfirmAction(message) {
  if (confirm(message)) {
    return true;
  } else {
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

function ValidateKeyCyrilic(object, special) {
  if (!((window.event.keyCode >= 65  && window.event.keyCode <= 90) ||
        (window.event.keyCode >= 97  && window.event.keyCode <= 122) ||
        (window.event.keyCode >= 1040  && window.event.keyCode <= 1103) ||
        (window.event.keyCode == 32) || (window.event.keyCode == special))) {
    window.event.keyCode = 0;
    object.focus();
  }
}

function ValidateKeyChar(object, special) {
  if (!((window.event.keyCode >= 65  && window.event.keyCode <= 90) ||
        (window.event.keyCode >= 97  && window.event.keyCode <= 122) ||
        (window.event.keyCode >= 1040  && window.event.keyCode <= 1103) ||
        (window.event.keyCode == 32) || (window.event.keyCode == special))) {
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

function ValidateKeyCharNumb(object, special1, special2, special3, special4) {
  if (!((window.event.keyCode >= 65  && window.event.keyCode <= 90) ||
        (window.event.keyCode >= 97  && window.event.keyCode <= 122) ||
        (window.event.keyCode >= 1040  && window.event.keyCode <= 1103) ||
        (window.event.keyCode == 32) ||
        (window.event.keyCode >= 48  && window.event.keyCode <= 57) ||
        (window.event.keyCode == special1) || (window.event.keyCode == special2) ||
        (window.event.keyCode == special3) || (window.event.keyCode == special4))) {
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

function VerifyValidData(form) {
  var result = false;

  switch (form) {
    case "fmunicip_systems":
      result = VerifyForBlank(form, 'municipality', 'Полето указващо име на община не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'mayor', 'Полето указващо име на кмет не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'bulstat', 'Полето указващо булстат не може да бъде празно');
      //if (result) result = VerifyForBlank(form, 'rate_numb', 'Полето указващо данъчен номер не може да бъде празно');
    break;
    case "faccounts_data":
      result = VerifyForBlank(form, 'iban', 'Полето указващо IBAN не може да бъде празно');
      if (result) result = VerifyForLength(form, 'iban', 'Полето IBAN трябва да бъде 22 символа',0);
      if (result) result = VerifyForBlank(form, 'bic', 'Полето указващо BIC код не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'bank_name', 'Полето указващо име на банка не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'bank_brunch', 'Полето указващо банков клон не може да бъде празно');
    break;
    case "fmayors_data":
      result = VerifyForBlank(form, 'name', 'Полето указващо  име не може да бъде празно');
      if (result) result = VerifyForBlank(form, 'date_from', 'Полето от дата не може да бъде празно');
      if (result) result = VerifyDate(form, 'date_from', 'Полето от дата съдържа невалидна дата');
      if (result) result = VerifyForBlank(form, 'date_to', 'Полето до дата не може бъде празно');
      if (result) result = VerifyDate(form, 'date_to', 'Полето до дата съдържа невалидна дата');
    break;
    case "fusers_data":
      result = VerifyForBlank(form, 'username', 'Полето потребител не може да бъде празно');
      if (fusers_data.get_edit_flag.value == '0') {
        if (result) result = VerifyForBlank(form, 'new_password', 'Полето нова парола не може да бъде празно');
        if (result) result = VerifyForBlank(form, 'confirm_password', 'Полето потвърждение на парола не може да бъде празно');

        if (fusers_data.confirm_password.value != fusers_data.new_password.value) {
          alert('Стойността на полето за потвърждение на парола е различна от тази на полето за нова парола')
          result = false;
        } else {
          result = true;
        }
      }
      if (result) result = VerifyForBlank(form, 'full_name', 'Полето име не може да бъде празно');
    break;
    case "fgroups_data":
      result = VerifyForBlank(form, 'name', 'Полето наименование на група не може да бъде празно');
    break;
    case "fsearch_delete_period":
      result = VerifyForBlank(form, 'from_date', 'Полето от дата не може да бъде празно');
      if (result) result = VerifyDate(form, 'from_date', 'Полето от дата съдържа невалидна дата');
      if (result) result = VerifyForBlank(form, 'to_date', 'Полето до дата не може бъде празно');
      if (result) result = VerifyDate(form, 'to_date', 'Полето до дата съдържа невалидна дата');
    break;
  }
  return result;
}

