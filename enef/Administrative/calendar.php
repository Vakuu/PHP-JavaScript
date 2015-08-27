<?php
  include_once("../inc/conf.php");
?>
<html>
<head>
<style type="text/css">
#input_container {
width: 750px;
text-align: left;
}
#input_container input {
margin: 0 5px;
}
.hide {
visibility: hidden;
}
</style>
<script type="text/javascript">
var currentTime = new Date()
var year = currentTime.getFullYear()


function CreateEraseInput() {
var root=document.forms['root'];
var input_con=document.getElementById('input_container');
var create=root.elements['create'];
var erase=root.elements['erase'];
with (document) {
var broi=createElement('input');
broi.type='hidden';
broi.name='broi';
broi.id='broi';
broi.value=broika;
}
input_con.appendChild(broi);


create.onclick=function () {
broi.value++;
with (document) {
var label=createElement('label');
label.innerHTML='Раб. ден ';
label.id='lrd'+i;
var label1=createElement('label');
label1.innerHTML='Година ';
label1.id='god'+i;
var label2=createElement('label');
label2.innerHTML='Поч. ден ';
label2.id='lpd'+i;
var label3=createElement('label');
label3.innerHTML=' Основание ';
label3.id='os'+i;
var input=createElement('input');
input.id='rden'+i;
input.type='text';
input.name='rden'+i;
input.size = 10;
var input_g=createElement('input');
input_g.id='god'+i;
input_g.type='text';
input_g.name='god'+i;
input_g.value = year;
input_g.size = 4;
var input1=createElement('input');
input.id='pden'+i;
input1.type='text';
input1.name='pden'+i;
input1.size = 10;
var textarea=createElement('textarea');
textarea.rows='3';
textarea.name='reason'+i;
var checkbox=createElement('input');
checkbox.type='checkbox';
checkbox.name='in_table'+i;
var br=createElement('br');
}
input_con.appendChild(checkbox);
input_con.appendChild(label1);
input_con.appendChild(input_g);
input_con.appendChild(label2);
input_con.appendChild(input1);
input_con.appendChild(label);
input_con.appendChild(input);
input_con.appendChild(label3);
input_con.appendChild(textarea);
input_con.appendChild(br);
erase.style.visibility='visible';

if (i>=20) {
this.style.visibility='hidden';
}
i++;
}

erase.onclick=function () {
broi.value--;
for (j=0;j<10;j++) {
input_con.removeChild(input_con.lastChild);
}
create.style.visibility='visible';
if (i<=3) {
this.style.visibility='hidden';
}
i--;
}
}
window.onload=CreateEraseInput;
</script>
</head>
<body background='../Images/Stone.jpg'>

<?php
$broi = $_POST['broi'];
if(isset($broi))
{
echo "<form name='root' action='b.php' method='post'>
<div id='input_container'>";

for ($i=1;$i<$broi+1;$i++)
{
$in_tab='in_table'.$i;
$rden ='rden'.$i;
$pden ='pden'.$i;
$god = 'god'.$i;
$reason = 'reason'.$i;
echo $pden.'<br>'.$_POST["$pden"]."<br>".$_POST["$god"]." ".$broi;
if($_POST["$in_tab"])
{
//$rden ='rden'.$br;
//$god = 'god'.$br;               and  ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", trim($_POST["$pden"]),$arr_p)and ($arr_p[2]<=31)and($arr_p[2]>0)and($arr_p[3]<=12)and($arr_p[3]>0)
//$in_table='in_table'.$br++;
$st_rden = 0;
$ar=0;$r_cor=0;$cor_p_date=0;
echo $_POST["$rden"];
if ($_POST["$rden"]!= '')
{
if(ereg("([0-9]{2})-([0-9]{2})-([0-9]{4})", trim($_POST["$rden"]),$arr_r)and
($arr_r[1]<=31)and($arr_r[2]>0)and($arr_r[2]<=12)and($arr_r[3]>0))
{
$ar = ereg("([0-9]{2})-([0-9]{2})-([0-9]{4})", trim($_POST["$rden"]),$arr_r);  //proverqva dali e korektna datata i q nakysva
if($_POST["$rden"]>date("d-m-Y")){$r_date=1;}   //proverqva dali dadeniq den e sle teku6tiq
$r_cor = $arr_r[3]."-".$arr_r[2]."-".$arr_r[1]; // po4iven den v tip date
if(((date('w',(strtotime(date("$r_cor"))))==0)or(date('w',(strtotime(date("$r_cor"))))==6)))
{$cor_r_date=1;}
$st_rden = 1;}
}else
{$st_rden = 1;$r_date=1;$ar=1;$cor_r_date=1; echo "a";} // tuka

if(($r_date==1))
{echo "b";
ereg("([0-9]{2})-([0-9]{2})-([0-9]{4})", trim($_POST["$pden"]),$arr_p);
$p_cor = $arr_p[3]."-".$arr_p[2]."-".$arr_p[1]; // po4iven den v tip date
if ((date('w',(strtotime(date("$p_cor"))))>0)and(date('w',(strtotime(date("$p_cor"))))<6)
and ($cor_r_date==1))
{
$cor_date=1;}
else{$cor_date=1;}
}
else
{$cor_date=0;}
echo $arr_p[1]." ".$arr_p[2]." ".$arr_p[3]."<br>";
if(($ar > 0) and ($cor_date==1) and
($arr_p[1]<=31)and($arr_p[1]>0)and($arr_p[2]<=12)and($arr_p[2]>0)and($st_rden == 1))
{
echo "<font color='#0000ff'>Следващата дата е записана успещно!!!</font><br>";
$god = $_POST["$god"];
$r_den = $arr_r[3]."-".$arr_r[2]."-".$arr_r[1];
$p_den = $arr_p[3]."-".$arr_p[2]."-".$arr_p[1];
$reason = $_POST["$reason"];
echo "<input type='checkbox' name='in_table' readonly='readonly'/>
<label>Година</label><input type='text' name='god' value='".$god."' readonly='readonly' size=4>
<label>Поч. Ден</label><input type='text' name='pden' value='".$_POST["$pden"]."' readonly='readonly' size=10>";
echo "<label>Раб. Ден</label><input type='text' name='rden' value='".$_POST["$rden"]."' readonly='readonly' size=10>
<label>Основание</label><textarea name='reason1' rows='3' readonly='readonly'>".$reason."</textarea><br>";
$query = "insert into calendar values('', '".$god."', '".$r_den."', '".$p_den."', '".$reason."')";
$result = sql_q($query);
}
else{echo "<font color='#ff0000'>Следващата дата не е коректна и не е записана!!!</font><br>";
$god = $_POST["$god"];
$reason = $_POST["$reason"];
echo "<input type='checkbox' name='in_table' readonly='readonly'/>
<label>Година</label><input type='text' name='god' value='".$god."' readonly='readonly' size=4>
<label>Поч. Ден</label><input type='text' name='pden' value='".$_POST["$pden"]."' readonly='readonly' size=10>
<label>Раб. Ден</label><input type='text' name='rden' value='".$_POST["$rden"]."' readonly='readonly' size=10>
<label>Основание</label><textarea name='reason1' rows='3' readonly='readonly'>".$reason."</textarea><br>";
}
}
}
echo "</div><br>

<input type='submit' name='sender' value='Запази' disabled='disabled'>
<input type='button' name='create' value='Добави ден' disabled='disabled'>
<input class='hide' type='button' name='erase' value='Изтрий последен ден' disabled='disabled'>
</form> ";
}
else{
?>
<form name="root" action="calendar.php" method="post">
<div id="input_container">
<script language="JavaScript" type="text/javascript">
 var i=2; var broika=1;
</script>
<font color="#FF3300">Моля въведете датата в формат ден-месец-година (25-06-2008)</font><br>
<input type="checkbox" name="in_table1" />
<label>Година</label><input type="text" name = "god1" value ="<?=date('Y'); ?>"  maxlength = "4" size = "4" >
<label>Поч. Ден</label><input type="text" name="pden1" size="10">
<label>Раб. ден</label><input type="text" name="rden1" size="10">
<label>Основание</label><textarea name="reason1" rows="3"></textarea>

</div><br>

<input type="submit" name="sender" value="Запази">
<input type="button" name="create" value="Добави ден">
<input type="button" value="Изход" onClick="window.close();" />
<input class="hide" type="button" name="erase" value="Изтрий последен ден">
</form>
<?php
 }
?>
</body>
</html>