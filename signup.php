<?php
    require_once('controllers/authController.php');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Register</title>
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

        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 form-div">
                    <form action="signup.php" method="post">
                        <h3 class="text-center">Register</h3>

                        <?php if (count($errors) > 0): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php foreach($errors as $error): ?>

                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="passwordConf">Confirm Password</label>
                            <input type="password" name="passwordConf" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg btn-enter">Sign Up</button>
                        </div>
                        <div class="form-group">
                            <p class="text-center">Already a member? <a href="login.php">Sign In</a></p>
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>