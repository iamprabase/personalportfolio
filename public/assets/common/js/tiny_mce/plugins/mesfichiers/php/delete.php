<?php
$mysqlDB_link = mysql_connect("localhost", "root", "");
mysql_select_db("essaidb", $mysqlDB_link);
if (!$mysqlDB_link) 
{
exit("Échec de la connexion ");
}

//Supprimer la donnée
if(isset($_POST['supprimer']))//Si le bouton supprimer a été cliqué
{
$IDT = $_POST['DT'];
$sql =  "DELETE FROM texte WHERE IDT = '$IDT'";
if(!mysql_query($sql))
{
echo ('Erreur SQL. La donnée ne peut pas être supprimée');
}
else 
{
echo ('Suppression effectuée');
}

}

?>
