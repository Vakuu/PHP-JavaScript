<?php

/**
 * MySQL Backup Pro English translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - en.php
 * @access public
 **/
 
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";

$GONX["deleteconfirm"] = ' Сигурни ли сте, че искате да изтриете този файл ?\nНатиснете OK за да продължите.';

$GONX["header"] = '<html>
<head>
<title>'.$GONX["title"].'</title>
<style type="text/css" media="screen">@import "style.css";</style>
<script language="JavaScript" type="text/javascript">
<!--
function ConfirmDelete() {
	return confirm("'.$GONX["deleteconfirm"].'");
}
//-->
</script>
</head>
<body>
';

// Home page content
$GONX['homepage'] = "<b>".$GONX["title"]."</b> Този модул позволява пълно архивиране на базите данни за MySQL и тяхното възстановяване.<br/>
			Изпозлването на приложението е изключително лесно :
			<ul>
			<li>За да създадете backup само кликнете връзката <a href=\"?go=create\" class=tab-g>Създаване на Backup(архив)</a>.</li>
			<li>Може да използвате <a href=\"?go=list\" class=tab-g>list</a> наличните DB Backup-и (архиви) за да възстановите копие на базата данни.</li>
			</ul>
			<br/><br/>
			Използвана в момента база данни: <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " е инсталиран";
$GONX["notinstalled"] = " не е инсталиран";
$GONX["compression"] = "PHP модули за компресия";
$GONX["autherror"] = " Моля въведете коректно потребитеско име и парола";
$GONX["home"] = "Начало";
$GONX["create"] = "Създаване на Архив";
$GONX["list"] = "Списък архиви";
$GONX["optimize"] = "Оптимизиране";
$GONX["analyze"] = "Анализи DB";
$GONX["repair"] = "Поправка DB";
$GONX["monitor"] = "Мониторинг";
$GONX["logout"] = "Изход";
			
$GONX["backup"] = "Backup (архив) на";
$GONX["iscorrectcreat"] = "е коректно създаден в";
$GONX["iscorrectimport"] = "е коректно импортиран в базата данни";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;Изберете от наличните архивни файлове за импортиране";
$GONX["importbackupfile"] = "Или заредете файл от тук: ";
$GONX["delete"] = "Изтриване";
$GONX["nobckupfile"] = "Няма налични архивни файлове. Кликнете на <a href=\"?go=create\" class=tab-g>Създаване на Архив (Backup)</a> за създаване на архив (backup) на вашата DB";
$GONX["importbackup"] = "Import на архивен файл";
$GONX["importbackupdump"] = "Използване на MySQL Dump";
$GONX["configure"] = "Конфигуриране";
$GONX["configureapp"] = "Конфигуриране на вашето приложение</b>";
$GONX["totalbackupsize"] = "Размер на Архивната (Backup) директория";
$GONX["chgdisplayorder"] = "Промени реда на подреждане";
$GONX["next"] = "Следващ";
$GONX["prev"] = "Предишен";

$GONX["structonly"] = "Само структура";
$GONX["checkall"] = "Избери всички";
$GONX["uncheckall"] = "Откажи всички";
$GONX["tablesmenuhelp"] = "<u>Помощ</u>  : Ако виждате <label>labels</label> това означава, че има промени в таблиците.";
$GONX["backupholedb"] = "Кликнете тук за да архивиране цялата база данни:";
$GONX["selecttables"] = "Или изберете таблици, който да архивирате от тук:";

$GONX["ignoredtables"] = "Игнорирай таблицата";
$GONX["reservedwords"] = "Запазени mysql думи";

?>