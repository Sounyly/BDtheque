
	
		<div class=" col-lg-6 col-xs-12">

			<div class="panel-default panel">
                <div class="panel-heading">
                    <i class="fa fa-comments fa-fw"></i> Les genres
                </div><!-- fin panel-heading -->
				<div class="panel-body">
				
						<?php 
						$db = Database::connect();
						$statement=$db->query('
							SELECT 
							g.id AS id_genre,
							g.name AS nom_genre,
							a.name AS nom_album,
							a.tome AS tome_album,
							a.genre AS genre_album,
							a.images AS img_album,
							COUNT(*) AS nbre_album_genre

							FROM albums AS a
							
							LEFT JOIN genres AS g ON a.genre = g.id
							GROUP BY g.id
							ORDER BY g.name
							/**/
							');
						$donnee=$statement->fetchAll();
						foreach($donnee as $donnees)
						{
							echo'
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
								<div class="row">
									<h4 class="col-lg-12 text-center">'.$donnees['nom_genre']. '</h4><br>
									<div class="row">
										<div class="col-lg-12 text-center">
											<img src="images/'.$donnees['img_album'].'" alt="Cover BD" width="70px" height="70px" class="img-circle">
										</div>
									</div>
								</div>
								<br>
									<div class="row">
										<div class="col-lg-12 text-center span-nbre-genre"
											<span"> ';echo str_pad($donnees['nbre_album_genre'], 2, '0', STR_PAD_LEFT);echo ' albums</span>

										</div>
									</div>
									
							</div>

							';
						}
						Database::disconnect();
						?>

					
				</div><!-- fin panel-body -->
				<div class="panel-footer">Panel Footer</div>
			</div><!-- fin panel-default -->
		</div><!-- fon col-lg -->

