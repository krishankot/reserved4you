@extends('layouts.admin')
@section('title')
    Edit Store Advantages
@endsection
@section('css')
@endsection
@section('content')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin/store-profile/'.$store_id.'/advantages')}}">Store Advantages</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Store Advantages</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Edit Store Advantages</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-1">Edit Store Advantages</h4>

                    <hr/>

                    {{Form::open(array('url'=>'master-admin/store-profile/'.$store_id.'/advantages/'.$data['id'],'method'=>'PUT','name'=>'edit-advantages','files'=>'true','class'=>'needs-validation','novalidate'))}}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Title</label>
                                {{Form::text('title',$data['title'],array('class'=>'form-control','id'=>'validationCustom01','required'))}}
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Description</label>
                                {{Form::textarea('description',$data['description'],array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Description','required','rows'=>2))}}
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label> Bild </label>
                            <div class="custom-file">
                                {{Form::file('image',array('class'=>$errors->has('image') ?'custom-file-input is-invalid' : 'custom-file-input','id'=>'customFile','accept'=>"image/*"))}}
                                <label class="custom-file-label" for="customFile">Datei auswählen</label>

                            </div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            @if(!empty($data['image']))
                                <img src="{{URL::to('storage/app/public/store/advantage/'.$data['image'])}}"
                                     class="rounded avatar-sm mt-2"
                                     alt="user">
                            @endif

                        </div>


                    </div>


                    {{Form::submit('Update',array('class'=>'btn btn-primary'))}}
                    <a href="{{URL::to('master-admin/store-profile/'.$store_id.'/advantages')}}" class="btn btn-danger">Abbrechen</a>
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
