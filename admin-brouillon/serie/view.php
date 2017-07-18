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
      SELECT s.name AS nom_serie, g.name AS nom_genre, s.tome AS nbre_tome
      FROM series AS s
      INNER JOIN genres AS g ON s.genre = g.id
      WHERE s.id = ?');

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
                        <label>Tome:</label><?php echo '  '.$donnees['nbre_tome'];?>
                      </div>
                      
                    </form>
                    <br>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div> 
                
                </div>
            </div>
        </div>   
    </body>
