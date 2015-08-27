function OpenWindow(url, title, width, height) {
  var screen_width = screen.width;
  var screen_height = screen.height;

  var left = Math.ceil((screen_width - width) / 2);
  var top = Math.ceil((screen_height - height) / 2);

  return "window.open('" + url + "', '" + title + "', 'left=" + left + ", top=" + top + ", width=" + width + ", height=" + height + "')";
}

if(typeof(loc)=="undefined"||loc==""){var loc="";if(document.body&&document.body.innerHTML){var tt=document.body.innerHTML.toLowerCase();var last=tt.indexOf("lozinge.js\"");if(last>0){var first=tt.lastIndexOf("\"",last);if(first>0&&first<last)loc=document.body.innerHTML.substr(first+1,last-first-1);}}}

var bd=0
document.write("<style type=\"text/css\">");
document.write("\n<!--\n");
document.write(".lozinge_menu {border-color:black;border-style:solid;border-width:"+bd+"px 0px "+bd+"px 0px;background-color:#009966;position:absolute;left:0px;top:0px;visibility:hidden;}");
document.write("a.lozinge_plain:link, a.lozinge_plain:visited{text-align:left;background-color:#009966;color:#ffffff;text-decoration:none;border-color:black;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("a.lozinge_plain:hover, a.lozinge_plain:active{background-color:#99b299;color:#000000;text-decoration:none;border-color:black;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("a.lozinge_l:link, a.lozinge_l:visited{text-align:left;background:#009966 url("+loc+"MenuImages/lozinge_l.gif) no-repeat right;;color:#ffffff;text-decoration:none;border-color:black;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("a.lozinge_l:hover, a.lozinge_l:active{background:#99b299 url("+loc+"MenuImages/lozinge_l2.gif) no-repeat right;color: #000000;text-decoration:none;border-color:black;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("\n-->\n");
document.write("</style>");

var fc=0x000000;
var bc=0x99b299;
if(typeof(frames)=="undefined"){var frames=0;}