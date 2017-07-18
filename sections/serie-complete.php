<!--___________________________________________
  PAGE QUI AFFICHE LES BILLETS
  ____________________________________________-->

                    <!-- Debut panel album -->
                    <div class="chat-panel panel panel-default">
                      <div class="panel-heading">
                        <i class="fa fa-comments fa-fw"></i> Nbre d'albums manquants par série

                        
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                        <ul class="chat">
                          <?php  
                          $db = Database::connect();
                          $statement=$db->query('
                            SELECT s.id AS serie_id, s.name AS serie_name, s.tome AS serie_tome, s.type AS type_serie, w.tome AS tome_wish, w.id AS wish_id, w.serie AS serie_wish, t.id AS id_type, t.type AS name_type, g.id AS id_genre, g.name AS name_genre, COUNT(*) AS nbre_wish
                            FROM series AS s
                            INNER JOIN whishlist AS w ON w.serie = s.id
                            INNER JOIN types AS t ON s.type = t.id
                            INNER JOIN genres AS g ON s.genre = g.id
                            GROUP BY s.id
                            ORDER BY s.name              
                            ');
                          

                         
                          Database::disconnect();
                          while($recapSerie = $statement->fetch())
                          {
                            echo'
                            <li class=" serie-complete">';
                            /*Si le type est papier color en vert, si le type est epub color en rouge*/

                            if($recapSerie['id_type'] == 2)
                            {
                               echo'<strong class=" pull-left type-serie-wish-papier">'.$recapSerie['name_type'].'</strong>
                              
                              ';
                            }
                            else if($recapSerie['id_type'] == 3)
                            {
                               echo'<strong class=" pull-left type-serie-wish-epub">'.$recapSerie['name_type'].'</strong>
                              
                              ';
                            }


                             


                            echo'
                                    <strong class="strong-name-serie">'.$recapSerie['serie_name'].'</strong>
                                    <strong class="strong-genre-serie rouge">'.$recapSerie['name_genre'].'</strong>
                                    <span class="strong-wish-serie green pull-right">';echo str_pad($recapSerie['nbre_wish'], 2, '0', STR_PAD_LEFT);echo'</span>


                                    
                                
                                  
                              </li>' ;
                          }
                          ?>
                        </ul>
                      </div><!-- fin panel-body -->
                    </div><!-- Fin panel-default -->
