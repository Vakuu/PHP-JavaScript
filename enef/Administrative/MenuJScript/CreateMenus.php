<?
include("../inc/conf.php");

  echo "<script src='MenuJScript/lozinge.js'></script>";
  echo "<script language='JavaScript'>startMainMenu('',0,0,2,0,0)</script>";
?>
  <script language='JavaScript'>
    mainMenuItem("MenuImages/lozinge_b1",".gif",26,145,"javascript:;","","Администриране",2,2,"lozinge_plain");
    mainMenuItem("MenuImages/lozinge_b2",".gif",26,145,"javascript:;","","Системни",2,2,"lozinge_plain");
    mainMenuItem("MenuImages/lozinge_b3",".gif",26,145,"javascript:;","","Справки",2,2,"lozinge_plain");
    endMainMenu("",0,0);
  </script>
<?
  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
  ?>
  <script language='JavaScript'>
    startSubmenu("MenuImages/lozinge_b1","lozinge_menu",145);
    submenuItem("Групи","javascript: window.location.href='Groups.php';","","lozinge_plain");
    submenuItem("Потребители","javascript: window.location.href='Users.php';","","lozinge_plain");
    endSubmenu("MenuImages/lozinge_b1");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    startSubmenu("MenuImages/lozinge_b2","lozinge_menu",145);
    submenuItem("Номенклатури","javascript:window.location.href='../Ranges/index.php';","","lozinge_plain");
    submenuItem("-","#","","lozinge_plain");
    submenuItem("Mysql Admin","javascript: top.location.href='sql.php';","","lozinge_plain");
    submenuItem("-","#","","lozinge_plain");
	submenuItem("Актуализиране", "javascript: top.location.href='./Systems/Updates.php'", "", "lozinge_plain");
	submenuItem("Архивиране","javascript: top.location.href='./mysqlbackup/index.php';","","lozinge_plain");
/*
    submenuItem("Приключени периоди","javascript:;","","lozinge_plain");
   
    submenuItem("Деархивиране","javascript:;","","lozinge_plain");
*/
    endSubmenu("MenuImages/lozinge_b2");

    startSubmenu('MenuImages/lozinge_b2_1', 'lozinge_menu', 145);
    submenuItem("<?echo $show_a?> Вариант А (проста)","#;","","lozinge_plain", OpenWindow('Systems/CalcInterest.php?interest_mode=1', '', 550, 80));
    submenuItem(" <?echo $show_b?> Вариант Б (капитализирана)","#;","","lozinge_plain", OpenWindow('Systems/CalcInterest.php?interest_mode=2', '', 580, 80));
    endSubmenu('MenuImages/lozinge_b2');

    endSubmenu("MenuImages/lozinge_b2");
    startSubmenu('MenuImages/lozinge_b2_2', 'lozinge_menu', 145);
	submenuItem("Добавяне в календара","#;","","lozinge_plain", OpenWindow('calendar_new.php', '', 800, 640));
	submenuItem("Изв. календар","#;","","lozinge_plain", OpenWindow('calendar_update.php', '', 800, 640));
    endSubmenu('MenuImages/lozinge_b2');
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    startSubmenu("MenuImages/lozinge_b3","lozinge_menu",145);
    submenuItem("Номенклатури","#;","","lozinge_plain", OpenWindow('VerifyRanges.php?id=1', '', 540, 420));
    endSubmenu("MenuImages/lozinge_b3");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    loc="";
  </script>
  <?
  }
?>