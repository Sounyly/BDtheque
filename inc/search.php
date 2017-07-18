<?php 
require '../admin/database.php';
include("../pages/header.php") ;
if(isset($_GET['query']))
{
	$db = Database::connect();
	$query=$_GET['query'];
	$s=explode(" ", $query);

    $sql="SELECT * FROM albums ";
    $i=0;
    foreach($s as $mot)
	{
		if(strlen($mot)>3)
		{
			if($i ==0)
			{
				$sql.=" WHERE ";
			}
			else
			{
				$sql.=" OR ";
			}
			$sql.="name LIKE '%$mot%'";
			$i++;
		}
		
	}
	echo $sql .'<br>';
    $req= $db->query($sql);  
    $count =$req->rowCount();
    echo $count .'Résultat';  
    while($donnees=$req->fetch())
    {
    	echo '<h1>'.$donnees['name'].'</h1>
    	<span>'.$donnees['genre'].'</span>
    	<span>'.$donnees['serie'].'</span>';
    }

    Database::disconnect();
}
else
{
	echo 'Cet album n\'est pas dans la base de données';
}
	

 ?>