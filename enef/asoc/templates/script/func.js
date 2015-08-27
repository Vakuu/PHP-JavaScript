function LmOverOut(form, element, id, color1, color2) {
  if (document.forms[form].data.value != id) {
    element.style.backgroundColor = color1;
  }
  else {
    element.style.backgroundColor = color2;
  }
}

var previous_element = '';
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


