<?php
    require '../database.php';

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }
    /*------------------------------------------
    On se connecte a database et on stock cette connexion dans la variable $db
     en utilisant la fonction static de la class database dans le require ::connect()


    On récupére l'item 
--------------------------------------------*/
     
    $db = Database::connect();

    $statement = $db->prepare('
      SELECT a.id AS id_album, s.name AS nom_serie, g.name AS nom_genre,  a.name AS nom_album, a.tome AS tome, a.images AS img
      FROM series AS s
      INNER JOIN albums AS a ON a.serie = s.id
      INNER JOIN genres AS g ON s.genre = g.id
      WHERE a.id = ?');

    $statement->execute(array($id));
    $donnees = $statement->fetch();
    Database::disconnect();

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
        <h1 class="text-logo"><span class="glyphicon glyphicon-book"></span> Bédé-Théque <span class="glyphicon glyphicon-book"></span></h1>
         <div class="container admin">
            <div class="row">
               <div class="col-sm-6">
                    <h1><strong>Description</strong></h1>
                    <br>
                    <form>
                      <div class="form-group">
                        <label>Série: </label><?php echo '  '.$donnees['nom_serie'];?>
                      </div>
                      <div class="form-group">
                        <label>Genre:</label><?php echo '  '.$donnees['nom_genre'];?>
                      </div>
                      <div class="form-group">
                        <label>Titre</label><?php echo '  '.$donnees['nom_album'];?>
                      </div>
                      <div class="form-group">
                        <label>Tome:</label><?php echo '  '.$donnees['tome'];?>
                      </div>
                      <div class="form-group">
                        <label>Image:</label><?php echo '  '.$donnees['img'];?>
                      </div>
                    </form>
                    <br>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div> 
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../../images/'.$donnees['img'];?>" alt="Cover BD">
          
                            
                          </div>
                    </div>
                </div>
            </div>
        </div>   
    </body>
