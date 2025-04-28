<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Gestionnaire de documents PDF / DOC</title>
<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script type="text/javascript" src="js/dialog.js"></script>
</head>
<body>
<script language="javascript">
// fonction pour le cas d'appui sur la touche entrée
function testsubmit() {
    return !!document.formulaire.action;
}
</script>
	




<br /><br /><strong>Selectionner le document :</strong> <br /><br />

<?php
//$mysqlDB_link = mysql_connect("localhost", "mymontessori", "mfifimimi");
$mysqlDB_link = mysql_connect("localhost", "hugues", "dRoi0104");
mysql_select_db("montessoridb2", $mysqlDB_link);
if (!$mysqlDB_link) 
{
exit("Échec de la connexion ");
}

$sql = "SELECT * FROM pdf WHERE lang='fr' ORDER BY IDT DESC";
$req = mysql_query($sql);
$varDonnee = '<form action="#" name="formulaire" id="formulaire" method="post" onsubmit="testsubmit();">';
while ($ligne = mysql_fetch_assoc($req))
{
$IDT = $ligne['IDT'];
$titre = $ligne['titre'];
$link = $ligne['link'];
// affiche le resultat
$varDonnee .='<input name="someval" type="radio" id="someval" value="'.$link.'" />'.$titre.'<br />';
}

$varDonnee .='
<br /> 
<div class="mceActionPanel"><div style="float: left">
<input type="button"  name="insert" value="{#insert}" onclick="MesfichiersDialog.insert();" /><br></div>
<div style="float: right"></div></div>
<br>
';

$varDonnee .= '</form>';

echo $varDonnee;


?>
</body>
</html>
