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
                    <h1 class="page-header">BD reliées</h1>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="dashboard-row">
                <?php include("../inc/dashboard.php"); ?>
            </div>
            

            <div class="row">

                <div class="col-lg-6">
                    <!-- Debut panel album -->

                    <div class="chat-panel panel panel-default panel-default-bd-papier">

                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Les albums
                            <div class="pull-right"><a href="../admin/insert-bd.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un album</a>
                            </div>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <?php 
                                $db = Database::connect();
                    /*----pagination-------*/
                                    $albumsParPage = 16; //on affiche 15 albums par page
                                    /*compter le nombre d'album bd papier*/
                                    $statement = $db->query('SELECT COUNT(*) AS total_bd FROM albums');
                                    $req=$statement->fetch();//On range statement sous la forme d'un tableau
                                    $resultat=$req['total_bd']; //On récupère le total pour le placer dans la variable $resultat.
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
                                        SELECT a.id AS id_album, a.name AS nom_album, a.images AS cover, a.serie AS serie_album, s.name AS nom_serie, g.name AS nom_genre, t.id AS type_id, t.type AS nom_type, a.tome AS tome, s.tome AS nbre_serie
                                        FROM series AS s
                                        INNER JOIN types AS t ON t.id = s.type
                                        INNER JOIN albums AS a ON a.serie = s.id
                                        INNER JOIN genres AS g ON s.genre = g.id
                                        WHERE t.id = 2
                                        ORDER BY s.name, a.tome 
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
                                                        <a class="btn btn-danger" href="../admin/delete-bd.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-remove"></span></a>
                                                        <a class="btn btn-primary" href="../admin/update-bd.php?id='.$donnees['id_album'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    </div>
                    
                                                    

                                                    <div class="pull-right">';
                                                    /*str_pad 2 = le nombre souhaité, et '0'= le nombre qui vient s'ajouter à gauche avec STR_PAD_LEFT
                                                    Permet de remplacer tome 1 par tome 01 etc...*/

                                                        echo'<span>';echo str_pad($donnees['tome'], 2, '0', STR_PAD_LEFT);echo' / ';echo str_pad($donnees['nbre_serie'], 2, '0', STR_PAD_LEFT);echo'</span>
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
                               echo '<li class="active"><a href="/bdthek/sections/papier.php?page='.$i.'">'.$i.'</a></li>'; 
                           }  
                             else //Sinon...
                             {
                              echo ' <li><a href="/bdthek/sections/papier.php?page='.$i.'">'.$i.'</a></li> ';

                          }
                      }

                      echo'</ul>';
                      ?>

            </div><!-- fin col-lg-6 -->
                  <!-- /.panel .chat-panel -->
                  <div class=" col-md-6 col-lg-6 div-dessin-papillon">

                    <aside class="circle-orange"></aside>
                    <aside class="circle-vert"></aside>
                    <p class="text-aside-circle">DASHBOARD</p>
                    <aside class="circle-bleu"></aside>
                    <aside class="circle-jaune"></aside>
                </div>
               
                <div class="col-lg-6">
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Les derniers ajout
                        </div>
                        <div class="panel-body panel-display">
                            <?php
                            $db = Database::connect();
                            $statement = $db->query('
                                SELECT a.id AS id_album, a.date_ajout AS date_ajout, a.name AS nom_album, a.images AS cover, a.serie AS serie_album, t.id AS type_id, t.type AS type_name, s.name AS nom_serie, g.name AS nom_genre, a.tome AS tome, s.tome AS nbre_serie
                                FROM series AS s
                                INNER JOIN types AS t ON t.id = s.type
                                INNER JOIN albums AS a ON a.serie = s.id
                                INNER JOIN genres AS g ON s.genre = g.id
                                WHERE t.id = 2
                                ORDER BY date_ajout DESC LIMIT 6
                                
                                ');
                            while($donnees = $statement->fetch())
                            {
                                echo'<div class="col-lg-5 col-sm-6 col-md-4 col-xs-12 dernierBD-ajout">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                                                 <img src="../images/'.$donnees['cover'] .'" alt="Cover BD" width="100px" height="140px class="cover-one-shot-bd">
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                                                <h5 class="titre-dernier-ajout">'.$donnees['nom_serie'].'</h5>
                                                <strong class="tome_dernier-ajout">'.$donnees['tome'].' . </strong><span> '.$donnees['nom_album'].'</span><br>
                                                <div class="rating rating2">
                                                        <span>'.$donnees['nom_genre'].'</span>
                                                        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>';
                        }
                        Database::disconnect();
                        ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Les One Shot
                            <span class="pull-right"><?php echo ' '.$oneShotBD['nbre_oneShot_bd_papier'];?> albums</span>
                        </div>
                        <div class="panel-body panel-display">
                            <?php
                            $db = Database::connect();
                            $statement = $db->query('
                                SELECT * FROM one_shot WHERE type = 2 ORDER BY name 
                                ');
                            while($donnees = $statement->fetch())
                            {
                                echo'<div class="col-lg-2 col-sm-2 col-md-2 col-xs-4 div-one-shot">
                                <img src="../images/'.$donnees['images'] .'" alt="Cover BD" width="140px" height="180px class="cover-one-shot-bd">
                            </div>';
                        }
                        Database::disconnect();
                        ?>
                        </div>
                    </div>
                </div>

        </div><!-- fin row -->
        
        <!-- Fin panel album -->
        
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->
</div><!-- fin #wrapper -->
<!-- footer -->
<?php include("../pages/footer.php") ; ?>
</body>
</html>