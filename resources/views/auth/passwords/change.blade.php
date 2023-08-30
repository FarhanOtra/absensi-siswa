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
                                <h4 class="card-title">Tukar Password</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                    <form method="post" class="form-valide" action="{{ Route('change.password') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Password Lama</label>
                                                    <input type="password" class="form-control"  name="current_password" placeholder="Password Lama">
                                                    @error('current_password')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Password Baru</label>
                                                    <input type="password" class="form-control"  name="password" placeholder="Password Baru">
                                                    @error('password')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Konfirmasi Password</label>
                                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password Baru">
                                                    @error('password_confirmation')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form> 
                                    </div>
                                </div>
                        </div>
					</div>
                </div>
            </div>
@endsection