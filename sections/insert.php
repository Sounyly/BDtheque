<?php 

	$nomError = $tomeError = $genreError = $nom = $tome = $genre = "";

	if(!empty($_POST))
	{
		$nom     		  = checkInput($_POST['name']);
        $tome    		  = checkInput($_POST['tome']);
		$genre   		  = checkInput($_POST['genre']);
		$isSuccess        = true;
       
	

		if(empty($nom))
	    {
	        $nomError = 'Ce champ ne peut pas être vide';
	        $isSuccess = false;
	    }
	    if(empty($tome))
	    {
	        $tomeError = 'Ce champ ne peut pas être vide';
	        $isSuccess = false;
	    }


	    if(empty($genre))
	    {
	        $genreError = 'Ce champ ne peut pas être vide';
	        $isSuccess = false;
	    }

	    if($isSuccess) 
	    {
	    	$db = Database::connect();
	    	$statement = $db->prepare('INSERT INTO series (name, tome, genre, date_ajout) values( ?, ?, ?, NOW())');
		    $statement->execute(array($nom, $tome, $genre));
	    	Database::disconnect();
	    	header('Location: ../bd/insert_bd.php');
	    }
	   
	}

	

 ?>



 <div class="admin">
            <div class="row">
                <h1><strong>Ajouter une série</strong></h1>
                <br>
                <form class="form" action="../serie/insert.php" role="form" method="post" enctype="multipart/form-data">
    <!-- formulaire titre -->
                <div class="form-group">
                	<label for="name">Nom :</label>
                	<input type="text" class="form-control" id="name" name="name" placeholder="Alter Ego" value="<?php echo $nom;?>">
                        <span class="help-inline"><?php echo $nomError;?></span>
                </div>

    <!-- formulaire n° tome -->
                <div class="form-group">
                    <label for="tome">Tome: </label>
                    <input type="text" class="form-control" id="tome" name="tome" placeholder="1/5" value="<?php echo $tome;?>">
                    <span class="help-inline"><?php echo $tomeError;?></span>
                </div>

    <!-- formulaire genre-->
                <div class="form-group">
                    <label for="genre">Genre:</label>
                    <select class="form-control" id="genre" name="genre">
                    <?php
                       $db = Database::connect();
                       foreach ($db->query('SELECT * FROM genres') as $row) 
                       {
                            echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>'; 
                       }
                       Database::disconnect();
                    ?>
                    </select>
                    <span class="help-inline"><?php echo $genreError;?></span>
                </div>
                <br>
    <!-- bouton validation -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="../bd/insert_bd.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                   </div>
                </form>
               </div><!-- fin row -->
              </div><!-- fin container -->
</body>
 