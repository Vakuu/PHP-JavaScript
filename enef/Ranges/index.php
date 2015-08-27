<?
header("Content-Type: text/html; charset=winwods-1251");

?>
<style>
body {
	 margin-left:  0cm;
	 margin-right: 0px;
	 margin-top: 0px;
	 margin-bottom: 0px;
	 font-size:  100%;
	 text-align: center;
	 background-image: url(../Images/Stone.jpg);
	 }

div.range_page
{
 margin: 0px auto auto auto;
 text-align: center;
 width: 800px;
 height: 100%;
 border: 1px;
 border-style: solid;
 border-color: Gray;
}

div.div_left
{
 float: left;
 text-align: left;
 visibility: visible;
 display: block; 
 width: 320px;
}
div.div_right
{
 float: left;
 border: 0px;
 border-style: solid;
 margin-right: 0px;
 padding: 0px;
 text-align: center;
 font-size: 12px;
 visibility: visible;
 display: block; 
 width: 455px;
 height: 100%;
}
iframe.elements{
 height: 100%;
 width: 460px;   
 border: 0px none;
 border-right: 0px; 
 overflow: auto; 
 margin-top: 0px; 
 margin: 0px;
}

select.choice_element
{
 margin-left: 0px;
 border: 1px;
 border-style: solid;
 border-color: Gray;	
 text-align: left;
 overflow: auto;
}
</style>
<div class="range_page">
<div class="div_left">
<?
require_once("ranges.php");
?>
</div>
<div class="div_right">
<iframe name="elements" class="elements" frameborder="0"></iframe>
 </div>
</div>

