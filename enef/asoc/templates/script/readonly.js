function skip () {
   this.blur();
}
function toggleField (field) {
   if (document.all || document.getElementById)
      field.readOnly = !field.readOnly;
   else if (field.onfocus)
      field.onfocus = null
   else field.onfocus = skip;
}
