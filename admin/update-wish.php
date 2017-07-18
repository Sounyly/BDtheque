<?php 
require '../admin/database.php';

if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

$nomError = $tomeError = $serieError = $genreError =  $typeError = $imageError = $nom = $tome = $serie = $genre = $type = $image = "";


	if(!empty($_POST))
	{
		$nom              = checkInput($_POST['name']);
		$tome             = checkInput($_POST['tome']);
		$serie            = checkInput($_POST['serie']);
		$genre            = checkInput($_POST['genre']);
        $type             = checkInput($_POST['type']);
		$image            = checkInput($_FILES['image']['name']);
		$imagePath        = '../images/'. basename($image);
        $imageExtension   = pathinfo($imagePath,PATHINFO_EXTENSION);
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
		if(empty($serie))
		{
			$serieError = 'Ce champ ne peut pas être vide';
			$isSuccess = false;
		}
		if(empty($genre))
		{
			$genreError = 'Ce champ ne peut pas être vide';
			$isSuccess = false;
		}
        if(empty($type))
        {
            $typeError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
		if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
	    {
	        $isImageUpdated = false;
	    }
	    else
	    {
	    	$isImageUpdated = true;
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
	    }
	    if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        { 
            $db = Database::connect();
            if($isImageUpdated)
            {
            	$statement = $db->prepare('UPDATE whishlist set name = ?, tome = ?, serie = ?, genre = ?, type = ?, images = ? WHERE id = ?');
            	$statement->execute(array($nom, $tome, $serie, $genre, $type, $image, $id));
            }
            else
            {
            	$statement = $db->prepare('UPDATE whishlist set name =?, tome = ?, serie = ?, genre = ?, type = ? WHERE id = ?');
            	$statement->execute(array($nom, $tome, $serie, $genre, $type, $id));
            }
            Database::disconnect();
            header("Location: ../sections/wishlist.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT * FROM whishlist where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image          = $item['images'];
            Database::disconnect();
           
        }

	}
	else 
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM whishlist where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $nom           = $item['name'];
        $tome    = $item['tome'];
        $serie          = $item['serie'];
        $genre       = $item['genre'];
        $type        = $item['type'];
        $image          = $item['images'];
        Database::disconnect();
    }
	function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
 ?>
<?php include ("../inc/header.php") ; ?>
	<body>
       
         <div class="container admin">
            <div class="row">
            	<div class="col-sm-6">
            		<h1><strong>Modifier un album</strong></h1>
                <br>
                <form class="form" action="<?php echo '../admin/update-wish.php?id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                        <label for="name">Titre:</label>
                        <input type="text" class="form-control" id="name" name="name"  value="<?php echo $nom;?>">
                        <span class="help-inline"><?php echo $nomError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="tome">Tome: </label>
                        <input type="text" class="form-control" id="tome" name="tome" value="<?php echo $tome;?>">
                        <span class="help-inline"><?php echo $tomeError;?></span>
                    </div>
                <div class="form-group">
                        <label for="serie">Serie:</label>
                        <select class="form-control" id="serie" name="serie">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM series') as $row) 
                           {
                           		if($row['id'] == $serie)
                                	echo '<option selected="selected" value="'. $row['id'] .'">'. $row['name'] . '</option>';
                                else
                                    echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>';; 
                           }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $serieError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre:</label>
                        <select class="form-control" id="genre" name="genre">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM genres') as $row) 
                           {
                           		if($row['id'] == $genre)
                                	echo '<option selected="selected" value="'. $row['id'] .'">'. $row['name'] . '</option>'; 
                                else
                                    echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>';;
                           }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $typeError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control" id="type" name="type">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM types') as $row) 
                           {
                                if($row['id'] == $type)
                                    echo '<option selected="selected" value="'. $row['id'] .'">'. $row['type'] . '</option>'; 
                                else
                                    echo '<option value="'. $row['id'] .'">'. $row['type'] . '</option>';;
                           }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $typeError;?></span>
                    </div>
                    <div class="form-group">
                    	<label for="image">Image:</label>
                        <p><?php echo $image;?></p>
                        <label for="image">Sélectionner une nouvelle image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="../sections/wishlist.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                </form>
            	</div><!-- fin col-sm -->
            	 <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/'.$image;?>" alt="...">
                          </div>
                    	</div>
                	</div>
            </div><!-- fin row -->

</body>










