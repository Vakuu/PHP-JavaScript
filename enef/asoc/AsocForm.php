	<legend>Данни за сдружението:</legend>
		<table border="1" name="association_table" id="association_table">
			<tr>
				<td>Регистрационен номер:<span class="red">*</span></td>
				<td>
					<input type="hidden" name="hid_asoc_id" id="hid_asoc_id"/>
					<span id="esso2"></span>					
					<input type="text" class="cyrullic" name="asoc_numbh" id="asoc_numbh"/>
				</td>
				<td>
					Булстат:
				</td>
				<td>
					<input type="text" class="cyrullic" name="bulstath" id="bulstath"/>
				</td>
			</tr>
			<tr>
				<td>Дата на регистрация:<span class="red">*</span></td>
				<td>
					<input type="text" name="date_of_create" maxlength="10" style="width:70px;" value="<?=date('d-m-Y');?>" id="date_of_create"/>
				</td>
				<td>
					Срок на учредяване:<span class="red">*</span>
				</td>
				<td>
					<!--<input type="text" name="srok" value="" id="srok" />години-->
                  <?php
                   $sql_srok = "SELECT * 
			FROM elements 
			WHERE nom_code = '53'";
	$getsrok = mysql_query($sql_srok) or die(mysql_error());
	$selsrok = "<select name='srok' id='srok'>";
	$selsrok .= "<option></option>";
    while($row_srok = mysql_fetch_assoc($getsrok))
	{	$selsrok .= "<option value='" . $row_srok['cod_cod'] . "'>". $row_srok['cod_name'] . "</option>";
	}
	$selsrok .= "</select>";
	echo $selsrok;
    ?>
				</td>
			</tr>
			<tr>
				<td>Наименование:<span class="red">*</span></td>
				<td>
					<textarea class="cyrullic" name="asoc_name" id="asoc_name" cols="25" rows="3" ></textarea>
				</td>
				<td>Адрес:<span class="red">*</span>
				<br/>
				<br/>
				Вход/ове:<span class="red">*</span></td>
				<td id="adr">
					<span id="asoc_address"></span>
					<br />
					<input type="text" class="cyrullica" onkeyup="this.value = this.value.toUpperCase();FORM_CHANGEa = true;" name="entries" value="" id="entries" >(А,Б,Г)
				</td>
			</tr>
			<tr>
				<td>Блок-секции:</td>
				<td>
					<input type="text" name="bl_secs" value="" id="bl_secs" onkeypress="ValidateKeyNumb(this, 44)">(2,3,5)
				</td>
				<td>Идеални части в %:<span class="red">*</span></td>
				<td>
					<input type="text" onkeyup="if(this.value > 100){alert('Въведете стойност по-малка от 100!');this.value = '';return false;}else{if(this.value.match(/^\d{0,3}(\,\d{0,2}){0,1}$/)){}else{alert('Моля въведете цифри или използвайте запетая вместо точка за разделител!');this.value = '';return false;}}" maxlength="6" name="asoc_ideal_parts" id="asoc_ideal_parts" value="" style="width: 40px;"/> %
				</td>
			</tr>
			<tr>
				<td>Дата на вписване в публичния регистър:<span class="red">*</span></td>
				<td>
					<input type="text" name="date_of_entry" style="width:70px;" value="<?=date('d-m-Y');?>" id="date_of_entry"/>
				</td>
				<td>Начин на представителство:<span class="red">*</span></td>
				<td id="predstavitelstvo">
                    <?
	$sqlpr = "SELECT * 
			FROM elements 
			WHERE nom_code = '03'";
	$respr = mysql_query($sqlpr) or die(mysql_error());
	$selpr = "<select name='predst' id='predst'>";
	$selpr .= "<option>1</option>";
    while($rowpr = mysql_fetch_assoc($respr))
	{	$selpr .= "<option value='" . $rowpr['cod_cod'] . "'>". $rowpr['cod_name'] . "</option>";
	}
	$selpr .= "</select>";
	echo $selpr;
?>
				</td>
			</tr>
			<tr>
				<td >Предмет на дейност:<span class="red">*</span></td>
				<td colspan="3" id="deinost">
					<select id="predmet" name="predmet"></select>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<nobr>
						<input type="button" style="font-weight:bold; width: 33%" id="save_asoca" name="save_asoca" value="Запис като ново" onclick="validateForm('asoc_form', this.name);" />
						<input type="button" style="font-weight:bold; width: 33%" id="curedita" name="curedita" value="Редактирай текущото" disabled />
						<input type="button" style="font-weight:bold; width: 33%" id="curdela" name="curdela" value="Изтриване на сдружение" onclick="delete_asoc();" disabled />
					</nobr>
				</td>
			</tr>
			<tr>
				<td colspan="4">
            <!--	<input class = "button" style="top:2px;   left:508px; width:106px;" type="button" id="b11" value="Файлове >>" onclick="getAttachedFiles()" disabled >
					<input class="text" style="top:2px; left:615px; width:26px; background-color:#ff00ff; border:solid 1px black; font-weight:bold; height:19px; text-align:center" type="text" id="attached" value="0">
				</td>
				<td colspan="2">
					<input type="file" name="file" id="file" size="40px">
    				<input type="button" name="b5" value="Прикачи" id="b5" onclick="petko();" disabled ><br>
<input class = "button" style="top:2px;   left:370px; width:138px;" type="button" id="b5" value="Прикачване на файл" onclick="attachFile();" disabled >>
				-->
                <input class = "button" type="button" id="b5" style="width:135px;" value="Прикачване на файл" onclick="attachFile();">
                <input class = "button" type="button" id="b11" style="width:80px;" value="Файлове >>" onclick="getAttachedFiles()">
				<input class="text" style="top:2px; left:615px; width:26px; background-color:#ff00ff; border:solid 1px black; font-weight:bold; height:19px; text-align:center" id="attached" value="0" />
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div>
						<iframe class="popup" style="display:none;" id="popup3" name="popup3"></iframe>
					</div>
				</td>
			</tr>
		</table>