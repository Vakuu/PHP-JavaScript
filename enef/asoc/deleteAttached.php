 <?include("../inc/conf.php");;
 if (isset($_GET['asoc_id'])) $asoc_id=$_GET['asoc_id'];
 if (isset($_GET['attach_id'])) $attach_id=$_GET['attach_id'];
 //if (isset ($_GET['ans_id'])) $ans_id=$_GET['ans_id'];
 $rows=mysql_fetch_array(sql_q("SELECT * FROM attached_files WHERE asoc_id='".$_GET['asoc_id']."' AND attach_id = ".$attach_id));

 if (is_file($path.$rows['attach_dir'].$rows['attach_filename']))
 {
 // unlink($path.$rows['attach_dir'].$rows['attach_filename']);
 // $sql = "DELETE FROM attached_files WHERE asoc_id=".$asoc_id." AND attach_id = ".$attach_id;

 	$sql = "UPDATE attached_files SET dell_flag=1  WHERE asoc_id=".$asoc_id." AND attach_id = ".$attach_id;
  $res = sql_q($sql);
  //$res1=sql_q("UPDATE answers SET attach_id = 0  WHERE  attach_id = '".$attach_id."'  AND ans_id='".$ans_id."' ");
  $delete_flag = 1; 
 }
 else 
 	$delete_flag = 0;
 echo $delete_flag;
 ?>