<!doctype html>
<html lang="en">
<head>
<?php require_once __DIR__ . '/../parts/head.template.php'; ?>
</head>
<body>
<?php require_once __DIR__ . '/../parts/nav.template.php'; ?>
    <div class="container">

        <div class="row">
            <div class="col-lg-3">

            </div>
                <div class="col-lg-6">
                    <form action="/ads/create" method="POST">
                        <div class="form-group">
                            <h1>Add creation form</h1>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo isset($_SESSION['data']['title']) ? $_SESSION['data']['title'] : ''; ?>">
                            <span style="color:red;font-size: 14px;"><?= error('title'); ?></span>
                         </div>
                         <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="10" cols="45" name="description" value="<?php echo isset($_SESSION['data']['description']) ? $_SESSION['data']['description'] : '' ;?>"></textarea>
                             <span style="color:red;font-size: 14px;"><?= error('description'); ?></span>
                         </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-lg-3">
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../parts/scripts.template.php'; ?>
</body>
</html>
