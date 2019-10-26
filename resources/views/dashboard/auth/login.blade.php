@extends('dashboard.layouts.auth')

@section('title')
  <title>Admin Dashboard GSM - Login</title>
@endsection

@section('content')
  <div class="wrapper-page">
    <div class="card-box">
      <div class="panel-heading">
        <h3 class="text-center">Login ke<strong class="text-custom"> Admin Dashboard<br>E-Learning GSM</strong></h3>
      </div>
      <div class="panel-body">
        <form class="form-horizontal m-t-20" enctype="multipart/form-data" method="post" name="loginAdminForm">
          <div class="form-group">
            <div class="col-xs-12">
              <input class="form-control" type="text" required id="email" placeholder="Email" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input class="form-control" type="password" required id="password" placeholder="Password" value="">
            </div>
          </div>
          <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
              <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="button" id="loginAdmin">Login</button>
            </div>
          </div>
          <div class="form-group m-t-30 m-b-0">
            <div class="col-sm-12">
              <a href="{{ url('/resetpassword') }}" class="text-dark"><i class="fa fa-lock m-r-5"></i>Lupa password?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
