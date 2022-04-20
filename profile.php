<?php
    include_once('controllers/authController.php');

    if (!isset($_SESSION['id'])) {
        // $errors['no-access'] = "You need to be logged in to access this page!";
        header('location: login.php');
        exit();
    }


?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="icon" href="images/logo.png">
        <script src="https://kit.fontawesome.com/3316384b3d.js" crossorigin="anonymous"></script>
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
                <li class="nav-item"><a href="index.php">Home</a>  </li>
                <li>  <a class="" href="profile.php"><i class="fas fa-user-circle fa-1x"> Profile</i>  </a>  </li>
                <li><a class="" href="index.php?logout=1"><i class="fas fa-sign-out-alt fa-1x"> Logout</i>  </a></li>
            </div>
        </nav>

        
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 home-qa">

                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert <?php echo $_SESSION['alert-class']; ?> alert-dismissible fade show" role="alert">
                            <?php 
                                echo $_SESSION['message']; 
                                unset($_SESSION['message']);
                                unset($_SESSION['alert-class']);   
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <h4> You are logged in as <?php echo $_SESSION['username']; ?> </h4>
                </div>
            </div>
        </div>
    </body>
    <footer class="text-center text-white" style="background-color: #f1f1f1;  position:absolute;bottom:0;width:100%;">
    <!-- Grid container -->
        <div class="container pt-4">
            <!-- Section: Social media -->
            <section class="mb-4">

            <!-- Twitter -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://twitter.com/zodyto"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-twitter"></i
            ></a>

            <!-- Instagram -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://www.instagram.com/zodyto/"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-instagram"></i
            ></a>

            <!-- Linkedin -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://www.linkedin.com/in/akif-mohammed/"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-linkedin"></i
            ></a>
            <!-- Github -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://github.com/akiif"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-github"></i
            ></a>
            </section>
            <!-- Section: Social media -->
        </div>
    <!-- Grid container -->

    <!-- Copyright -->
        <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright:
            <a class="text-dark" href="index.php">QA_stack.com</a>
        </div>
    <!-- Copyright -->
    </footer>
</html>