<legend>����� �� e������� �����������</legend>
<table>
<tr>
<td> 
	<table border="1" name="build_table" id="build_table">
		<tr>
			<td>�����:<span class="red">*</span></td>
			<td id="raion_td"> 
				<select name="raion_sel" id="raion_sel" onchange="document.getElementById('str_search').value='';">
				</select>
			</td>
			<td> ������ �� �����������:</td>
			<td>
				<select name="year_of_const"  id="year_of_const">
				</select>
			</td>
		</tr>
		<tr>
			<td>������������� �� ������:<span class="red">*</span></td>
			<td>
				<input type="hidden" name="hid_build_id" id="hid_build_id"/>
				<input type="hidden" name="hid_adr" id="hid_adr"/>
				<input type="text" name="build_identifyh" id="build_identifyh"/>
			</td>
			<td>���� �����:</td>
			<td>
				<input type="text" class="cyrullic" onkeyup="if(this.value > 32){alert('�� ���� �� ��������� ���� ����� ��-����� �� 32!'); this.value = ''; return false;}else{}" name="numb_floors" id="numb_floors" />
			</td>
		</tr>
		<tr>
			<td>�������� �����:<span class="red">*</span></td>
			<td id="nasel_td">
				<select id="nasel_sel" name="nasel_sel">
				</select>
			</td>
			<td>
				&nbsp;&nbsp;
				&nbsp;&nbsp;
				&nbsp;&nbsp;
				�������� �����:
			</td>
			<td>
				<input type="text" name="numb_under_floors"  id="numb_under_floors" maxlength="10" onkeydown="" />
			</td>
		</tr>
		<tr>
			<td>�������:</td>
			<td id="hood_td">
				<select id="hood_sel" name="hood_sel">
				</select>
			</td>
			<td>
				&nbsp;&nbsp;
				&nbsp;&nbsp;
				&nbsp;&nbsp;
				����-�������� �����:
			</td>
			<td>
				<input type="text" name="numb_half_under"  id="numb_half_under" maxlength="10" onkeydown="" />
			</td>
		</tr>
		<tr>
			<td>�.�.:</td>
			<td id="jk_td">
				<select id="jk_sel" name="jk_sel">
				</select>
			</td>
			<td>
				&nbsp;&nbsp;
				&nbsp;&nbsp;
				&nbsp;&nbsp;
				�������� �����:
			</td>
			<td>
				<input type="text" name="numb_on_ground"  id="numb_on_ground" maxlength="10" onkeydown="" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<nobr>
					���./��./��.:
					<input type="text" class="cyrullic" name="str_search"  id="str_search" onkeyup="ifstreet();" />
				</nobr>
			</td>
			<td id="autocompletes">
				<select id="street_sel" name="street_sel">
				</select>
			</td>
			<td>��� ���� �� ��������:</td>
			<td>
				<input type="text" class="cyrullic" onkeyup="if(this.value > 500){alert('������ ���� �� �������� �� ���� �� ���� ��-����� �� 500!'); this.value = ''; return false;}else{}" name="all_objects" id="all_objects" />
			</td>
		</tr>
		<tr>
			<td>����� �:</td>
			<td>
				<input type="text" name="str_nom" id="str_nom"/>
			</td>
			<td>
				���� ������ �������� �����������:
			</td>
			<td>
				<input type="text" name="object_ds" id="object_ds" />
			</td>
		</tr>               
		<tr>
			<td>���� �:</td>
			<td>
				<input type="text" name="build_numb" id="build_numb"/>
			</td>
			<td>
				���� ������ ������ �����. �� �.�.:
			</td>
			<td>
				<input type="text" name="object_fiz" id="object_fiz" />
			</td>
		</tr>
		<tr>
			<td>���� ����-������:</td>
			<td>
				<input type="text" name="secs" maxlength="5" id="secs" value=""/>
			</td>
			<td>
				���� ������ ������ �����. �� �.�.:
			</td>
			<td>
				<input type="text" name="object_comp" id="object_comp" />
			</td>
		</tr>
		<tr>
			<td>���� �������:</td>
			<td>
				<input type="text" name="vhodove" maxlength="5" id="vhodove" value=""/>
			</td>
			<td>
				���� ������ �������� �����������:
			</td>
			<td>
				<input type="text" name="object_os" id="object_os" />
			</td>
		</tr>
		<tr>
			<td>���� �� ������ ���������:</td>
			<td>
				<input type="text" name="pril_parts" id="pril_parts" maxlength="10" value="" />��.�
			</td>
			<td>
				���� ������ � ��������� ��������������:
			</td>
			<td>
				<input type="text" name="object_trade" id="object_trade" />
			</td>
		</tr>
		<tr>
			<td>���� ���������� ���� �� ��������:</td>
			<td>
				<input type="text" name="total_square" id="total_square" maxlength="10" value=""/>��.�
			</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>��� �� �������������:</td>
			<td id="construction" colspan="3">
				<select name="construct_type"  id="construct_type"></select>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<nobr>
					<input type="button" id="save_build" name="save_build" style="font-weight:bold; width: 33%" value="����� ���� ���� ������" onclick="validateForm('build_form', this.name);" />
					<input type="button" style="font-weight:bold; width: 33%" id="curedit" name="curedit" value="���������� �������� ������" disabled />
					<input type="button" style="font-weight:bold; width: 33%" id="curdel" name="curdel" value="��������� �� ��������" onclick="delete_build();" disabled />
				</nobr>
			</td>
		</tr>
    </table>
    </td>
    <td>
		&nbsp;
    </td>
    </tr>
    </table>