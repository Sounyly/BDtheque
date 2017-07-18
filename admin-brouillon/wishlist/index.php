<!DOCTYPE html>
<html lang="fr">
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
                <h1><strong>Whishlist BD </strong><a href="insert_whishlist.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Série</th>
                        <th>Genre</th>
                        <th>Albums</th>
                        <th>Tome</th>
                        <th>Option</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            //autorisation connexion
                            require 'database.php';
                            //on se connecte
                            $db = Database::connect();
                            // requête
                            $statement = $db->query('
                                SELECT w.id AS id_album, s.name AS nom_serie, g.name AS nom_genre,  w.name AS nom_album, w.tome AS tome
                                FROM series AS s
                                INNER JOIN whishlist AS w ON w.serie = s.id
                                INNER JOIN genres AS g ON s.genre = g.id');

                                 while($donnees = $statement->fetch())
                                {
                                    echo '<tr>';
                                        echo '<td>' . $donnees['nom_serie'] . '</td>';
                                        echo '<td>' . $donnees['nom_genre'] . '</td>';
                                        echo '<td>' . $donnees['nom_album'] . '</td>';
                                        echo '<td>' . $donnees['tome'] . '</td>';
                                        echo '<td width=300>';
                                            echo '<a class="btn btn-default" href="view_whishlist.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                                            echo ' ';
                                            echo '<a class="btn btn-primary" href="update_whishlist.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                                            echo ' ';
                                            echo '<a class="btn btn-danger" href="delete_whishlist.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                                        echo '</td>';
                                    echo '</tr>';
                                }   

                
                            Database::disconnect();
                         ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

