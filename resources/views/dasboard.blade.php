<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container-lg">
          <a class="navbar-brand fw-bold" href="#">{{@$user->name}}</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#hero">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#services">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#projects">Projects</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#testimonials">Testimonials</a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-lg-none" href="#contact">Contact</a>
              </li>
            </ul>
            <a class="btn btn-outline-dark d-none d-lg-block" href="{{route('logout')}}">Log Out</a>
          </div>
        </div>
      </nav>
    
      <section class="hero" id="hero">
        <div class="container-lg">
          <div class="row align-items-center sec_row">
            <div class="col-sm-6">
              <h1 class="display-2 fw-bold">{{@$user->name}}</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce rutrum laoreet finibus. Sed porta
                lobortis metus sed commodo. Fusce convallis vestibulum velit, id imperdiet metus faucibus nec.
              </p>
              @if($username == "Admin")
                <button type="button" class="btn btn-dark btn-lg add">Add Tenant</button>
              @else
               <button type="button" class="btn btn-dark btn-lg add_customer">Add Customer</button>
              @endif
            </div>
            <div class="col-sm-6 text-center">
              <img src="https://codingyaar.com/wp-content/uploads/barista.png" class="img-fluid" alt="">
            </div>
          </div>
        </div>
      </section>
      @if($username == "Admin")
        <div class="container">
            
            <div class="table-responsive table_div">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tenant Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Domain</th>
                        <th scope="col">Tenant Id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenant_info as $index => $tenant)
                            <tr>
                            <th scope="row">{{@$index + 1}}</th>
                            <td>{{$tenant->name}}</td>
                            <td>{{$tenant->email}}</td>
                            <td>{{$tenant->domain}}</td>
                            <td>{{$tenant->tenant_id}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form_div mb-3" style="display:none; margin-top:5rem;">
                <div class="card">     
                    <div class="card-body">
                        <div class="card-title text-center h3">Create New Tenant</div>
                        {{ Form::open(['url' => route('tenant_create'), 'method' => 'post', 'id'=> 'create_form', 'class' => 'form-horizontal card-body cardbody-color p-lg-5', 'autocomplete' => 'off']) }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email </label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Domain Name</label>
                            <input type="text" name="domain_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger cancel">Cancel</button>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>  
      @else
        <div class="container">             
            <div class="table-responsive table_cust_div">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(isset($tenant_info))
                        @foreach($tenant_info as $index => $tenant)
                            <tr>
                            <th scope="row">{{@$index + 1}}</th>
                            <td>{{@$tenant->name}}</td>
                            <td>{{@$tenant->gmail}}</td>
                            <td>{{@$tenant->mobile}}</td>
                            @php
                               if($tenant->gender == 1){
                                 $gender = "Male";
                               }
                               else if($tenant->gender == 2){
                                 $gender = "Female";
                               } 
                               else{
                                 $gender = "Others";
                               }
                            @endphp
                            <td>{{@$gender}}</td>
                            </tr>
                        @endforeach
                      @endif  
                    </tbody>
                </table>
            </div>
            <div class="form_cust_div mb-3" style="display:none; margin-top:5rem;">
                <div class="card">     
                    <div class="card-body">
                        <div class="card-title text-center h3">Create New Customer</div>
                        {{ Form::open(['url' => route('customer_create'), 'method' => 'post', 'id'=> 'create_form', 'class' => 'form-horizontal card-body cardbody-color p-lg-5', 'autocomplete' => 'off']) }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email </label>
                            <input type="email" name="gmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Mobile </label>
                            <input type="text" name="mobile" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Gender</label>
                            <select class="form-select" aria-label="Select Gender" name = "gender">
                              <option selected>Select Gender</option>
                              <option value="1">Male</option>
                              <option value="2">Female</option>
                              <option value="3">Others</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger cancel">Cancel</button>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>  
      @endif
      <footer class="text-center p-3 bg-body-tertiary">
        <div>&copy; 2024. All Rights Reserved.</div>
      </footer>
      
     
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(".add").on("click",function(){
        $(".table_div").hide();
        $(".form_div").show();
        $(".sec_row").hide();
        $(this).hide();
    });
    $(".cancel").on("click",function(){
        $(".table_div").show();
        $(".form_div").hide();
        $(".sec_row").show();
        $(".add").show();
        // $("#create_form").clear();
    });
    $(".add_customer").on("click",function(){
        $(".table_cust_div").hide();
        $(".form_cust_div").show();
        $(".sec_row").hide();
        $(this).hide();
    });
    $(".cancel").on("click",function(){
        $(".table_cust_div").show();
        $(".form_cust_div").hide();
        $(".sec_row").show();
        $(".add_customer").show();
        // $("#create_form").clear();
    });
</script>
</html>