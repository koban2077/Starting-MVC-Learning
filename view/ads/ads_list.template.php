<!doctype html>
<html lang="en">
<head>
<?php require_once __DIR__ . '/../parts/head.template.php'; ?>
<body>
<?php require_once __DIR__ . '/../parts/nav.template.php'; ?>
<div class="container">
    <div class="row">
         <div class="col-lg-12">
                <h1 class="display-1"> Ads </h1> <br><br><br>
                <div class="jumbotron">
                 <?php foreach ($adds as $add) { ?>
                    <h1 class="display-4"><?= $add['title'];?> </h1>
                    <hr class="my-4">
                    <p><?= $add['description'];?></p>
                     <p><?= $add['created_at'];?> </p>
                    <p class="lead">
                      <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                     <hr class="my-4">
                     <hr class="my-4">
                        <br><br><br>
                 </p>
                 <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../parts/scripts.template.php'; ?>
</html>
