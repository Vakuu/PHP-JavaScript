<table id="ppls" border="1">
	<tr>
		<td colspan="2" id="predstaviteli">
			<select name="type" id="type"></select>
				&nbsp; �� ��������� &nbsp; 
			<input type="text" name="sdruj_name" id="sdruj_name" />
		</td>
		<td rowspan="6" id="personstd">
			<select id="persons" name="persons" size="15" onchange="ifpeople();">
			</select>
		</td>
	</tr>
	<tr>
		<td  align="right">
			���:<span class="red">*</span>
		</td>
		<td>
			<input type="text" class="cyrullic" id="name" name="name" style="width: 200px;" />
		</td>
	</tr>
	<tr>
		<td align="right">
			�����:<span class="red">*</span>
		</td>
		<td>
			<textarea id="address" class="cyrullic" name="address" style="font-weight: bold; width: 300px; height: 50px;" ></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">
			�������:
		</td>
		<td>
			<input type="text" class="cyrullic" id="phone" name="phone" />
		</td>
	</tr>
	<tr>
		<td  align="right">
			�-����:
		</td>
		<td>
			<input type="text" id="email" name="email" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<nobr>
				<input type="button" id="saveRepresentator" style="font-weight: bold; width: 33%;" name="saveRepresentator" value="����� ���� ���" onclick="validateForm('represents', this.name)" />
				<input type="button" style="font-weight:bold; width: 33%" id="cureditp" name="cureditp" value="���������� �������" disabled />
				<input type="button" style="font-weight:bold; width: 33%" id="curdelp" name="curdelp" value="��������� �� ����" onclick="delete_person();" disabled />
			</nobr>
		</td>
	</tr>
</table>