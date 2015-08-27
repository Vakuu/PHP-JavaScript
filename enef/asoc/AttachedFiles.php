<?
  include("../inc/conf.php");
  $user_name=$_SESSION['username'];
	$user_workorhome=$_SESSION['status'];
 $query=mysql_fetch_row(sql_q("SELECT id FROM users WHERE username='$user_name'"));
  $user_id=$query[0];
  $admin_query="select * from group_users where user_id='".$user_id."' and group_id=1";
  $res_admin_query=sql_q($admin_query);
  if (mysql_num_rows($res_admin_query)>0)
  {
	$admin=1;
}
  $asoc_id=$_GET['asoc_id'];
  if (isset($_GET['flag'])) $flag=$_GET['flag'];
  
?>
   
<html> 
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
  <title>Регистрация/Актуализация на документи</title>
  <script type="text/javascript" src="js/functions.js"></script>
 <script type="text/javascript">
 function countAttachedFiles(asoc_id, flag)
 {
 	  var oXMLHttp = createXMLHttp();
 	  oXMLHttp.open("get", "getAttachedFiles.php?asoc_id="+asoc_id, true);
 	  oXMLHttp.onreadystatechange = function(){
 			  if(oXMLHttp.readyState == 4){
 				  if(oXMLHttp.status == 200){
 	  				if (flag==1) var ele = parent.document.getElementById('attached');
 	  				else{  
 	  				var ele = parent.document.popup.document.getElementById('attached');
 	  				}
 	  				ele.value = oXMLHttp.responseText;	
 				  } 
 				  else {alert(oXMLHttp.statusText);}
 			  }
 	  }
 	  oXMLHttp.send(null);	
 }

function deleteAttached(asoc_id, attach_id, flag)
{
	var oXMLHttp = createXMLHttp();
	oXMLHttp.open("get", "deleteAttached.php?asoc_id="+asoc_id+"&attach_id="+attach_id, true);
	oXMLHttp.onreadystatechange = function(){
		if(oXMLHttp.readyState == 4){
			if(oXMLHttp.status == 200){ 
				var delete_flag=oXMLHttp.responseText;
				if (delete_flag!=0)
				{	alert('Файлът е изтрит успешно!');
					countAttachedFiles(asoc_id, '0');
				}
				else alert('Файлът не е изтрит!');
				popup('AttachedFiles.php?asoc_id='+asoc_id+'&flag='+flag ,'popup3', 0, 0, '100%', '');
			}
			else
			{	alert('Файлът не е изтрит!');
			}
		}
	}
	oXMLHttp.send(null);	
}
 </script>
  <style type="text/css">
	input.text {font-family:MS Sans Serif; font-size:9px; position:absolute;}
	input.button {font-family:MS Sans Serif;font-size: 9px; background-color: #cecac0; position:absolute;}
	input.button1 {font-family:MS Sans Serif;font-size: 9px; background-color: #cecac0; position:relative }
	td.header{
	 border-style: solid;	
	 border-width: 1px; text-align: center;
	 font-size: 10pt;
	 font-style:italic;
	 font-weight:bold;
	 color:#FFFFFF;
	 text-align:center;
	 background-color:gray;
	}
	td.content{
	 border-style: solid;	
	 border-width: 1px; text-align: center;
	 font-size: 11pt;
	 font-style:normal;
	 text-align:left;
	}
  </style>
</head>
<body style="background-color:#c0c0c0">   
  <input class = "button" style="top:2px;   left:2px;   width:92px;"  type="button" id="exit" value="Изход" onclick="parent.document.getElementById('popup3').style.display='none';countAttachedFiles(<?=$_GET['asoc_id']?>, <?=$flag?>)">
  <table style="width:100%;">
  <?
  $result = sql_q("SELECT * FROM attached_files WHERE asoc_id = '".$asoc_id."' AND dell_flag=0 ORDER BY attach_timestamp");
  $html_options = "Прикачен файл: <a href='".$url.$row['attach_dir'].$row['attach_filename']."' target='_blank'>".$row['attach_filename']."</a>";
    echo "<tr><td  style='width:20%;' class='header'>Дата/час:</td>
    		  <td  style='width:15%;' class='header'>Прикачил:</td>
    		  <td  style='width:55%;' class='header'>Файл:</td>
    		 <td  style='width:10%;' class='header'>Размер:</td>
              <td  style='width:10%;' class='header'>&nbsp;</td>";
    while ($row=mysql_fetch_array($result)){
	  $full_name=mysql_fetch_array(sql_q("SELECT full_name FROM users WHERE id='".$row['uploader_id']."'"));
	  
      $filesize_in_KB= (int)(($row['filesize'])/1024);
      $filesizepr = $filesize_in_KB;
      $text = ' KB';
      if($filesize_in_KB > 1024){
        $filesizepr = (int) ($filesizepr/1024);
        $text = ' MB';
      }
      echo "<tr><td  style='width:20%;' class='content'>";
	  echo $row['attach_timestamp'];
	  echo "</td>";
	  echo "<td  style='width:15%;' class='content'>".$full_name[0]."</td>";
	  echo "<td  style='width:55%;' class='content'>";
	  if ($user_workorhome==1)
	  {	echo "<a href='".$url2.$row['attach_dir'].$row['attach_filename']."' target='_blank'>".$row['attach_filename']."</a>";
	  }
	  else
	  {	echo "<a href='".$url.$row['attach_dir'].$row['attach_filename']."' target='_blank'>".$row['attach_filename']."</a>";
	  }
	  echo "</td>";
	  echo "<td  style='width:15%;' class='content'>".$filesizepr.$text."</td>";
      echo "<td style='width:10%;' class='content'>"; 
	  echo '&nbsp';
	  ?>
	  <input type="button" id="file_delete" name = "file_delete" class = "button1" style="width:72px; text-align:center;" value ="Изтриване"  onclick="if (confirm('Сигурни ли сте, че искате да изтриете избрания файл?')) { deleteAttached(<?echo $row['asoc_id']?>, <? echo $row['attach_id']?>,<? echo $flag ?>);}" <? if ($user_id!=$row['uploader_id'] && $admin!=1) echo "disabled";?>>
	  <?
	  echo '</td></tr>';
	} 
  ?>
 </table> 
</body>
</html>