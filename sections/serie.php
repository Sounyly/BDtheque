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
                    <h1 class="page-header">Séries</h1>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="dashboard-row">
              <?php include("../inc/dashboard.php"); ?>
          </div>


          <div class="row">
            <div class="col-lg-6">
                <!-- Debut panel album -->

                <div class="chat-panel panel panel-default">

                    <div class="panel-heading">
                        <i class="fa fa-comments fa-fw"></i> Séries BD
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="../admin/insert-serie.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter une serie</a></li>
                                <li><a href="../admin/insert-serie.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Voir les séries papiers</a></li>
                                <li><a href="../admin/insert-serie.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Voir les séries epub</a></li>
                            </ul>
                        </div>

                    </div>

                    <!-- /.panel-heading -->
                    <div id="serieComplete" class="panel-body">
                        <ul class="chat">
                            <?php  
                            $db = Database::connect();
                            $seriesParPage = 25; //on affiche 15 albums par page
                            /*----pagination-------*/
                            $statement = $db->query('SELECT COUNT(*) AS total_serie FROM series WHERE type = 2');
                            $req=$statement->fetch();//On range statement sous la forme d'un tableau
                            $resultat=$req['total_serie']; //On récupère le total pour le placer dans la variable $resultat.
                            /*calculer le nombre de pages*/
                            //on compte le nombre de page necessaire à l'entier supérieur
                            $nombreDePages=ceil($resultat/$seriesParPage); // fonction ceil() pour avoir le nombre entier supérieur

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

                $premiereEntree=($pageActuelle-1)*$seriesParPage; // On calcul la première entrée à lire

                $statement=$db->query('
                SELECT  s.id AS id_serie, s.name AS nom_serie, a.serie AS album_serie, s.tome AS nbre_tome, a.images AS image, g.name AS nom_genre, t.id AS type_id, t.type AS name_type,  COUNT(*) AS nbre_album
                FROM series AS s
                INNER JOIN types AS t ON t.id = s.type
                INNER JOIN albums AS a ON s.id = a.serie
                INNER JOIN genres AS g ON s.genre = g.id
                GROUP BY s.id
                ORDER BY s.name
                LIMIT '.$premiereEntree.','.$seriesParPage.'
                ');
                $recapSerie = $statement->fetchAll();
                foreach($recapSerie as $recapSeries)
                {
                echo'
                <li class="left clearfix li-serie">
                    <span class="chat-img pull-left">

                        <img src="../images/'.$recapSeries['image'] .'" alt="Cover BD" width="50px" height="70px" class="">
                    </span>
                    <div class="chat-body clearfix ">
                        <div class="header serie">
                            <strong class="primary-font name_album">'.$recapSeries['nom_serie'].'</strong><br>

                            <span class="genre rouge pull-left ">' .$recapSeries['nom_genre']. '</span>';
                            if($recapSeries['type_id'] == 2)//si le type est papier on affiche un livre à coté du nom
                            {   
                            echo'<div class="div-span-serie">
                            <span><i class="fa fa-book" aria-hidden="true"></i>
                                '.$recapSeries['name_type'].'</span>
                            </div>';

                        }//sinon si le type est epub on affiche un petit globe à coté
                        else if($recapSeries['type_id'] == 3)
                        {
                        echo'<div class="div-span-serie">
                        <span><i class="fa fa-globe" aria-hidden="true"></i>

                            '.$recapSeries['name_type'].'</span>
                        </div>';
                    }  

                    echo'</div>
                    <div class=" bouton-delete btn-group pull-right bouton-serie">
                                                        <a class="btn btn-danger" href="../admin/delete-serie.php?id='.$recapSeries['id_serie'].'"><span class="glyphicon glyphicon-remove"></span></a>
                                                        <a class="btn btn-primary" href="../admin/update-serie.php?id='.$recapSeries['id_serie'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    </div>

                    ';
                    /*str_pad($recapSeries['nbre_album'], 2, '0', STR_PAD_LEFT) permet de convertir les 1 en 01, il ajoute un 0 à gauche du chiffre*/
                    if($recapSeries['nbre_album'] != $recapSeries['nbre_tome'])
                    {
                    echo'<div class="pull-right div-tome-serie">
                    <a href="#" class="a_modal" data-toggle="modal" data-target="#'.$recapSeries['id_serie'].'"><span class="rouge">';echo str_pad($recapSeries['nbre_album'], 2, '0', STR_PAD_LEFT);echo' / ';echo str_pad($recapSeries['nbre_tome'], 2, '0', STR_PAD_LEFT);echo' <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></span></a>
                </div>';
            }
            else
            {
            echo'<div class="pull-right div-tome-serie">
            <a href="#" class="a_modal" data-toggle="modal" data-target="#'.$recapSeries['id_serie'].'"><span class="green">';echo str_pad($recapSeries['nbre_album'], 2, '0', STR_PAD_LEFT); echo' / ' ;echo str_pad($recapSeries['nbre_tome'], 2, '0', STR_PAD_LEFT);echo' <i class="fa fa-check" aria-hidden="true"></i></span></a>

        </div>';      
    }


    echo'</div>
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
    echo '<li class="active"><a href="/bdthek/serie/serie.php?page='.$i.'">'.$i.'</a></li>'; 
}  
else //Sinon...
{
  echo ' <li><a href="/bdthek/serie/serie.php?page='.$i.'">'.$i.'</a></li> ';

}
}

echo'</ul>';
?>
</div><!-- fin col -->


<?php 
foreach($recapSerie as $recapSeries)

{// modal pour albums possédés
  echo'
  <div class="modal fade" id="'.$recapSeries['id_serie'].'" role="dialog">
    <div class="modal-dialog modal-serie-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal_titreSerie">' .$recapSeries['nom_serie'].' - ' . $recapSeries['nbre_album']. ' / ' .$recapSeries['nbre_tome'] . '</h4>

        <div class="modal-body modal-body-album">


          ';
          $db = Database::connect();
          $statement = $db->prepare('SELECT * FROM albums WHERE albums.serie = ?');
          $statement->execute(array($recapSeries['id_serie']));
          Database::disconnect();
          while($album = $statement->fetch())
          {
          echo'<div class="modal_album ">


          <h4 class="modal_titreAlbum">'.$album['name'].'</h4>
          <img src="../images/'.$album['images'] .'" alt="Cover BD" width="95px" height="140px" class="cover-modal-serie">
          <span>T . ' .$album['tome'].'</span>
      </div>';
  }
  echo'</div>
  ';

  if($recapSeries['nbre_album'] != $recapSeries['nbre_tome'])
  {
  echo '
  <hr>
  <h2 class="text-center"><span class="glyphicon glyphicon-shopping-cart"></span></h2>
  <div class="modal-body modal-body-album">
      ';
      $db = Database::connect();
      $statement = $db->prepare('SELECT * FROM whishlist WHERE whishlist.serie = ?');
      $statement->execute(array($recapSeries['id_serie']));
      Database::disconnect();

      while($whishlist = $statement->fetch())
      {
      echo'<div class="modal_album">

      <h4 class="modal_titreAlbum">'.$whishlist['name'].'</h4>
      <img src="../images/'.$whishlist['images'] .'" alt="Cover BD" width="95px" height="140px" class="cover-modal-serie">
      <span>T . ' .$whishlist['tome'].'</span>
      <div><span class="glyphicon glyphicon-shopping-cart tableau album_manquant"></span></div>
  </div>';
}

echo'</div>';
}


echo'
<div class="modal-footer">
    <span>'.$recapSeries['nom_genre'] . '</span>
</div>
</div>
</div>
</div>';
}

?>




<div class=" col-lg-6">
    <?php include("serie-complete.php"); ?>
</div>
</div><!-- fin container-fluid -->
</div><!-- fin #page-wrapper -->    
</div><!-- fin #wrapper -->
<?php include("../pages/footer.php") ; ?>
</body>
</html>






