<?php
   $functions = array();

   $result = sql_q("SELECT id FROM users WHERE username = '$_SESSION[username]' ");
   $row = mysql_fetch_array($result);

   $result = sql_q("SELECT gu.group_id FROM group_users gu, groups g WHERE gu.group_id = g.id AND gu.user_id = '$row[id]' AND g.status = '1' ORDER BY gu.user_id, gu.group_id");
   while ($row = mysql_fetch_array($result)) {
      $result_data = sql_q("SELECT p.function_id, p.read_access FROM permissions p, functions f WHERE p.function_id = f.function_id AND p.group_id = '$row[group_id]' AND f.module_id = p.module_id AND f.status = '1' AND p.module_id = '6'");
      while ($row_data = mysql_fetch_array($result_data)) {
     if ($row_data['read_access'] == 'Y') {
        $functions[$row_data['function_id']] = $row_data['read_access'];
     }
      }
   }
//$select_status_pay="SELECT c.status FROM customers c , municipality m WHERE c.bulstat=m.bulstat";
//$result_status_pay=sql_q($select_status_pay);
//$row_status_pay=mysql_fetch_array($result_status_pay);
//$pay_status=$row_status_pay['status'];
//echo "<input type='hidden' id='pay_status' value='$pay_status'>";
//if ($pay_status==1){

//echo "<script language='JavaScript'>if (document.getElementById('pay_status').value ==1) { window.showModalDialog('../masage_pay.html','', 'dialogWidth:400px; dialogHeight:200px; status:no; center:yes; help:no') }</script>";

//}
   echo "<script src='./templates/script/lozinge.js'></script>";
   echo "<script language='JavaScript'>startMainMenu('', 0, 0, 2, 0, 0)</script>";
?>
      <script language='JavaScript'>
     mainMenuItem("../images/lozinge_b1",".gif",26,145,"javascript:;","","Регистрация на сдружение",2,2,"lozinge_plain");
     mainMenuItem("../images/lozinge_b2",".gif",26,145,"javascript:;","","Справки",2,2,"lozinge_plain");
     //mainMenuItem("../images/lozinge_b4",".gif",26,145,"javascript:;","","Системни",2,2,"lozinge_plain");
    // mainMenuItem("../images/lozinge_b3",".gif",26,145,"javascript:location.href='index.php';","","Начало",2,2,"lozinge_plain");
      </script>
<?php
   echo "<script language='JavaScript'>endMainMenu('',0,0);</script>";

   echo "<script language='JavaScript'>startSubmenu('../images/lozinge_b1', 'lozinge_menu', 145);</script>";
   if ($functions[2] == 'Y') {
?>
      <script language='JavaScript'>
     submenuItem("Регистриране на сдружение","register.php","","lozinge_plain");
      </script>
<?php
   }
   if ($functions[3] == 'Y') {
?>
      <script language='JavaScript'>
     submenuItem("Редакция на НП","search.php?edit=1&gl_fish=0","","lozinge_plain");
      </script>
<?php
   }
if ($functions[68] == 'Y') {
?>
      <script language='JavaScript'>
     submenuItem("Редакция на глоба с фиш","search.php?edit=1&gl_fish=1","","lozinge_plain");
      </script>
<?php
   }

if ($functions[17] == 'Y') {

?>


      <script language='JavaScript'>
     submenuItem(" Издаване на глоба с фиш-ново","globaFish.php?gl_fish=2","","lozinge_plain");
      </script>
   
   <?php
   }

if ($functions[18] == 'Y') {
?>
      <script language='JavaScript'>
     submenuItem("Редакция на глоба с фиш-ново","search.php?edit=1&gl_fish=2","","lozinge_plain");
      </script>
<?php
   }
   echo "<script language='JavaScript'>endSubmenu('../images/lozinge_b1');</script>";
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
   echo "<script language='JavaScript'>startSubmenu('../images/lozinge_b2', 'lozinge_menu', 145);</script>";
   if ($functions[4] == 'Y') {
?>
      <script language='JavaScript'>
     submenuItem("Сграда-Сдружение-Статус","#;","","lozinge_plain", OpenWindow('VerifyNPEE.php?id=8', '', 410, 470));
      </script>
<?php
   }
   
   if ($functions[5] == 'Y') {
?>
     <script language='JavaScript'>submenuItem("Регистрирани сдружения","#;","","lozinge_plain", OpenWindow('verify_dialog.php?id=9', '', 420, 290)); </script>
<?php
   }
   
   if ($functions[6] == 'Y') {
?>
     <script language='JavaScript'>//submenuItem("Брой сдружения- обобщена","#;","","lozinge_plain", OpenWindow('verify_dialog.php?id=10', '', 420, 410)); </script>
  <?php
   }
   if ($functions[7] == 'Y') {
?>
      <script language='JavaScript'>submenuItem("Сдружения регистрирани за целите на ЗЕЕ","#;","","lozinge_plain", OpenWindow('VerifyContr.php', '', '420', '410')); </script>
<?php
   }
    if ($functions[16] == 'Y') {
?>
      <script language='JavaScript'>submenuItem("Издадени покани за доброволно изпълнение","#;","","lozinge_plain", OpenWindow('pokana_spravka.php', '', '1024', '768')); </script>
<?php
   }
if ($functions[8] == 'Y') {

?>
<script language='JavaScript'>submenuItem("Генериране на html документ за сайт","#;","","lozinge_plain", OpenWindow('maket.php', '', '1024', '768'));</script>
<?php
   }
   echo "<script language='JavaScript'>endSubmenu('../images/lozinge_b2');</script>";
   
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
   echo "<script language='JavaScript'>startSubmenu('../images/lozinge_b4', 'lozinge_menu', 145);</script>";
   if ($functions[77] == 'Y') {
   	
	    ?><script language='JavaScript'>submenuItem("Номенклатури","#;","","lozinge_plain", OpenWindow('ranges/index.html', '', 800, 600)); </script><?
		}
if ($functions[8] == 'Y') {

?>

<script language='JavaScript'>
     submenuItem("Схеми лихви НП","Shemi.php?","","lozinge_plain");
      </script>
      <!--<script language='JavaScript'>
     submenuItem("Схеми НП","#;","","lozinge_plain", OpenWindow('Shemi_data.php', '', 580, 320));
      </script>-->
<?php
   }
   
   if ($functions[10] == 'Y') {

?>


      <script language='JavaScript'>
     submenuItem("Избор шаблон за печат","#;","","lozinge_plain", OpenWindow('Shemi_data.php', '', 580, 320));
      </script>
<?php
   }
   
    if ($functions[11] == 'Y') {

?>


      <script language='JavaScript'>
     submenuItem("Прехвърляне на наказателно/глоба","#;","","lozinge_plain", OpenWindow('transfer_nakazp.php', '', 380, 320));
      </script>
<?php
   }
   if ($functions[13] == 'Y') {

?>


      <script language='JavaScript'>
     submenuItem("Уведомително писмо","#;","","lozinge_plain", OpenWindow('verify_dialog.php?flag_file=2', '', 710, 420));
      </script>
<?php
   }
   if ($functions[15] == 'Y') {

?>


      <script language='JavaScript'>
     submenuItem("Покана за доброволно изпълнение","#;","","lozinge_plain", OpenWindow('verify_dialog_pokana.php', '', 510, 920));
      </script>
<?php
   }
   echo "<script language='JavaScript'>endSubmenu('../images/lozinge_b4');</script>";
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  echo "<script language='JavaScript'>loc='';</script>";

?>