<?php 
    $db = Database::connect();
    /*------------------------------------------
       BD
       --------------------------------------------*/
    // nbre album papier 
       $statement = $db->query('SELECT COUNT(*) AS nbre_album FROM albums WHERE type = 2');
       $album = $statement->fetch();
    // nbre album dematerialisé
       $statement = $db->query('SELECT COUNT(*) AS nbre_album_demat FROM albums WHERE type = 3');
       $bdDematerialise = $statement->fetch();
    // nbre one shot bd papier
       $statement = $db->query('SELECT COUNT(*) AS nbre_oneShot_bd_papier FROM one_shot WHERE type = 2');
       $oneShotBD = $statement->fetch();
    // nbre one shot bd epub
       $statement = $db->query('SELECT COUNT(*) AS nbre_oneShot_bd_epub FROM one_shot WHERE type = 3');
       $oneShotBDePub = $statement->fetch();
    // nbre album papier wishlist
       $req = $db->query('SELECT COUNT(*) AS nbre_whishlist FROM whishlist WHERE type = 2');
       $whishlist = $req->fetch(); 
    // nbre album dématérialisé wishlist
       $req = $db->query('SELECT COUNT(*) AS nbre_whishlist_demat FROM whishlist WHERE type = 3');
       $whishlistDemat = $req->fetch(); 
    /*------------------------------------------
      SERIES
      --------------------------------------------*/
    // nbre serie bd papier
      $statement = $db->query('SELECT COUNT(*) AS nbre_serieBD FROM series WHERE type = 2');
      $serieBd = $statement->fetch();
    // nbre serie bd dematerialise
      $statement = $db->query('SELECT COUNT(*) AS nbre_serieBD_demat FROM series WHERE type = 3');
      $serieDematerialiseBd = $statement->fetch();
    // nbre serie manga papier
      $statement = $db->query('SELECT COUNT(*) AS nbre_serieManga FROM series_manga WHERE type = 2');
      $serieMangaPapier = $statement->fetch();
    // nbre serie manga dematerialise
      $statement = $db->query('SELECT COUNT(*) AS nbre_serie_dematManga FROM series_manga WHERE type = 3');
      $serieMangaDematerialise = $statement->fetch();
    /*------------------------------------------
        MANGAS
        --------------------------------------------*/
    // nbre one shot papier manga
        $statement = $db->query('SELECT COUNT(*) AS nbre_oneShot_manga FROM one_shot_manga WHERE type = 2');
        $oneShotManga = $statement->fetch();
    // nbre one shot epub manga
        $statement = $db->query('SELECT COUNT(*) AS nbre_oneShot_manga_epub FROM one_shot_manga WHERE type = 3');
        $oneShotMangaePub = $statement->fetch(); 
    // nbre manga papier
        $statement = $db->query('SELECT COUNT(*) AS nbre_manga FROM mangas WHERE type = 2');
        $Manga = $statement->fetch();
    // nbre manga dematerialise
        $statement = $db->query('SELECT COUNT(*) AS nbre_manga_demat FROM mangas WHERE type = 3');
        $MangaDematerialise = $statement->fetch();
    // nbre manga papier wishlist
        $statement = $db->query('SELECT COUNT(*) AS manga_papier_manquant FROM wishlist_manga WHERE type = 2');
        $mangaPapierWishlist = $statement->fetch();
    // nbra manga dematerialise wishlist
        $statement = $db->query('SELECT COUNT(*) AS manga_demat_manquant FROM wishlist_manga WHERE type = 3');
        $mangaDematWishlist = $statement->fetch();
        Database::disconnect();
?>
 
            <div class="row">
    <!-- panel dashboard bd papier -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-bd-papier">
                        <div class="panel-heading dash-header">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-4x dash" aria-hidden="true"></i>
                                       
                                </div>
                                <div class="col-xs-9 text-right text-dash-bd">
                                    <div class="huge"><?php echo str_pad($album['nbre_album'], 2, '0', STR_PAD_LEFT);?></div>
                                    <div> BD papier</div>
                                </div>
                            </div>
                        </div>
                        <a href="/bdthek/sections/papier.php">
                            <div class="panel-footer">
                                <span class="pull-left">Voir</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
    
    <!-- panel dashboard bd epub -->
                <div class="col-lg-3 col-md-6 ">
                    <div class="panel panel-bd-epub">
                        <div class="panel-heading dash-header">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tablet fa-4x dash"></i>
                                </div>
                                <div class="col-xs-9 text-right text-dash-bd-epub">
                                    <div class="huge"><?php echo str_pad($bdDematerialise['nbre_album_demat'], 2, '0', STR_PAD_LEFT) ;?></div>
                                    <div>BD ePub</div>
                                </div>
                            </div>
                        </div>
                        <a href="/bdthek/sections/epub.php">
                            <div class="panel-footer">
                                <span class="pull-left">Voir</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
    <!-- panel dashboard bd papier -->
                <div class="col-lg-3 col-md-6 ">
                    <div class="panel panel-manga-papier">
                        <div class="panel-heading dash-header">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-4x dash"></i>
                                </div>
                                <div class="col-xs-9 text-right text-dash-manga">
                                    <div class="huge"><?php echo str_pad($Manga['nbre_manga'], 2, '0', STR_PAD_LEFT) ;?></div>
                                    <div>Manga papier</div>
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
                 <div class="col-lg-3 col-md-6 ">
                    <div class="panel panel-manga-epub">
                        <div class="panel-heading dash-header">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tablet fa-4x dash"></i>
                                </div>
                                <div class="col-xs-9 text-right text-dash-manga-epub">
                                    <div class="huge"><?php echo str_pad($MangaDematerialise['nbre_manga_demat'], 2, '0', STR_PAD_LEFT) ;?></div>
                                    <div>Mangas ePub</div>
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
    
            </div>
            <!-- /.row -->