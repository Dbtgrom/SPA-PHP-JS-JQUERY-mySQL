<?php
include_once('../Back/register.php');
include_once('../Back/entry.php');
include_once('../Back/func.php');
include_once('../Back/post-prayer.php');
$link = db_connect();
$queryForFront = "SELECT * FROM prayers";
$result = mysqli_query($link, $queryForFront );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Welcome</title>
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script src="entry.js"></script>
<script src="addPost.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<link href="styles/main.css" rel="stylesheet" >

</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Cult of the Great old one</a>
          </div>
          <ul class="nav navbar-nav">
          <?php if(isset($_COOKIE['user'])) : ?>
            <li class="active"><a href="index.php?addPost=1">Add Prayer</a></li>
            <li class="active"><a href="index.php?showPost=1">Prayers</a></li>
            <li class="active">
                <a href="index.php?log_out=1">Log Out</a>
            </li>
            <?php endif ?>

        </div>
      </nav>
<?php if(!isset($_COOKIE['user'])) : ?>
    <div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#" class="active" id="login-form-link">Login</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" id="register-form-link">Register</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" method="post" role="form" style="display: block;">
                                <div class="form-group">
                                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                </div>
                            
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                                            <input type="hidden" name="token" value="<?=$csrf_token?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                        
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="register-form" method="post" role="form" style="display: none;">
                                <div class="form-group">
                                    <input type="text" name="username-reg" id="username-reg" tabindex="1" class="form-control" placeholder="Username" value="">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email-reg" id="email-reg" tabindex="1" class="form-control" placeholder="Email Address" value="">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password-reg" id="password-reg" tabindex="2" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                                            <input type="hidden" name="token" value="<?=$csrf_token?>">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span style="color:red"><?=$error?></span>

    </div>

</div>
<?php endif ?>

<?php if(isset($_COOKIE['user'])) : ?>
    <script>
        function change(){
            document.body.style.backgroundImage  = "url('./images/holder.jpg')";
            document.body.style.backgroundRepeat = "no-repeat";
            document.body.style.backgroundAttachment = "fixed";
            document.body.style.backgroundSize = "100%";
        }
        change();
    </script>
    <?php endif ?>

    <?php if(isset($_GET['addPost'])) : ?>
        <div id="wrapper">

<form id="paper" method="post" action="../Back/post-prayer.php">
    <textarea placeholder="Enter a prayer." id="textPrayer" name="textPrayer" rows="4" style="overflow: hidden; word-wrap: break-word; resize: none; height: 160px; "></textarea>  
    <br>
    <input id="buttonPost" name="buttonPost" type="submit" value="Create">
    
</form>

</div>
<span style="color:red"><?=$error?></span>
        <?php endif ?>

        <?php if(isset($_GET['showPost'])) : ?>
            <?php while($posts = mysqli_fetch_assoc($result)):?>
            <div id="wrapper">
            <div id="prayer">
              <h1><?= $posts['artistID']?> :</h1>
              <p><?= $posts['text']?></p>
            <br>
            </div>
            </div>
             <?php endwhile ?>
        <?php endif ?>
    
</body>
</html>