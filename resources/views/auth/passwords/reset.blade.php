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
                                <h4 class="card-title">Reset Password</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                    <form method="post" class="form-valide" action="{{ Route('reset.password') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <input type="hidden" name="id" value="{{$user_id}}">
                                                <div class="form-group col-md-12">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control"  name="password" placeholder="Password" value="{{old('password')}}">
                                                    @error('password')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" value="{{old('password-confirmation')}}">
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