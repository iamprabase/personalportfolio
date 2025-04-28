<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#mesimages_dlg.title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js"></script>
</head>
<body>
<br />
<br />
Le gestionnaire des images est en cours de d&eacute;veloppement et sera int&eacute;gr&eacute; dans la nouvelle version de l'application.<br />
<br />
Pour int&eacute;grer une image sur votre page, fermez cette fen&ecirc;tre et affichez le gestionnaire d'images puis cliquez sur le lien de l'image &agrave; mettre.
<form onsubmit="ExampleDialog.insert();return false;" action="#">
	<p>Here is a example dialog.</p>
	<p>Selected text: <input id="someval" name="someval" type="text" class="text" /></p>
	<p>Custom arg: <input id="somearg" name="somearg" type="text" class="text" /></p>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="insert" name="insert" value="{#insert}" onclick="ExampleDialog.insert();" />
		</div>

		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
		</div>
	</div>
</form>
</body>
</html>
