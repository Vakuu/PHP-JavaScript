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
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro� ";

$GONX["deleteconfirm"] = ' ������� �� ���, �� ������ �� �������� ���� ���� ?\n��������� OK �� �� ����������.';

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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> ���� ����� ��������� ����� ���������� �� ������ ����� �� MySQL � ������� ��������������.<br/>
			������������ �� ������������ � ������������ ����� :
			<ul>
			<li>�� �� ��������� backup ���� �������� �������� <a href=\"?go=create\" class=tab-g>��������� �� Backup(�����)</a>.</li>
			<li>���� �� ���������� <a href=\"?go=list\" class=tab-g>list</a> ��������� DB Backup-� (������) �� �� ������������ ����� �� ������ �����.</li>
			</ul>
			<br/><br/>
			���������� � ������� ���� �����: <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " � ����������";
$GONX["notinstalled"] = " �� � ����������";
$GONX["compression"] = "PHP ������ �� ���������";
$GONX["autherror"] = " ���� �������� �������� ������������ ��� � ������";
$GONX["home"] = "������";
$GONX["create"] = "��������� �� �����";
$GONX["list"] = "������ ������";
$GONX["optimize"] = "������������";
$GONX["analyze"] = "������� DB";
$GONX["repair"] = "�������� DB";
$GONX["monitor"] = "����������";
$GONX["logout"] = "�����";
			
$GONX["backup"] = "Backup (�����) ��";
$GONX["iscorrectcreat"] = "� �������� �������� �";
$GONX["iscorrectimport"] = "� �������� ���������� � ������ �����";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;�������� �� ��������� ������� ������� �� �����������";
$GONX["importbackupfile"] = "��� �������� ���� �� ���: ";
$GONX["delete"] = "���������";
$GONX["nobckupfile"] = "���� ������� ������� �������. �������� �� <a href=\"?go=create\" class=tab-g>��������� �� ����� (Backup)</a> �� ��������� �� ����� (backup) �� ������ DB";
$GONX["importbackup"] = "Import �� ������� ����";
$GONX["importbackupdump"] = "���������� �� MySQL Dump";
$GONX["configure"] = "�������������";
$GONX["configureapp"] = "������������� �� ������ ����������</b>";
$GONX["totalbackupsize"] = "������ �� ��������� (Backup) ����������";
$GONX["chgdisplayorder"] = "������� ���� �� ����������";
$GONX["next"] = "�������";
$GONX["prev"] = "��������";

$GONX["structonly"] = "���� ���������";
$GONX["checkall"] = "������ ������";
$GONX["uncheckall"] = "������ ������";
$GONX["tablesmenuhelp"] = "<u>�����</u>  : ��� ������� <label>labels</label> ���� ��������, �� ��� ������� � ���������.";
$GONX["backupholedb"] = "�������� ��� �� �� ���������� ������ ���� �����:";
$GONX["selecttables"] = "��� �������� �������, ����� �� ���������� �� ���:";

$GONX["ignoredtables"] = "��������� ���������";
$GONX["reservedwords"] = "�������� mysql ����";

?>