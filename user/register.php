<?php

session_start();
if (isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
  require_once('../db.php');

  $error =[];
  $user ='';
  $birth = '';
  $email = '';
  $phone = '';
  $address = '';
  $frontID = '';
  $backID = '';
  if(isset($_POST['user']) && isset($_POST['birth']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address'])){
    $user = $_POST['user'];
    $birth = $_POST['birth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $frontID = $_POST['frontID'];
    $backID = $_POST['backID'];

    if(empty($user)){
      $error['user'] = 'Please enter your username!';
    } else if(empty($birth)){
      $error['birth'] = 'Please enter your birthday!';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false){
      $error['email'] = 'Email adress not valid!';
    } else if(empty($phone)){
      $error['phone'] = 'Please enter your phone!';
    } else if(empty($address)) {
      $error['address'] = 'Please enter your address!';
    }
    else if(empty($frontID)){
      $error['frontID'] = 'Please enter front face of ID';
    } else if(empty($backID)){
      $error['backID'] = 'Please enter back face of ID';
    }
    else {
            // register a new account
          $result = register($user, $birth, $email,$address ,$phone);
          if($result['code'] == 0){
            $error = $result['code'];
            echo "<script>
            alert('Create account successfully!');
            window.location='../index.php';    
            </script>";

          }
         else if($result['code'] == 3){
          $error['phone'] = 'This phone is already exists!';
        }else if ($result['code'] == 1) {
          $error['email'] = 'This email is already exists!';
        }
    }




  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
            <form method="post" action="" novalidate>

              <div class="row">
                <div class="col-md-12 mb-4 d-flex align-items-center">
                <div class="form-outline datepicker w-100">
                    <input type="text" id="user" class="form-control form-control-lg" name = "user" placeholder="User Name"/>
                    <span class="back-login"
                            style="color: red"><?php echo (isset($error['user']))?$error['user']:'' ?></span>
                </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 mb-4 d-flex align-items-center">

                  <div class="form-outline datepicker w-100">
                    <input type="date" class="form-control form-control-lg" id="birthdayDate" name="birth" placeholder="Birth day"/>
                    <span class="back-login"
                            style="color: red"><?php echo (isset($error['birth']))?$error['birth']:'' ?></span>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                  <div class="form-outline">
                    <input type="email" id="emailAddress" class="form-control form-control-lg" name="email" placeholder="Email"/>
                    <span class="back-login"
                            style="color: red"><?php echo (isset($error['email']))?$error['email']:'' ?></span>
                  </div>

                </div>
                <div class="col-md-6 mb-4 pb-2">

                  <div class="form-outline">
                    <input type="tel" id="phoneNumber" class="form-control form-control-lg" name ="phone" placeholder="Phone Number"/>
                    <span class="back-login"
                            style="color: red"><?php echo (isset($error['phone']))?$error['phone']:'' ?></span>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-12 mb-4 d-flex align-items-center">
                <div class="form-outline datepicker w-100">
                    <input type="text" id="address" class="form-control form-control-lg" name = "address" placeholder="Address"/>
                    <span class="back-login"
                            style="color: red"><?php echo (isset($error['address']))?$error['address']:'' ?></span>
                </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                  <div class="form-outline">
                        <input type="file" name="frontID" class="form-control form-control-lg" id="document" >
						            <label class="form-label" for="document">Choose front face of ID </label>
                  </div>

                </div>
                <div class="col-md-6 mb-4 pb-2">
                  <div class="form-outline">
                        <input type="file" name="backID" class="form-control form-control-lg" id="document">
						            <label class="form-label" for="document">Choose back face of ID </label>
                  </div>

                </div>
              </div>


             

              <div class="mt-4 pt-2">
                <input class="btn btn-primary btn-lg" type="submit" value="Submit" />
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>