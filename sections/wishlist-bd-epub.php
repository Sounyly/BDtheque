
                <!-- Debut panel album papier manquant-->

                    <div class="chat-panel panel panel-default">

                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Les albums numériques
                            <div class="pull-right"><a href="../admin/insert-bd-whishlist.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un album</a>
                            </div>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <?php 
                                $db = Database::connect();
                            /*----pagination-------*/
                                    $albumsParPages = 10; //on affiche 15 albums par page
                                    /*compter le nombre d'album bd papier*/
                                    $statement = $db->query('SELECT COUNT(*) AS total_bd_papier FROM whishlist WHERE type = 3');
                                    $req=$statement->fetch();//On range statement sous la forme d'un tableau
                                    $resultats=$req['total_bd_papier']; //On récupère le total pour le placer dans la variable $resultats.
                                    /*calculer le nombre de pages*/
                                    //on compte le nombre de page necessaire à l'entier supérieur
                                    $nombreDePage=ceil($resultats/$albumsParPages); // fonction ceil() pour avoir le nombre entier supérieur

                                    if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
                                    {
                                       $pageActuelles=intval($_GET['page']);

                                         if($pageActuelles>$nombreDePage) // Si la valeur de $pageActuelles (le numéro de la page) est plus grande que $nombreDePage...
                                         {
                                          $pageActuelles=$nombreDePage;
                                      }
                                  }
                                    else // Sinon
                                    {
                                         $pageActuelles=1; // La page actuelle est la n°1    
                                     }

                                    $premiereEntrees=($pageActuelles-1)*$albumsParPages; // On calcul la première entrée à lire

                                    $statement = $db->query('
                                        SELECT w.id AS id_album, w.name AS nom_album, w.images AS cover, w.serie AS serie_album, s.name AS nom_serie, t.id AS id_type, t.type AS name_type, g.name AS nom_genre, w.tome AS tome, s.tome AS nbre_serie
                                        FROM series AS s
                                        INNER JOIN types AS t ON t.id = s.type
                                        INNER JOIN whishlist AS w ON w.serie = s.id
                                        INNER JOIN genres AS g ON s.genre = g.id
                                        WHERE t.id = 3
                                        ORDER BY s.name, w.tome 
                                        LIMIT '.$premiereEntrees.','.$albumsParPages.'
                                        
                                        ');
                                    while($donnee = $statement->fetch())
                                    {
                                        echo'
                                        <li class="left clearfix">
                                            <span class="chat-img pull-left">
                                                <img src="../images/'.$donnee['cover'] .'" alt="Cover BD" width="50px" height="70px" class="">
                                            </span>
                                            <div class="chat-body clearfix">
                                                <div class="header serie">
                                                    <strong class="primary-font name_album">'.$donnee['nom_album'].'</strong>
                                            
                                                    <div class=" bouton-delete btn-group pull-right">
                                                        <a class="btn btn-danger" href="../admin/delete-wish.php?id='.$donnee['id_album'].'"><span class="glyphicon glyphicon-remove"></span></a>
                                                        <a class="btn btn-primary" href="../admin/update-wish.php?id='.$donnee['id_album'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    </div>


                                                    <div class="pull-right">';
                                                        echo'<span>'. $donnee['tome'].' / ' .$donnee['nbre_serie'].'</span>
                                                        <br>
                                                        <span class="genre rouge">' .$donnee['nom_genre']. '</span>
                                                    </div>
                                                    
                                                </div>
                                                <div>
                                                <p>
                                                    <span class="serie rouge">'.$donnee['nom_serie'].'</span>
                                                </p>
                                                </div>
                                            </div>
                                        </li>' ;
                                    }

                                    Database::disconnect();
                                ?>
                            </ul>
                        </div><!-- fin panel-body -->
                </div><!-- Fin panel-default -->
                <!-- pagination -->
                <?php  
                echo'
                <ul class="pagination">';
                    for($page=1; $page<=$nombreDePage; $page++) //On fait notre boucle
                    {
                             //On va faire notre condition
                             if($page==$pageActuelles) //Si il s'agit de la page actuelle...
                             {
                                 //echo ' [ '.$page.' ] '; 
                               echo '<li class="active"><a href="/bdthek/sections/wishlist.php?page='.$page.'">'.$page.'</a></li>'; 
                           }  
                             else //Sinon...
                             {
                              echo ' <li><a href="/bdthek/sections/wishlist.php?page='.$page.'">'.$page.'</a></li> ';

                          }
                      }

                      echo'</ul>';
                      ?>