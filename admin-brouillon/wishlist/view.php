<?php
    require 'database.php';

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
      SELECT w.id AS id_album, s.name AS nom_serie, g.name AS nom_genre,  w.name AS nom_album, w.tome AS tome, w.images AS img
      FROM series AS s
      INNER JOIN whishlist AS w ON w.serie = s.id
      INNER JOIN genres AS g ON s.genre = g.id
      WHERE w.id = ?');

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


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Bdtheque</title>
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
                      <a class="btn btn-primary" href="index_whishlist.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div> 
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/'.$donnees['img'];?>" alt="Cover BD">
          
                            
                          </div>
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>