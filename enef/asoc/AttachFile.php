<?
include("../inc/conf.php");
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
  <title>Прикачване на документ</title>
  <script type="text/javascript" src="js/functions.js"></script>
  <link rel="stylesheet" href="css/register_bib.css"/>
  <!--<script type="text/javascript" src="Delo.js"></script>!-->
</head>
<body style="background-color:#cecac0;" >
  <form action="AttachFile.php?submit=1&asoc_id=<?echo $_GET['asoc_id'];?>&build_id=<?echo $_GET['build_id'];?>" method="post" enctype="multipart/form-data">
<br />
Описание на файла:<input type="text" name="file_descr" value="" id="file_descr" />
	<input type="file" name="file" id="file" size="80px">
    <input type="submit" name="submit" value="Прикачи/ Запиши">
    <input type="button" id="exit" value="Изход" onclick="parent.document.getElementById('popup3').style.display='none'">
<?
	if ($_GET['submit'])
	{	$year=date("Y");	
		//$result=sql_q("SELECT date_reg FROM rkk WHERE rkk_id='".$_GET['rkk_id']."'");
		//$date_reg	= mysql_fetch_row($result);
		$day=date("Y-m-d"); 
		$username=$_SESSION['username'];
		$result=sql_q("SELECT id FROM users WHERE username='$username'");
		$user_id=mysql_fetch_row($result);
		$user_id=$user_id[0];
		if (!is_dir($path.$year)) mkdir($path.$year);
		if (!is_dir($path.$year."/".$day)) mkdir($path.$year."/".$day);
		//$dir=$path.$year."/".$day."/".$_GET['asco_id']."/";
		$dir=$path.$year."/".$day."/".$_GET['asoc_id']."/";
		$short_dir=$year."/".$day."/".$_GET['asoc_id']."/";
		if (!is_dir($dir))mkdir($dir);
		$dir.="/";
		$filename=$_FILES["file"]["name"];
		$filesize = $_FILES["file"]["size"];
///////////////////////////////////////////////////////////////////////////////////////////////////////////
		$err_num = $_FILES["file"]["error"];
		switch($err_num){
			case 1:
				$error = "Файлът е по-голям от 128 Mb";
					break;
			case 2:
				$error = "Файлът е по-голям от зададения размер";
					break;
			case 3:
				$error = "Файлът се прикачи частично";
					break;
			case 4:
				$error = "Не сте избрали файл!";
					break;
			case 6:
				$error = "Липсва временната директория";
					break;
			case 7:
				$error = "Файлът не можа да се запише на диска";
					break;
			case 8:
				$error = "PHP разширение спря прикачването на файла";
					break;
			default: 
				$error = "Свържете се с Брайт Комплекс АТ";
		}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
      if ($_FILES["file"]["error"] > 0)
		{	?><script type="text/javascript">alert('Грешка: <?=$error?>')</script><?;
		}else
		{	if (file_exists($dir.$filename))
			{	?><script type="text/javascript">alert('Грешка: Файл с име "<?=$filename?>" вече съществува!')</script><?;
			}else
			{	$comment=$_POST["file_descr"];
				move_uploaded_file($_FILES["file"]["tmp_name"],$dir.$filename);
				sql_q("INSERT INTO attached_files (asoc_id,uploader_id,filesize,attach_filename,attach_dir, attach_comment)
		                                  VALUES ('".$_GET['asoc_id']."','$user_id','$filesize','$filename','$short_dir','$comment')");
				$num_rows=mysql_num_rows(sql_q("SELECT * FROM attached_files WHERE asoc_id='".$_GET['asoc_id']."' AND dell_flag=0 "));                                  
				?> 
				<script type="text/javascript"> 
					parent.document.getElementById('attached').value =<?=$num_rows?>;
					parent.document.getElementById('b11').disabled=false;
					alert('Успешен запис!');		    
					parent.document.getElementById('popup3').style.display='none';
				</script>
				<?
			}
		}
	}
?>
  </form>
</body>  
</html>