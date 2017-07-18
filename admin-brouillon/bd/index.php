<?php include ("../../header.php") ; ?>
    
    <body>
       
        <div class="container admin">
            <div class="row">
                <h2>
                <strong>Liste BD possédé </strong>
                <a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter un album</a>
                <a href="../serie/index.php" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter une série</a>
                </h2>

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
                            require '../database.php';
                            //on se connecte
                            $db = Database::connect();
                            // requête
                            $statement = $db->query('
                                SELECT a.id AS id_album, s.name AS nom_serie, g.name AS nom_genre,  a.name AS nom_album, a.tome AS tome
                                FROM series AS s
                                INNER JOIN albums AS a ON a.serie = s.id
                                INNER JOIN genres AS g ON s.genre = g.id
                                ORDER BY s.name');

                                 while($donnees = $statement->fetch())
                                {
                                    echo '<tr>';
                                        echo '<td>' . $donnees['nom_serie'] . '</td>';
                                        echo '<td>' . $donnees['nom_genre'] . '</td>';
                                        echo '<td>' . $donnees['nom_album'] . '</td>';
                                        echo '<td>' . $donnees['tome'] . '</td>';
                                        echo '<td width=300>';
                                            echo '<a class="btn btn-default" href="view.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                                            echo ' ';
                                            echo '<a class="btn btn-primary" href="update.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                                            echo ' ';
                                            echo '<a class="btn btn-danger" href="delete.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
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


