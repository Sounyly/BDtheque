<?php 

	require 'database.php';
	if (!empty($_GET['id']))
	{
		$id= checkInput($_GET['id']);
		
	}
	
	if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM whishlist WHERE id = ?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index_whishlist.php"); 
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
 ?>

 <!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Burger</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <meta name="description" content="">
    <meta name="author" content="">
    <!--Définir le cache pour une navigation plus rapide-->
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
    <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet"> 
    <link rel="stylesheet" href="../css/style.css">
</head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-book"></span> Bédé-Théque <span class="glyphicon glyphicon-book"></span></h1>
         <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer un album</strong></h1>
                <br>
                <form class="form" action="delete_whishlist.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer?</p>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-warning">Oui</button>
                      <a class="btn btn-default" href="index_whishlist.php">Non</a>
                    </div>
                </form>
            </div>
        </div>   
    </body>
</html>
