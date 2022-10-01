{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Change Password</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                    <form method="post" class="form-valide" action="{{ Route('change.password') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Current Password</label>
                                                    <input type="password" class="form-control"  name="current_password" placeholder="Current Password">
                                                    @error('current_password')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control"  name="password" placeholder="Password">
                                                    @error('password')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                                    @error('password_confirmation')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Reset Password</button>
                                        </form> 
                                    </div>
                                </div>
                        </div>
					</div>
                </div>
            </div>
@endsection