<?
  $user_name = "admin";
  setcookie("user", $user_name);
  include("../inc/conf.php");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Номенклатури</title>
  <script language="JavaScript">
    function OpenWindow() {
      window.open("rangesfata.php", "rangesdata", "left=180, top=60, width=440, height=400");
    }
    function showEl($el){
    elements.location.href='elements.php?range_code='+$el;
    }   
  </script> 
<style>  
select.choice_element
{
 margin-left: 0px;
 border: 1px;
 border-style: solid;
 border-color: Green;	
 text-align: left;
 overflow: auto;
 color: blue;
}
</style>
</head>
<body onload="elements.location.href='elements.php';" background = "../Images/Stone.jpg">
  <form name=ranges>    
 <h3><center>Номенклатури</center></h3> 
  <select name="nom_code" size="30" class="choice_element" onchange='showEl(document.ranges.nom_code.value);'>
  <?
$result = sql_q("SELECT * FROM ranges ORDER BY ASCII(UCASE(nom_name)), UCASE(nom_name) ASC");
while ($row = mysql_fetch_array($result)) {
    ?><option value="<?php echo $row['nom_cod'] ?>"><?php echo $row['nom_name'] ?></option>
    <?
}
?>  
  <form>
  </select>
  <hr>
  <? 
$result = sql_q("SELECT * FROM rights WHERE user_name ='$user_name'");
$row_rights = mysql_fetch_array($result);

if ($row_rights["right_func"] != 2) {
    ?>
    <center><input type="button" value="Номенклатури" onclick="OpenWindow()"></center><?
} else {
    ?><center><input type="button" value="Номенклатури" disabled>   		
    <?
}
?>
<input name="back" type="button" value="Назад" onclick="window.location.href='../Administrative/index.html'">
</center>
</form>
</body>
</html>
<?
  mysql_close($connect);
?>