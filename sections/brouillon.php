<?php 

/*------------------------------------------
  Requête pour afficher des albums aléatoire provenant de la wishlist
--------------------------------------------*/
?>

<div class="col-lg-3">
    <div class="chat-panel panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Albums manquants (aléatoire)
        </div>
        <div class="panel-body">
        <div class="row">
              <?php 
              $db = Database::connect();
              $req=$db->query('
                  SELECT * FROM whishlist 
                  JOIN (SELECT FLOOR (COUNT(*))* RAND() AS valeurAleatoire FROM whishlist) AS v ON whishlist.id >= v.valeurAleatoire
                  /*ORDER BY RAND()*/
                 LIMIT 6
                  ');
              while($donnees = $req->fetch())
              {
                  $str = $donnees['name'];
                  if(strlen($str)<20)
                  {
                      echo'
                      <div class="col-lg-6 col-md-2 col-sm-2 col-xs-4 div-serie-bd-wish">
                        
                        <h5 class="titre-ajout-aleatoire"><span class="serieTome">' .$donnees['tome'].'.</span> '  .$donnees['name'].'</h5>
                        <img src="../images/'.$donnees['images'] .'" alt="Cover BD" width="100px" height="140px class="cover-one-shot-bd"><br>
                    </div>';
                }
            }
            ?>
            </div>
        </div>
    </div>
</div><!-- fin col -->

 