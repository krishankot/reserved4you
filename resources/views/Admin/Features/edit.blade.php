@extends('layouts.admin')
@section('title')
    Edit Features
@endsection
@section('css')
@endsection
@section('content')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin/features/')}}">Features</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Features</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Edit Features</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-1">Edit Features</h4>

                    <hr/>

                    {{Form::open(array('url'=>'master-admin/features/'.$id,'method'=>'put','name'=>'edit-parking','files'=>'true','class'=>'needs-validation','novalidate'))}}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Name</label>
                                {{Form::text('name',$data['name'],array('class'=>'form-control','id'=>'validationCustom01','required'))}}
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label> Bilds </label>
                            <div class="custom-file">
                                {{Form::file('image',array('class'=>$errors->has('image') ?'custom-file-input is-invalid' : 'custom-file-input','id'=>'customFile','accept'=>"image/*"))}}
                                <label class="custom-file-label" for="customFile">Datei auswählen </label>

                            </div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            @if(!empty($data['image']))
                                <img src="{{URL::to('storage/app/public/features/'.$data['image'])}}"
                                     class="rounded avatar-sm mt-2"
                                     alt="user">
                            @endif

                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Status</label>
                                {{Form::select('status',array(''=>'Select Status','active'=>' Aktiv','inactive'=>'Inactive'),$data['status'],array('class'=>'form-control','id'=>'validationCustom01','required'))}}

                            </div>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>


                    {{Form::submit('Speichern',array('class'=>'btn btn-primary'))}}
                    <a href="{{URL::to('master-admin/features/')}}" class="btn btn-danger">Abbrechen</a>
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
