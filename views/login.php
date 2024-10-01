<?php
/** @var $params \app\models\LoginModel
 */
?>
<div class="card card-plain mt-8">
    <div class="card-header pb-0 text-left bg-transparent">
        <h3 class="font-weight-bolder text-info text-gradient">Welcome</h3>
        <p class="mb-0">Enter your email and password to sign in</p>
    </div>
    <div class="card-body">
        <form action="/loginProcess" method="post" role="form">
            <label>Email</label>
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "email") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>
            <!--PORUKA AKO NIJE DOBAR LOGIN KAO TOASTR
               $message = Application::$app->session->getFlash("login");
               if ($message !== false) {
                   echo "<h2>$message</h2>";
               }
               -->

            <label>Password</label>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "password") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>
            <div class="text-center">
                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign In</button>
            </div>
        </form>
    </div>
    <div class="card-footer text-center pt-0 px-lg-2 px-1">
        <p class="mb-4 text-sm mx-auto">
            Have account?
            <a href="/registration" class="text-info text-gradient font-weight-bold">Sign up</a>
        </p>
    </div>
</div>
