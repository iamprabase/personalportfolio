<?php
$mysqlDB_link = mysql_connect("localhost", "root", "");
mysql_select_db("essaidb", $mysqlDB_link);
if (!$mysqlDB_link) 
{
exit("�chec de la connexion ");
}

//Supprimer la donn�e
if(isset($_POST['supprimer']))//Si le bouton supprimer a �t� cliqu�
{
$IDT = $_POST['DT'];
$sql =  "DELETE FROM texte WHERE IDT = '$IDT'";
if(!mysql_query($sql))
{
echo ('Erreur SQL. La donn�e ne peut pas �tre supprim�e');
}
else 
{
echo ('Suppression effectu�e');
}

}

?>
