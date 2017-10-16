<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WG Main Menu</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
        <!-- Angular Material requires Angular.js Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>

        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">

        <!-- Angular Material Library -->
        <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>

        <link href="../css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body ng-app="wgplaner">
        <div cladd="container" align="center">
            <?php include_once("navbar.html") ?>

            <!-- Page Content -->
            <h1>Deine Funktionen</h1>

            <div class="services" style="padding-top: 100px;">
                <div class="row-fluid">
                    <a href="./Finanzen/dashboard.php"><div class="col-md-4">
                        <div class="card card-1" style="padding: 50px;">
                            <i class="material-icons" style="font-size: 120px;">attach_money</i>
                            <h3>Finanzen</h3>
                        </div>   
                        </div></a>

                    <a href="#"><div class="col-md-4">
                        <div class="card card-2" style="padding: 50px;">
                            <i class="material-icons" style="font-size: 120px;">cloud_queue</i>
                            <h3>Owncloud</h3>
                        </div>   
                        </div></a>

                    <div class="col-md-4">
                        <div class="card card-2" style="padding: 50px;">
                            <i class="material-icons" style="font-size: 120px;">build</i>
                            <h3>To be extended...</h3>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </body>
</html>
