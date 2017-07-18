<?php 
    require '../admin/database.php';
    require '../fonc/checkInput.php';
    $nomError = $tomeError = $genreError = $typeError = $nom = $tome = $genre = $type = "";
    if(!empty($_POST))
    {
        $nom              = checkInput($_POST['name']);
        $tome             = checkInput($_POST['tome']);
        $genre            = checkInput($_POST['genre']);
        $type             = checkInput($_POST['type']);
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
        if(empty($type))
        {
            $typeError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if($isSuccess) 
        {
            $db = Database::connect();
            $statement = $db->prepare('INSERT INTO series (name, tome, genre, type, date_ajout) values( ?, ?, ?, ?, NOW())');
            $statement->execute(array($nom, $tome, $genre, $type));
            Database::disconnect();
            header('Location: ../serie/serie.php');
        }
    }
include("../inc/header.php") ;
 ?>


    
    ?>

    <div id="throbber" style="display:none; min-height:120px;"></div>
    <div id="noty-holder"></div>
        <div id="wrapper">
            <?php include("../inc/navbar.php"); ?>
            <div class="container">
               
                    <div id="page-wrapper">

                    <div class="admin jumbotron">
                        <div class="row">
                            <h1><strong>Ajouter une série</strong></h1>
                            <br>
                            <form class="form" action="insert-serie.php" role="form" method="post" enctype="multipart/form-data">
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
                            <br>
                <!-- bouton validation -->
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                                    <a class="btn btn-primary" href="../sections/serie.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                               </div>
                            </form>
                        </div><!-- fin row -->
                    </div><!-- fin jumbotron -->
                </div><!-- fin #page-wrapper -->
            </div><!-- fin container -->
        </div><!-- fin #wrapper -->
</body>
 