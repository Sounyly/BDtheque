<?php
require '../admin/database.php';
include("../inc/header.php") ;
?>
<body>



    <div id="throbber" style="display:none; min-height:120px;"></div>
    <div id="noty-holder"></div>
    <div id="wrapper">
         <?php include("../inc/navbar.php"); ?>
         <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row m-50">
                    <div class="col-lg-12">
                        <h1 class="page-header">Albums manquants</h1>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="dashboard-row">
                <?php 

                     $db = Database::connect();
                 /*------------------------
                    BD
                ---------------------------*/
                // wishlist BD papier
                    $statement = $db->query('SELECT COUNT(*) AS nbre_bd_manquant_papier FROM whishlist WHERE type = 2');
                    $bdManquant_papier = $statement->fetch();
                // wishlist BD epub
                    $statement = $db->query('SELECT COUNT(*) AS nbre_bd_manquant_epub FROM whishlist WHERE type = 3');
                    $bdManquant_epub = $statement->fetch();
                /*------------------------
                    Manga
                ---------------------------*/
                // wishlist Manga papier
                    $statement = $db->query('SELECT COUNT(*) AS nbre_manga_manquant_papier FROM wishlist_manga WHERE type = 2');
                    $mangaManquant_papier = $statement->fetch();
                // wishlist Manga epub
                    $statement = $db->query('SELECT COUNT(*) AS nbre_manga_manquant_epub FROM wishlist_manga WHERE type = 3');
                    $mangaManquant_epub = $statement->fetch();

                     Database::disconnect();


                 ?>
    <!--*******************
        DASHBOARD wishlist
    ************************-->

            <!-- panel dashboard bd papier manquant -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-bd-papier">
                            <div class="panel-heading dash-header">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-book fa-4x dash" aria-hidden="true"></i>
                                           
                                    </div>
                                    <div class="col-xs-9 text-right text-dash-bd">
                                        <div class="huge"><?php echo ' ' .$bdManquant_papier['nbre_bd_manquant_papier']. ' ' ;?></div>
                                        <div> BD Papier Manquantes</div>
                                    </div>
                                </div>
                            </div>
                            <a href="/bdthek/bd/papier.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Voir</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div><!-- fin col -->
            <!-- panel dashboard bd epub manquant -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-bd-epub">
                        <div class="panel-heading dash-header">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tablet fa-4x dash"></i>
                                </div>
                                <div class="col-xs-9 text-right text-dash-bd-epub">
                                    <div class="huge"><?php echo '' .$bdManquant_epub['nbre_bd_manquant_epub'] ;?></div>
                                    <div>BD Numériques Manquantes</div>
                                </div>
                            </div>
                        </div>
                        <a href="/bdthek/bd/epub.php">
                            <div class="panel-footer">
                                <span class="pull-left">Voir</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    </div><!-- fin col -->
            <!-- panel dashboard bd papier -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-manga-papier">
                        <div class="panel-heading dash-header">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-4x dash"></i>
                                </div>
                                <div class="col-xs-9 text-right text-dash-manga">
                                    <div class="huge"><?php echo '' .$mangaManquant_papier['nbre_manga_manquant_papier'] ;?></div>
                                    <div>Manga  Papier manquants</div>
                                </div>
                            </div>
                        </div>
                        <a href="/bdthek/manga/papier.php">
                            <div class="panel-footer">
                                <span class="pull-left">Voir</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            <!-- panel dashboard manga epub manquant -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-manga-epub">
                        <div class="panel-heading dash-header">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tablet fa-4x dash"></i>
                                </div>
                                <div class="col-xs-9 text-right text-dash-manga-epub">
                                    <div class="huge"><?php echo '' .$mangaManquant_epub['nbre_manga_manquant_epub'] ;?></div>
                                    <div>Mangas Numériques Manquants</div>
                                </div>
                            </div>
                        </div>
                        <a href="/bdthek/manga/epub.php">
                            <div class="panel-footer">
                                <span class="pull-left">Voir</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div><!-- fin row -->
    

    <!--***********************
        LISTE album bd manquantes
    ***************************-->
        <div class="row">
            <div class="col-lg-6">
                <!-- Debut panel album papier manquant-->

                    <div class="chat-panel panel panel-default">

                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Les albums papiers
                            <div class="pull-right"><a href="../admin/insert-bd-whishlist.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un album dans wishlist</a>
                            </div>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <?php 
                                $db = Database::connect();
                            /*----pagination-------*/
                                    $albumsParPage = 10; //on affiche 15 albums par page
                                    /*compter le nombre d'album bd papier*/
                                    $statement = $db->query('SELECT COUNT(*) AS total_bd_papier FROM whishlist WHERE type = 2');
                                    $req=$statement->fetch();//On range statement sous la forme d'un tableau
                                    $resultat=$req['total_bd_papier']; //On récupère le total pour le placer dans la variable $resultat.
                                    /*calculer le nombre de pages*/
                                    //on compte le nombre de page necessaire à l'entier supérieur
                                    $nombreDePages=ceil($resultat/$albumsParPage); // fonction ceil() pour avoir le nombre entier supérieur

                                    if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
                                    {
                                       $pageActuelle=intval($_GET['page']);

                                         if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
                                         {
                                          $pageActuelle=$nombreDePages;
                                      }
                                  }
                                    else // Sinon
                                    {
                                         $pageActuelle=1; // La page actuelle est la n°1    
                                     }

                                    $premiereEntree=($pageActuelle-1)*$albumsParPage; // On calcul la première entrée à lire

                                    $statement = $db->query('
                                        SELECT w.id AS id_album, w.name AS nom_album, w.images AS cover, w.serie AS serie_album, s.name AS nom_serie, t.id AS id_type, t.type AS name_type, g.name AS nom_genre, w.tome AS tome, s.tome AS nbre_serie
                                        FROM series AS s
                                        INNER JOIN types AS t ON t.id = s.type
                                        INNER JOIN whishlist AS w ON w.serie = s.id
                                        INNER JOIN genres AS g ON s.genre = g.id
                                        WHERE t.id = 2
                                        ORDER BY s.name, w.tome 
                                        LIMIT '.$premiereEntree.','.$albumsParPage.'
                                        
                                        ');
                                    while($donnees = $statement->fetch())
                                    {
                                        echo'
                                        <li class="left clearfix">
                                            <span class="chat-img pull-left">
                                                <img src="../images/'.$donnees['cover'] .'" alt="Cover BD" width="50px" height="70px" class="">
                                            </span>
                                            <div class="chat-body clearfix">
                                                <div class="header serie">
                                                    <strong class="primary-font name_album">'.$donnees['nom_album'].'</strong>

                                                    <div class=" bouton-delete btn-group pull-right">
                                                        <a class="btn btn-danger" href="../admin/delete-wish.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-remove"></span></a>
                                                        <a class="btn btn-primary" href="../admin/update-wish.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    </div>

                                                    <div class="pull-right">
                                                        <span>';echo str_pad($donnees['tome'], 2, '0', STR_PAD_LEFT);echo' / ';echo str_pad($donnees['nbre_serie'], 2, '0', STR_PAD_LEFT);echo'</span>
                                                        <br>
                                                        <span class="genre rouge">' .$donnees['nom_genre']. '</span>
                                                    </div>
                                                    
                                                </div>
                                                <div>
                                                <p>
                                                    <span class="serie rouge">'.$donnees['nom_serie'].'</span>
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
                    for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                    {
                             //On va faire notre condition
                             if($i==$pageActuelle) //Si il s'agit de la page actuelle...
                             {
                                 //echo ' [ '.$i.' ] '; 
                               echo '<li class="active"><a href="/bdthek/bd/wishlist.php?page='.$i.'">'.$i.'</a></li>'; 
                           }  
                             else //Sinon...
                             {
                              echo ' <li><a href="/bdthek/bd/wishlist.php?page='.$i.'">'.$i.'</a></li> ';

                          }
                      }

                      echo'</ul>';
                      ?>
                </div><!-- fin col-lg -->
    

    <!--***********************
    LISTE album bd manquantes
    ***************************-->
        <!-- Debut panel album epub manquant-->
                 <div id ="wish-epub" class="col-lg-6 ">
                    <!-- Debut panel album -->

                    <?php include("wishlist-bd-epub.php"); ?>
               
                </div><!-- fin col-lg -->
                </div><!-- fin row -->
    

    <!--****************************************
        LISTE aléatoire de 10 séries incomplètes
    ********************************************-->
        <div class="row">
            <div class=" col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="chat-panel panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-comments fa-fw"></i> Séries en cours
                        <div class="pull-right"><a href="../admin/insert-serie.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter une série</a>
                        </div>                          
                    </div>
                        <!-- /.panel-heading -->
                    <div class="panel-body panel-display">
                        <?php 
                            $db = Database::connect();
                            $statement=$db->query('
                                SELECT s.id AS id_serie, s.name AS nom_serie, w.serie AS album_serie, s.tome AS nbre_tome, w.images AS image, t.id AS id_type, w.tome AS tome_album, w.id AS id_wish, t.type AS type_name, g.name AS nom_genre, COUNT(*) AS nbre_album
                                FROM series AS s                                
                                INNER JOIN types AS t ON t.id = s.type
                                INNER JOIN whishlist AS w ON s.id = w.serie
                                INNER JOIN genres AS g ON s.genre = g.id
                                WHERE w.serie = s.id
                                GROUP BY nom_serie
                                LIMIT 10
                                ');
                            $serieAleatoire = $statement->fetchAll();
                            foreach($serieAleatoire as $serieAleatoires)
                            {
                                
                                    $statement = $db->query('SELECT COUNT(*) AS nbre_album_wish FROM whishlist ');
                                    $serieWish = $statement->fetch();


                                echo'<div class="col-lg-3 col-sm-5 col-md-4 col-xs-12 dernierBD-ajout ">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-6">
                                                 <img src="../images/'.$serieAleatoires['image'] .'" alt="Cover BD" width="100%" class="cover-one-shot-bd">
                                            </div>
                                            <div class="col-lg-8 col-sm-6 col-md-6 col-xs-6">
                                                <h5 class="titre-dernier-ajout ">'.$serieAleatoires['nom_serie'].'</h5>';
                                                
                                                if($serieWish['serie'] = $serieAleatoires['id_serie'])
                                                {
                                                    echo'<strong class="tome_dernier-ajout">Il manque '.$serieAleatoires['nbre_album'] .' album(s) sur '.$serieAleatoires['nbre_tome'].' </strong><br>';
                                                }
                                                   
                                                

                                                
                                                if($serieAleatoires['id_type'] == 2)
                                                {

                                                    echo'<div><strong>'.$serieAleatoires['type_name'].'</strong></div>';
                                                }
                                                else if($serieAleatoires['id_type'] == 3)
                                                {
                                                    echo'<div><strong>'.$serieAleatoires['type_name'].'</strong></div>';
                                                }
                                           echo' 
                                            </div>
                                        </div>
                                    </div>';
                                
                                   

                                
                            }

                            Database::disconnect();
                         ?>
                        
                    </div><!-- fin panel-body -->
                </div><!-- Fin panel-default -->
            </div><!-- fin col-lg -->
          
        </div> <!-- fin row -->  
            </div><!-- fin container-fluid -->
        </div><!-- fin #page-wrapper -->
    </div><!-- fin #wrapper -->
    <!-- footer -->
<?php include("../inc/footer.php") ; ?>
</body>
</html>

