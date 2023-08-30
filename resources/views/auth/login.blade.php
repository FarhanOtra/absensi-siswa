{{-- Extends layout --}}
@extends('layout.fullwidth')

{{-- Content --}}

@section('content')
	<div class="col-md-6">
      <div class="authincation-content">
          <div class="row no-gutters">
              <div class="col-xl-12">
                  <div class="auth-form">
                    <div class="text-center brand-logo">
                        <div class="row">
                            <div class="col-12">
                                <img class="logo-abbr" width="80%"  src="{{ asset('images/logo-and-text.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                        <br>
                        <br>
                      <!-- <h4 class="text-center mb-4">Login</h4> -->
                      <form method="post" action="{{ route('login') }}">
                      @csrf
                      @if ($message = Session::get('errors'))
                                <div class="alert alert-danger" role="alert">
                                    Email atau NIP tidak cocok dengan Password!
                                </div>
                              @endif
                          <div class="form-group">
                              <label class="mb-1"><strong>Email atau NIP</strong></label>
                              <input type="text" class="form-control" value="admin@gmail.com" name="username">
                          </div>
                          <div class="form-group">
                              <label class="mb-1"><strong>Password</strong></label>
                              <input type="password" class="form-control" value="12345678" name="password">
                          </div>
                          <br>
                          <div class="text-center">
                              <button type="submit" class="btn btn-primary btn-block">Login</button>
                          </div>
                      </form>
                  </div>
                </div>
            </div>
        </div>
        <br>
            <div class="copyright text-center">
                <p>Copyright © Developed by Farhan Naufal Otra 2022</p>
            </div>
  </div>
@endsection
