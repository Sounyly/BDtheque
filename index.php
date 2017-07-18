<?php
require 'admin/database.php';
include("inc/header.php") ;
?>

<body>

    <div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">

       <?php include("inc/navbar.php"); ?>
       <div id="page-wrapper">
        <div class="container-fluid">
        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Welcome!</h1>

                </div>
                <!-- /.col-lg-12 -->
            </div>
           <?php include("inc/dashboard.php"); ?>
           <div class="row">

           	
            <?php include("sections/genre.php"); ?>
         

            <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Graphique des genres
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
       
</div>
<?php include("inc/footer.php") ; ?>
</body>

</html>
