{{-- Extends layout --}}
@extends('layout.fullwidth')

{{-- Content --}}
@section('content')
	<div class="col-md-6">
      <div class="authincation-content">
          <div class="row no-gutters">
              <div class="col-xl-12">
                  <div class="auth-form">
                      <h4 class="text-center mb-4">Sign in your account</h4>
                      <form method="post" action="{{ route('login') }}">
                      @csrf
                          <div class="form-group">
                              <label class="mb-1"><strong>Username</strong></label>
                              <input type="text" class="form-control" value="admin" name="username">
                              @error('username')
                                <span class="text-danger"><small>{{$message}}</small></span>
                              @enderror
                          </div>
                          <div class="form-group">
                              <label class="mb-1"><strong>Password</strong></label>
                              <input type="password" class="form-control" value="12345678" name="password">
                              @error('password')
                                <span class="text-danger"><small>{{$message}}</small></span>
                              @enderror
                          </div>
                          <br>
                          <div class="text-center">
                              <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
