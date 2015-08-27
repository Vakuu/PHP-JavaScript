<?php
  include("../inc/conf.php");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Избор на критерии</title>

  <script language="JavaScript" src="JFunctions.js"></script>
  <script language="JavaScript" src="../Control/js/calendarDateInput.js"></script>
</head>
<body background="Images/Stone.jpg" onload="fjournal.from_date.focus()">
  <form name="fjournal" method="post">
    <center><font size="4" color="blue">Избор на критерии за търсене</font></center>
    <table width="100%" height="94%">
      <tr valign="top">
        <td height="90%">
          <table align="center" width="100%" border="1">
            <tr>
              <td width="30%">Период:</td>
             
              <td width="70%">
             
                от <input type="text" name="from_date" id="from_date" size="10" value="00-00-0000" readonly>&nbsp;
              <!--  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(document.getElementById("date_"), document.getElementById("from_date"));return false;" >
                <img hspace="3px" class="PopcalTrigger" align="absmiddle" src="../libs/DateRange/calbtn.gif" width="30" height="20" border="0" alt="">
                <iframe width=120 height=122 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="../libs/DateRange/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>-->
                	<a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('from_date'));return false;" >
        	<img hspace="3px" class="PopcalTrigger" align="absmiddle" src="../Control/js/DateRange/calbtn.gif" width="30" height="20" border="0" alt=""></a>
        	<iframe width=34 height=22 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="../Control/js/DateRange/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visiblity; z-index:999; position:absolute; top:-500px; left:-500px;">
			</iframe>
             &nbsp;&nbsp;&nbsp;&nbsp;   до <input type="text" name="to_date" size="10" value="00-00-0000" readonly>&nbsp;
                	<a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('to_date'));return false;" >
        	<img hspace="3px" class="PopcalTrigger" align="absmiddle" src="../Control/js/DateRange/calbtn.gif" width="30" height="20" border="0" alt=""></a>
        	<iframe width=34 height=22 name="gToday1:contrast:agenda.js" id="gToday1:contrast:agenda.js" src="../Control/js/DateRange/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visiblity; z-index:999; position:absolute; top:-500px; left:-500px;">
			</iframe>
              </td>
            </tr>
            
            
            
            <tr>
              <td>Оператор:</td>
              <td>
                <select name='clerk_numb' style='width:100%'>
                  <option value=''></option>
                  <?
                    $result = sql_q("SELECT distinct u.id, u.full_name FROM users u, balances_history b WHERE u.id=b.user_id ORDER BY u.full_name");
                    while ($row = mysql_fetch_array($result)) {
                      echo "<option value='".$row['id']."'>".$row['full_name']."</option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
          </table>
          <hr>
         <!-- <table align="center" width="100%" border="1">
            <tr>
              <td width="34%">Сортиране по:</td>
              <td width="64%">
                <select name="sort_by" style="width:100%">
                  <option value="1">Номер</option>
                  <option value="2">Състояние</option>
                  <option value="3">Получател</option>
                </select>
              </td>
            </tr>
          </table>-->
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="button" name="search" value="Търсене" onclick="OpenWindow('Inquiries/InquireBalanceInfo.php?clerk_numb=' + clerk_numb.value +'&from_date=' + from_date.value + '&to_date=' + to_date.value, '',1284 , 768); window.close();">
          <input type="button" name="exit" value="Изход" onclick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

