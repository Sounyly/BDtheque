<?php 

	require '../admin/database.php';
	if (!empty($_GET['id']))
	{
		$id= checkInput($_GET['id']);
		
	}
	
	if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM albums WHERE id = ?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: ../sections/papier.php"); 
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
 ?>

<?php include("../inc/header.php") ; ?>
    
    <body>
        
         <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer un album</strong></h1>
                <br>
                <form class="form" action="delete-bd.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer?</p>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-warning">Oui</button>
                      <a class="btn btn-default" href="../sections/papier.php">Non</a>
                    </div>
                </form>
            </div>
        </div>   
    </body>
</html>
