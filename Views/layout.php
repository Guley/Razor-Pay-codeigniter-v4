<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo site_url(); ?>favicon.ico" >
    <title><?php echo isset($page_title)?$page_title:SITE_NAME; echo ' | '.SITE_NAME; ?></title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</head>
<body>
    <header>
    <h1>Header Here <a href="<?= base_url() ?>">Back to home</a></h1>
    <li><a href="<?= base_url('pricing') ?>">Pricing</a></li>
    </header>

    <?php echo view($template_file); ?>

    <footer>
        <div id="copyright" class="container-fluid">
            <div class="container text-center">
                <p>Copyright © <?= date('Y') ?> <?= SITE_NAME ?> | All Rights Reserved</p>
            </div>
        </div>
    </footer>
    <script>
    var SITE_URL = "<?php echo site_url(); ?>";
    var CURRENT_URL = "<?php echo current_url(); ?>";
    </script>
    <?php if(isset($add_custom_js)){
        echo '<script>'.$add_custom_js.'</script>';
    } ?>
</body>
</html>
