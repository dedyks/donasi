@extends('dashboard.layouts.auth')

@section('title')
  <title>Admin Dashboard GSM - Forgot password</title>
@endsection

@section('content')
  <div class="wrapper-page">
    <div class="card-box">
      <div class="panel-heading">
        <h3 class="text-center">Halaman Permintaan<strong class="text-custom"> <br>Reset Password</strong></h3>
      </div>
      <div class="panel-body">
        <form class="form-horizontal m-t-20" enctype="multipart/form-data" method="post" name="forgotPasswordForm">
          <div class="form-group">
            <div class="col-xs-12">
              <input class="form-control" type="text" required id="email" placeholder="Email" value="">
            </div>
          </div>
          <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
              <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="button" id="forgotPassword">Continue</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 text-center">
        <p>Kembali ke <a href="{{ url('login') }}" class="text-primary m-l-5"><b>Halaman Login<b></a></p>
      </div>
    </div>
  </div>
@endsection
