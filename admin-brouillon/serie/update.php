<?php 
require '../database.php';

if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

$nomError = $tomeError = $genreError =  $nom = $tome = $genre = "";


	if(!empty($_POST))
	{
		$nom        = checkInput($_POST['name']);
        $genre      = checkInput($_POST['genre']);
        $tome       = checkInput($_POST['tome']);
        $isSuccess  = true;
        

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
		
	    
	    if ($isSuccess)
        { 
            $db = Database::connect();
            $statement = $db->prepare('UPDATE series set name = ?, genre = ?, tome = ?  WHERE id = ?');
            $statement->execute(array($nom, $genre, $tome, $id));
            Database::disconnect();
            header("Location: index.php");
        }
        
	}
    else
    {
        $db = Database::connect();
        $statement = $db->prepare('SELECT * FROM series where id= ?');
        $statement->execute(array($id));
        $item = $statement->fetch();
        $nom = $item['name'];
        $genre = $item['genre'];
        $tome = $item['tome'];
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
<?php include ("../../header.php") ; ?>
	<body>
        <div class="container admin">
            <div class="row">
            	<div class="col-sm-6">
            		<h1><strong>Modifier la série</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'update.php?id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label for="name">Nom:</label>
                            <input type="text" class="form-control" id="name" name="name"  value="<?php echo $nom;?>">
                            <span class="help-inline"><?php echo $nomError;?></span>
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
                            <span class="help-inline"><?php echo $genreError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="tome">Tome: </label>
                            <input type="text" class="form-control" id="tome" name="tome" value="<?php echo $tome;?>">
                            <span class="help-inline"><?php echo $tomeError;?></span>
                        </div>
                    
                        
            
                        
                        <br>
                        <div class="form-actions">
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                                <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                           </div>
                    </form>
            	</div><!-- fin col-sm -->           	 
            </div><!-- fin row -->
        </div><!-- fin container -->

</body>










