<?php 
    require 'database.php';
    $nomError = $tomeError = $serieError = $genreError =  $imageError = $nom = $tome = $serie = $genre =  $image = "";


    if(!empty($_POST))
    {
        $nom              = checkInput($_POST['name']);
        $tome             = checkInput($_POST['tome']);
        $serie            = checkInput($_POST['serie']);
        $genre            = checkInput($_POST['genre']);
        $image            = checkInput($_FILES['image']['name']);
        $imagePath        = '../images/'. basename($image);
        $imageExtension   = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess        = true;
        $isUploadSuccess  = false;
    

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
    
    if(empty($image))
    {
        $imageError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    else
    {
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
    if($isSuccess && $isUploadSuccess) 
    {
        $db = Database::connect();
        $statement = $db->prepare('INSERT INTO albums (name, tome, serie, genre,  images, date_ajout) values ( ?, ?, ?, ?, ?, now())');
        $statement->execute(array($nom, $tome, $serie, $genre, $image));
        Database::disconnect();
        header('Location: index.php');
    }
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
    <title>BDtheque</title>
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
                <h1><strong>Ajouter un album</strong></h1>
                <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
    <!-- formulaire titre -->
                <div class="form-group">
                        <label for="name">Titre:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Alter Ego" value="<?php echo $nom;?>">
                        <span class="help-inline"><?php echo $nomError;?></span>
                    </div>
     <!-- formulaire n° tome -->
                    <div class="form-group">
                        <label for="tome">Tome: </label>
                        <input type="text" class="form-control" id="tome" name="tome" placeholder="1/5" value="<?php echo $tome;?>">
                        <span class="help-inline"><?php echo $tomeError;?></span>
                    </div>
     <!-- formulaire série -->
                <div class="form-group">
                        <label for="serie">Serie:</label>
                        <select class="form-control" id="serie" name="serie">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM series') as $row) 
                           {
                                echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>'; 
                           }
                           Database::disconnect();
                        ?>
                        <option value="ajouter"><a href="insert_serie.php">Ajouter une série</a></option>
                        </select>
                        <span class="help-inline"><?php echo $serieError;?></span>
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
                    
                    
                    
                    <div class="form-group">
                        <label for="image">Sélectionner une image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                   </div>
                </form>
            </div>
        </div>   
    </body>
</html>