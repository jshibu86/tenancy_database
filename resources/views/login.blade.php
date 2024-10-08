<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta2/js/bootstrap.min.js"></script>
</head>
<body>
   <style>
       .btn-color{
        background-color: #0e1c36;
        color: #fff;
        
        }

        .profile-image-pic{
        height: 200px;
        width: 200px;
        object-fit: cover;
        }



        .cardbody-color{
        background-color: #ebf2fa;
        }

        a{
        text-decoration: none;
        }
    </style>
    <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <h2 class="text-center text-dark mt-5">Login Form</h2>
            <div class="card my-5">
    
             
                {{ Form::open(['url' => route('dobackendlogin'), 'method' => 'post', 'id'=> 'login_form', 'class' => 'form-horizontal card-body cardbody-color p-lg-5', 'autocomplete' => 'off']) }}
                <div class="text-center">
                  <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                    width="200px" alt="profile">
                </div>
    
                <div class="mb-3">
                  <input type="text" class="form-control" id="Username" aria-describedby="emailHelp" name="email"
                    placeholder="User Email">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" id="password" placeholder="password" name="password">
                </div>
                @if ($errors->any())
                @php
                   if($errors->has('user') && $errors->has('password')){
                      $name = "username_password_error";
                   }
                   else if($errors->has('password')){
                      $name = "password_error";
                   }
                   else{
                      $name = "username_error";
                   } 
                @endphp
                  <div class="alert alert-danger mt-2 {{$name}}">

                      {{ implode('', $errors->all(':message')) }}

                  </div>
              @endif
                <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100">Login</button></div>
                <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not
                  Registered? <a href="#" class="text-dark fw-bold"> Create an
                    Account</a>
                </div>
                {{ Form::close()}}
            </div>
    
          </div>
        </div>
      </div> 
</body>
</html>