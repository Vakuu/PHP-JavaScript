<?
include("../inc/conf.php");

  echo "<script src='MenuJScript/lozinge.js'></script>";
  echo "<script language='JavaScript'>startMainMenu('',0,0,2,0,0)</script>";
?>
  <script language='JavaScript'>
    mainMenuItem("MenuImages/lozinge_b1",".gif",26,145,"javascript:;","","��������������",2,2,"lozinge_plain");
    mainMenuItem("MenuImages/lozinge_b2",".gif",26,145,"javascript:;","","��������",2,2,"lozinge_plain");
    mainMenuItem("MenuImages/lozinge_b3",".gif",26,145,"javascript:;","","�������",2,2,"lozinge_plain");
    endMainMenu("",0,0);
  </script>
<?
  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
  ?>
  <script language='JavaScript'>
    startSubmenu("MenuImages/lozinge_b1","lozinge_menu",145);
    submenuItem("�����","javascript: window.location.href='Groups.php';","","lozinge_plain");
    submenuItem("�����������","javascript: window.location.href='Users.php';","","lozinge_plain");
    endSubmenu("MenuImages/lozinge_b1");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    startSubmenu("MenuImages/lozinge_b2","lozinge_menu",145);
    submenuItem("������������","javascript:window.location.href='../Ranges/index.php';","","lozinge_plain");
    submenuItem("-","#","","lozinge_plain");
    submenuItem("Mysql Admin","javascript: top.location.href='sql.php';","","lozinge_plain");
    submenuItem("-","#","","lozinge_plain");
	submenuItem("�������������", "javascript: top.location.href='./Systems/Updates.php'", "", "lozinge_plain");
	submenuItem("����������","javascript: top.location.href='./mysqlbackup/index.php';","","lozinge_plain");
/*
    submenuItem("���������� �������","javascript:;","","lozinge_plain");
   
    submenuItem("������������","javascript:;","","lozinge_plain");
*/
    endSubmenu("MenuImages/lozinge_b2");

    startSubmenu('MenuImages/lozinge_b2_1', 'lozinge_menu', 145);
    submenuItem("<?echo $show_a?> ������� � (������)","#;","","lozinge_plain", OpenWindow('Systems/CalcInterest.php?interest_mode=1', '', 550, 80));
    submenuItem(" <?echo $show_b?> ������� � (��������������)","#;","","lozinge_plain", OpenWindow('Systems/CalcInterest.php?interest_mode=2', '', 580, 80));
    endSubmenu('MenuImages/lozinge_b2');

    endSubmenu("MenuImages/lozinge_b2");
    startSubmenu('MenuImages/lozinge_b2_2', 'lozinge_menu', 145);
	submenuItem("�������� � ���������","#;","","lozinge_plain", OpenWindow('calendar_new.php', '', 800, 640));
	submenuItem("���. ��������","#;","","lozinge_plain", OpenWindow('calendar_update.php', '', 800, 640));
    endSubmenu('MenuImages/lozinge_b2');
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    startSubmenu("MenuImages/lozinge_b3","lozinge_menu",145);
    submenuItem("������������","#;","","lozinge_plain", OpenWindow('VerifyRanges.php?id=1', '', 540, 420));
    endSubmenu("MenuImages/lozinge_b3");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    loc="";
  </script>
  <?
  }
?>