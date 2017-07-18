
<?php 
    
    require '../admin/database.php';
    require '../admin/checkInput.php';

$nomError = $genreError = $typeError = $imageError = $nom = $genre = $type = $image = "";

    if(!empty($_POST)) // Si le mot de passe est bon
    {
        $nom              = checkInput($_POST['name']);
        $genre            = checkInput($_POST['genre']);
        $type             = checkInput($_POST['type']);
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
            $statement = $db->prepare('INSERT INTO one_shot (name, genre, type, images, date_ajout) values ( ?, ?, ?, ?, now())');
            $statement->execute(array($nom, $genre, $type, $image));
            Database::disconnect();
            header('Location: index.php');
        }
    }
    
    include("../pages/header.php") ;
    
    ?>

    <div id="throbber" style="display:none; min-height:120px;"></div>
    <div id="noty-holder"></div>
        <div id="wrapper">
            <?php include("../pages/navbar.php"); ?>
            <div class="container">
               
                    <div id="page-wrapper">


                       <div class="admin jumbotron">
                        <div class="row">
                            <form class="form" action="insert-bd-wishlist.php" role="form" method="post" enctype="multipart/form-data">
                <!-- formulaire titre -->
                                <div class="form-group">
                                    <label for="name">Titre:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Alter Ego" value="<?php echo $nom;?>">
                                    <span class="help-inline"><?php echo $nomError;?></span>
                                </div>
                
                <!-- formulaire genre-->
                                <div class="form-group">
                                    <label for="genre">Genre:</label>
                                    <select class="form-control" id="genre" name="genre">
                                        <?php
                                        $db = Database::connect();
                                        foreach ($db->query('SELECT * FROM genres ORDER BY name') as $row) 
                                        {
                                            echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>'; 
                                        }
                                        Database::disconnect();
                                        ?>
                                    </select>
                                    <span class="help-inline"><?php echo $genreError;?></span>
                                </div>
                <!-- formulaire type-->
                                <div class="form-group">
                                    <label for="type">Type:</label>
                                    <select class="form-control" id="type" name="type">
                                        <?php
                                        $db = Database::connect();
                                        foreach ($db->query('SELECT * FROM types') as $row) 
                                        {
                                            echo '<option value="'. $row['id'] .'">'. $row['type'] . '</option>'; 
                                        }
                                        Database::disconnect();
                                        ?>
                                    </select>
                                    <span class="help-inline"><?php echo $typeError;?></span>
                                </div>
                                
                <!-- formulaire image-->               
                                <div class="form-group">
                                    <label for="image">Sélectionner une image:</label>
                                    <input type="file" id="image" name="image"> 
                                    <span class="help-inline"><?php echo $imageError;?></span>
                                </div>
                                <br>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                                    <a class="btn btn-primary" href="../index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                                     
                                </div>
                            </form>
                        </div>
                    </div> 
                </div>
            </div>  
    </div>
    