<html>
<title>Test web service</title>
<body style="width: 100%;">

<a href="index.php">back to menu</a>

<h1>action: getbrands</h1>

<form encType="multipart/form-data" method="post" id="edit_form" target="result" action="../mobile_service.php">
<input type="hidden" name="action" value="getbrands" />
	os: <select name="os"><option value="iphone">iphone</option><option value="android">android</option></select><br/>
	device: <input type="text" name="device" /><br/>
	<table class="contents_edit" id="public_profile">
		<tr>
			<td class="label">rowcount</td>
			<td class="edit">
				<input type="text" name="startrow" value="0"/>
			</td>
		</tr>
		<tr height="35px">
			<td class="label"></td>
			<td class="edit">
				<input type="submit" value="  Get " style="width:80px;"/>
			</td>
		</tr>
	</table>

</form>

<b>Result: </b>
<iframe name="result" style="width: 100%; height: 100%;"></iframe>

</body>
</html>