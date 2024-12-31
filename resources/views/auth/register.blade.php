
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Registrasi</title>



    <!-- Bootstrap core CSS -->
<link href="{{asset ('style/assets/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  </head>
  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



  <body class="">
  <section >
  <div class="mask d-flex align-items-center h-50 gradient-custom-3">
    <div class="container h-50">
      <div class="row d-flex justify-content-center align-items-center h-50">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>

              <form method="POST" action="{{ url('/daftar') }}" autocomplete="off">
                @csrf

                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example1cg">Your Name</label>
                  <input type="text" name="name" id="form3Example1cg" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="" autocomplete="off">username</label>
                  <input type="text" id="" name="username" class="form-control form-control-lg" autocomplete="off"/>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="" autocomplete="off">Password</label>
                  <input type="password" id="" name="password" class="form-control form-control-lg" autocomplete="off"/>
                </div>
                <input type="hidden" class="form-control" id="role" placeholder="role" name="role"
                value="staff">




                <div class="d-flex justify-content-center">
                  <button type="submit"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="/login"
                    class="fw-bold text-body"><u>Login here</u></a></p>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    
  </body>
</html>
