@extends('layouts.admin')
@section('title')
    Edit Admin
@endsection
@section('css')
@endsection
@section('content')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin/admin')}}"> Administrator</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit  Administrator</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Edit  Administrator</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-1">Edit  Administrator Form</h4>

                    <hr/>

                    {{Form::open(array('url'=>'master-admin/admin/'.$data['id'],'method'=>'PUT','name'=>'edit-user','files'=>'true','class'=>'needs-validation','novalidate'))}}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01"> Vorname </label>
                                {{Form::text('first_name',$data['first_name'],array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>' Vorname','required'))}}
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Nachname</label>
                                {{Form::text('last_name',$data['last_name'],array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>'Nachname','required'))}}
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Email</label>
                                {{Form::text('email',$data['email'],array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Email','required'))}}
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Telefonnummer (optional)</label>
                                {{Form::text('phone_number',$data['phone_number'],array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>'Telefonnummer '))}}
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group mb-3">
                                <label for="validationCustom01">Passwort (min 6 characters)</label>
                                {{Form::password('password',array('class'=>'form-control','id'=>'validationCustom04','placeholder'=>'passwort'))}}
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Profilbild (optional)</label>
                            <div class="custom-file">
                                {{Form::file('profile_pic',array('class'=>$errors->has('profile_pic') ?'custom-file-input is-invalid' : 'custom-file-input','id'=>'customFile','accept'=>"image/*"))}}
                                <label class="custom-file-label" for="customFile">Datei auswählen </label>

                            </div>
                            @error('profile_pic')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            @if(!empty($data['profile_pic']))
                                <img src="{{URL::to('storage/app/public/user/'.$data['profile_pic'])}}"
                                     class="rounded avatar-sm mt-2"
                                     alt="user">
                            @endif

                        </div>


                    </div>



                    {{Form::submit('Update',array('class'=>'btn btn-primary'))}}
                    <a href="{{URL::to('master-admin/admin')}}" class="btn btn-danger" >Abbrechen</a>
                    {{Form::close()}}

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
@endsection

@section('plugin')
    <!-- Plugin js-->
    <script src="{{URL::to('storage/app/public/Adminassets/libs/parsleyjs/parsley.min.js')}}"></script>
@endsection
@section('js')
    <!-- Validation init js-->
    <script src="{{URL::to('storage/app/public/Adminassets/js/pages/form-validation.init.js')}}"></script>

    <script>
        $('input[type="file"]'). change(function(e){

            var fileName = e. target. files[0]. name;
            $('.custom-file-label').text(fileName);

        });

    </script>

@endsection

