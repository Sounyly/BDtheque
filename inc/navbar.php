    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            
            
            <!-- zone de recherche -->
            <li class="search">
            <form class="navbar-form navbar-right search" action="/bdthek/inc/search.php" method="get">
              <div class="input-group">
                <input type="text" class="form-control" name="query" placeholder="Search">
                  <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                      <i class="glyphicon glyphicon-search"></i>
                    </button>
                  </div>
              </div>
           </form> 
            </li>          
            
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse ">
            <ul class="nav navbar-nav side-nav sidebar">
                <li>
                    <a href="/bdthek/index.php">Accueil</a>
                </li>

                <li>
                    <a href="#" data-toggle="collapse" data-target="#submenu-1"><i class="fa fa-book" aria-hidden="true"></i> BD<i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-1" class="collapse">
                        <li><a href="/bdthek/sections/papier.php"> Papier</a></li>
                        <li><a href="#"> ePub</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="collapse" data-target="#submenu-2"><i class="fa fa-ravelry" aria-hidden="true"></i> Manga<i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-2" class="collapse">
                        <li><a href="#"> Papier</a></li>
                        <li><a href="#"> ePub</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="#" data-toggle="collapse" data-target="#submenu-3"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Wishlist<i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-3" class="collapse">
                    <li><a href="/bdthek/sections/wishlist.php">BD</a></li>
                        <li><a href="#">Mangas</a></li>
                        
                    </ul>
                </li>

                <li>
                    <a href="/bdthek/sections/serie.php"><i class="fa fa-bookmark" aria-hidden="true"></i> Séries</a>
                </li>
                
                 <li>
                    <a href="#" data-toggle="collapse" data-target="#submenu-4"><i class="fa fa-wrench" aria-hidden="true"></i> Gestion<i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-4" class="collapse">
                        <li><a href="/bdthek/admin/insert-bd.php"> Ajouter une BD</a></li>
                        <li><a href="/bdthek/admin/insert-serie.php"> Ajouter une série</a></li>
                        <li><a href="/bdthek/admin/insert-bd-one-shot.php"> Ajouter un one-shot</a></li>
                        <li><a href="/bdthek/admin/insert-bd-wishlist.php"> Ajouter  Wishlist</a></li>
                    </ul>
                </li>
                <li><a class="text-navbar" href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a class="text-navbar" href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                
            </ul>
            
        </div>
        <!-- /.navbar-collapse -->

    </nav>

    


<script>
    $(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $(".side-nav .collapse").on("hide.bs.collapse", function() {                   
        $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
    });
    $('.side-nav .collapse').on("show.bs.collapse", function() {                        
        $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");        
    });
})    
    
</script>