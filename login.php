<?php
    require_once('controllers/authController.php');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="icon" href="images/logo.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>

    <body>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                    QA_Stack
                </a>
            </div>
        </nav>

        <?php if(isset($_SESSION['no-access'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['no-access']; 
                    unset($_SESSION['no-access']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 form-div login">
                    <form action="login.php" method="post">
                        <h3 class="text-center">Login</h3>

                        <?php if (count($errors) > 0): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php foreach($errors as $error): ?>

                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="username">Username or Email</label>
                            <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg btn-enter">Login</button>
                        </div>
                        <div class="form-group">
                            <p class="text-center">Not yet a member? <a href="signup.php">Sign Up here!</a></p>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>