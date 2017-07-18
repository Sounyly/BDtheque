<?php include ("../../header.php") ; ?>    
    <body>
       
        <div class="container admin">
            <div class="row">
                <h2>
                <strong>Liste série</strong>
                <a href="insert.php" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter une série</a>
                <a href="../bd/index.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter un album</a>
                </h2>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Genre</th>
                        <th>Tomes</th>
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
                                SELECT s.id AS id_serie, s.name AS nom_serie, s.tome AS nbre_tome, g.name AS nom_genre
                                FROM series AS s
                                INNER JOIN genres AS g ON s.genre = g.id
                                ORDER BY s.name');
                                 while($donnees = $statement->fetch())
                                {
                                    echo '<tr>';
                                        echo '<td>' . $donnees['nom_serie'] . '</td>';
                                        echo '<td>' . $donnees['nom_genre'] . '</td>';
                                        echo '<td>' . $donnees['nbre_tome'] . '</td>';
                                        echo '<td width=300>';
                                            echo '<a class="btn btn-default" href="view.php?id='.$donnees['id_serie'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                                            echo ' ';
                                            echo '<a class="btn btn-primary" href="update.php?id='.$donnees['id_serie'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                                            echo ' ';
                                            echo '<a class="btn btn-danger" href="delete.php?id='.$donnees['id_serie'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
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

