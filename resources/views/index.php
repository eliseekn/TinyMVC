<!DOCTYPE html>
<html lang="<?= config('app.lang') ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="TinyMVC is a PHP framework based on MVC architecture that helps you build easly and quickly powerful web applications and RESTful API">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>TinyMVC | Just a PHP framework based on MVC architecture</title>
</head>

<body>
    <div class="container text-center p-5">
        <h1 class="font-weight-bold display-4">TinyMVC</h1>

        <p class="lead mt-4" style="line-height: 1.8">
            Just a PHP framework based on MVC architecture that helps you <br> 
            build easly and quickly powerful web applications and RESTful API.
        </p>

        <hr class="my-5 w-25">

        <span>
            <a href="https://github.com/eliseekn/tinymvc" class="btn btn-dark">
                <i class="fab fa-github"></i> Github
            </a>
            
            <a href="<?= absolute_url('docs') ?>" class="ml-3 btn btn-primary">
                <i class="fa fa-book"></i> Documentation
            </a>
            
            <a href="<?= absolute_url('login') ?>" class="ml-3 btn btn-success">
                <i class="fa fa-user"></i> Log in
            </a>
        </span>
    </div>

    <script defer src="https://use.fontawesome.com/releases/v5.13.0/js/all.js"></script>
</body>

</html>
