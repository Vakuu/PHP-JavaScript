<?php
include("../../inc/conf.php");
$placement = $_POST['placement'];
if($placement !='')
        { 
            sql_q("Update municipality set placement ='$placement' where placement ='-1'");
            sql_q ("Update users set placement='$placement' where placement=''");
        }


?>
<html>
<head><title>Избор на главна община</title></head>
<body>
<form method="post" name="kingdom" action="">
<table><th>Посочете общинския център:</th>
<tr>
  <td> 
  <input type="hidden" name="place_hidd" id="place_hid" />
  <select name="placement" id="placement">
                <?php 
                $naselm = "SELECT * FROM elements WHERE nom_code ='06' ORDER BY cod_cod ASC"; //Petko Mihailov-programist Dobaveno vuv vruzka na kasieri s naseleni mesta
                $get_code_name = sql_q($naselm);
                while( $row2=mysql_fetch_array($get_code_name))
                {
                echo "<option value ='".$row2['cod_cod']."'".$selected.">".$row2['cod_name']."</option>";   
                }
                ?>
                </select>
                </td><td><input type="submit" value="Запис" name="save" onclick="window.close(); "/></td>
                </tr>



</table>
</form>
</body>
</html>