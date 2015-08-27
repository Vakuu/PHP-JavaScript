<?php
  include("../inc/conf.php");

  $range_code = $_GET['range_code'];
  $nom_code = $_POST['nom_code'];
  $nom_name = $_POST['nom_name'];
  $nom_flag = $_POST['nom_flag'];

  if ($_POST['add_range']) {
    $result = sql_q("SELECT * FROM ranges WHERE nom_cod = '$nom_code'");
    $row = mysql_fetch_array($result);

    if (!empty($row)) {      
      echo "<script language='JavaScript'> alert('Грешка! Има въведена номенклатура с този код.'); </script>";
    } else if (empty($nom_code) || empty($nom_name)) {
      echo "<script language='JavaScript'> alert('Грешка! Не са въведени код или наименование.'); </script>";
    } else {
      if ($nom_flag)
        sql_q("INSERT INTO ranges VALUES('$nom_code', '$nom_name', 2)");
      else
        sql_q("INSERT INTO ranges VALUES('$nom_code', '$nom_name', 1)");
    }
  } else if ($_POST['edit_range']) {
    if (empty($range_code)) {
      echo "<script language='JavaScript'> alert('Грешка! Не сте избрали номенклатура.'); </script>";
    } else if (empty($nom_code) || empty($nom_name)) {
      echo "<script language='JavaScript'> alert('Грешка! Не са въведени код или наименование.'); </script>";
    } else {
      if ($nom_flag) {
        sql_q("UPDATE ranges SET nom_cod = '$nom_code', nom_name = '$nom_name', nom_flag = 2 WHERE nom_cod = '$range_code'");
      } else {
        sql_q("UPDATE ranges SET nom_cod = '$nom_code', nom_name = '$nom_name', nom_flag = 1 WHERE nom_cod = '$range_code'");
      }
      sql_q("UPDATE elements SET nom_code = '$nom_code' WHERE nom_code = '$range_code'");
    } 
  } else if ($_POST['del_range']) {
    if (empty($range_code)) {
      echo "<script language='JavaScript'> alert('Грешка! Не е посочено наименование.'); </script>";
    } else {
      sql_q("DELETE FROM ranges WHERE nom_cod = '$range_code'");
      sql_q("DELETE FROM elements WHERE nom_code = '$range_code'");
    }
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Номенклатури</title>
  
  <script language="JavaScript">
    function Refresh(){
      window.location.href='rangesdata.php';
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
 width: 95%;
 height: 80%; 
}
</style>  
</head>
<body>
  <center><font size="3">Номенклатури</font></center><br>
  <hr size="1">
  <select name="range_code" class="choice_element" size="20" onchange="window.location.href='rangesdata.php ?' + 'range_code=' + window.range_code.value">
  <?
    $result = sql_q("SELECT * FROM ranges ORDER BY nom_cod ASC");
    while ($row = mysql_fetch_array($result)) {
    ?><option value="<?php echo $row['nom_cod'] ?>"><?php echo $row['nom_cod']." - ".$row['nom_name']?></option><?
    }
  ?>  
  </select>
  <?
    $result = sql_q("SELECT * FROM ranges WHERE nom_cod = '$range_code'");
    $row = mysql_fetch_array($result);
  ?>
  <form method="post" onsubmit="Refresh()">
    <table width="100%" border="0">
      <tr>
        <td width="10%">
          Код: <input type="text" name="nom_code" value="<?php echo $row["nom_cod"] ?>" size="6%">
        </td>
        <td width="50%">
          Номенклатура: <input type="text" name="nom_name" value="<?php echo $row["nom_name"] ?>" size="35%">
        </td>
        <td width="40%">
        <? if ($row["nom_flag"] == 2) { ?>
          Достъп до елементи: <input type="checkbox" name="nom_flag" size="1%" checked>
        <? } else { ?>
          Достъп до елементи: <input type="checkbox" name="nom_flag" size="1%">
        <? } ?>
        </td>
      </tr>
    </table>
    <br>
    <hr>
    <table width="100%" border="0">
      <tr>
        <td align="left">
        <?
         $user_name = $HTTP_COOKIE_VARS["user"];

         $result = sql_q("SELECT * FROM rights WHERE user_name ='$user_name'");
         $row = mysql_fetch_array($result);

         switch ($row["right_func"]) {
           case 3:
           ?>
             <input type="submit" name="add_range" value="Добавяне">
             <input type="submit" name="edit_range" value="Редактиране">
             <input type="submit" name="del_range" value="Изтриване">
           <?
           break;
           case 4:
           ?>
             <input type="submit" name="add_range" value="Добавяне" disabled>
             <input type="submit" name="edit_range" value="Редактиране">
             <input type="submit" name="del_range" value="Изтриване" disabled>
           <?
           break;
           case 5:
           ?>
             <input type="submit" name="add_range" value="Добавяне">
             <input type="submit" name="edit_range" value="Редактиране">
             <input type="submit" name="del_range" value="Изтриване" disabled>
           <?
           break;
           case 6:
           ?>
             <input type="submit" name="add_range" value="Добавяне">
             <input type="submit" name="edit_range" value="Редактиране" disabled>
             <input type="submit" name="del_range" value="Изтриване">
           <?
           break;
           case 7:
           ?>
             <input type="submit" name="add_range" value="Добавяне">
             <input type="submit" name="edit_range" value="Редактиране" disabled>
             <input type="submit" name="del_range" value="Изтриване"disabled>
           <?
           break;
         }
        ?>
        </td>
        <td align="right">
          <input type="button" value="Изход" onClick="window.close(); window.opener.location.href='Ranges.php'">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

