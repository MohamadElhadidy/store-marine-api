<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>منظومة المخازن والصيانة</title>
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <style>
      input{
          text-align: center;
      }
  </style>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{ asset('images/logo.png') }}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-body">
                <form method="POST" action="/login" class="needs-validation" novalidate="">
                    @csrf
                  <div class="form-group">
                    <label for="username" class="float-right">اسم المستخدم</label>
                    <input id="text" type="text" class="form-control"  name="username"  value="{{ old('username') }}" tabindex="1" required >
                    <div class="invalid-feedback " style="text-align: center;">
                     ادخل اسم المستخدم                          
                    </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('username') }}</strong>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label float-right" >كلمة السر</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback " style="text-align: center;">
                     ادخل كلمة السر                                                         
                    </div>
                      <strong class="float-right" style="color: red;">{{ $errors->first('password') }}</strong>
                  </div>


                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      تسجيل الدخول 
                    </button>
                  </div>
                </form>
            <div class="simple-footer">
                &copy; IT DEPARTMENT  @php  echo date("Y"); @endphp
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('js/jquery.min.js')}}"></script>
  <script src="{{ asset('js/popper.js')}}"></script>
  <script src="{{ asset('js/tooltip.js')}}"></script>
  <script src="{{ asset('js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('js/moment.min.js')}}"></script>
  <script src="{{ asset('js/stisla.js')}}"></script>
  
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="{{ asset('/js/custom.js')}}"></script>
</body>
</html>