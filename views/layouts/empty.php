<!--
=========================================================
* Soft UI Dashboard - v1.0.6
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Soft UI Dashboard by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.6" rel="stylesheet" />
    <link href="../assets/js/plugins/toastr/toastr.min.css" rel="stylesheet" />

    <script
        src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous"></script>
    <script src="../assets/js/plugins/toastr/toastr.min.js"></script>

</head>

<body class="">
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid pe-0">
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="#">
                        Cineplexx
                    </a>
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav me-1 ms-auto">
                            <?php
                            use app\core\Application;

                            $sessionRoles = Application::$app->session->get(Application::$app->session->ROLE_SESSION);

                            $strongestRole = "Customer";

                            if ($sessionRoles !== false) {
                                foreach ($sessionRoles as $role) {
                                    if ($role === "Manager")
                                        $strongestRole = "Manager";
                                    if ($role === "Admin")
                                        $strongestRole = "Admin";
                                }
                            }

                            if ($strongestRole === "Manager") {
                                echo '<li class="nav-item">';
                                echo '<a class="nav-link me-2" href="/managerDirections">';
                                echo '<i class="fa fa-lock opacity-6 text-dark me-1"></i>';
                                echo 'Manager';
                                echo '</a>';
                                echo '</li>';
                            }

                            if ($strongestRole === "Admin") {
                                echo '<li class="nav-item">';
                                echo '<a class="nav-link me-2" href="/adminDirections">';
                                echo '<i class="fa fa-lock opacity-6 text-dark me-1"></i>';
                                echo 'Admin';
                                echo '</a>';
                                echo '</li>';
                            }

                            if ($strongestRole === "Customer") {
                                echo '<li class="nav-item">';
                                echo '<a class="nav-link me-2" href="/movies">';
                                echo '<i class="fa fa-film opacity-6 text-dark me-1"></i>';
                                echo 'Movies';
                                echo '</a>';
                                echo '</li>';
                            }

                            ?>
                            <li class="nav-item">
                                <a class="nav-link me-2" href="/userProfile">
                                    <i class="fa fa-user opacity-6 text-dark me-1"></i>
                                    My profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-2" href="/registration">
                                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                    Sign Up
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php
                                $params = Application::$app->session->get(Application::$app->session->USER_SESSION);

                                    if ($params !== false) {
                                        echo "<a class='nav-link me-2' href='/logout'>";
                                        echo "<i class='fas fa-key opacity-6 text-dark me-1'></i>";
                                        echo "Logout";
                                        echo "</a>";
                                    } else {
                                        echo "<a class='nav-link me-2' href='/login'>";
                                        echo "<i class='fas fa-key opacity-6 text-dark me-1'></i>";
                                        echo "Sign in";
                                        echo "</a>";
                                    }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>
<main class="main-content  mt-0">
    <section>
        <div class="container-fluid">
            {{ renderPartialView }}
        </div>
    </section>
</main>
<!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
<footer class="footer py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mx-auto text-center">
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    Company
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    About Us
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    Team
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    Products
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    Blog
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    Pricing
                </a>
            </div>
            <div class="col-lg-8 mx-auto text-center mb-4 mt-2">
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                    <span class="text-lg fab fa-dribbble"></span>
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                    <span class="text-lg fab fa-twitter"></span>
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                    <span class="text-lg fab fa-instagram"></span>
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                    <span class="text-lg fab fa-pinterest"></span>
                </a>
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                    <span class="text-lg fab fa-github"></span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-8 mx-auto text-center mt-1">
                <p class="mb-0 text-secondary">
                    Copyright © <script>
                        document.write(new Date().getFullYear())
                    </script> Soft by Creative Tim.
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
<!--   Core JS Files   -->
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


<?php



$success = Application::$app->session->getFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS);

if ($success !== false) {
    echo "
            <script>
            $(document).ready(function() {
                toastr.success('$success');
            });
</script>
        ";
}

$error = Application::$app->session->getFlash(Application::$app->session->FLASH_MESSAGE_ERROR);

if ($error !== false) {
    echo "
            <script>
            $(document).ready(function() {
                toastr.error('$error');
            });
</script>
        ";
}
?>

</body>

</html>
