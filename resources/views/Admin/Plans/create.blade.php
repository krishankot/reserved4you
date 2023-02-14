@extends('layouts.admin')
@section('title')
    Create Plan
@endsection
@section('css')
@endsection
@section('content')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin/plans')}}">Pakete</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Paket erstellen </li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Paket erstellen </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-1">Paket erstellen </h4>

                    <hr/>

                    {{Form::open(array('url'=>'master-admin/plans','method'=>'post','name'=>'create-plan','files'=>'true','class'=>'needs-validation','novalidate'))}}
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Name des Pakets (Laufzeit)</label>
                                {{Form::text('plan_name','',array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>'Name des Pakets','required'))}}

                            </div>
                            @error('plan_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Beschreibung des Pakets</label>
                                {{Form::textarea('plan_description','',array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>'Beschreibung des Pakets','required','rows'=>2))}}

                            </div>
                            @error('plan_description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Hauptpaket </label>
                                {{Form::text('plan_actual_name','',array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>'Hauptpaket','required'))}}

                            </div>
                            @error('plan_actual_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Preis €</label>
                                {{Form::text('price','',array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>' Pakete Preis €','required'))}}

                            </div>
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Einstellungsgebühren €</label>
                                {{Form::text('recruitment_fee','',array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>'Einstellungsgebühren €','required'))}}

                            </div>
                            @error('plan_actual_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="validationCustom01"> Mehrwertsteuer </label>
                                {{Form::text('tax_fee','',array('class'=>'form-control','id'=>'validationCustom01','placeholder'=>' Mehrwertsteuer','required'))}}

                            </div>
                            @error('tax_fee')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group mb-3">
                                <label for="validationCustom01"> Managementtools </label>
                                {{Form::select('is_management_tool',array('no'=>' Nein ','yes'=>'Yes'),'',array('class'=>'form-control','id'=>'validationCustom01','required'))}}
                            </div>
                            @error('is_management_tool')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Profildesign </label>
                                {{Form::select('is_profile_design',array('no'=>' Nein ','yes'=>'Yes'),'',array('class'=>'form-control','id'=>'validationCustom01','required'))}}
                            </div>
                            @error('is_profile_design')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group mb-3">
                                <label for="validationCustom01"> Buchungssystem </label>
                                {{Form::select('is_booking_system',array('no'=>' Nein ','yes'=>'Yes'),'',array('class'=>'form-control','id'=>'validationCustom01','required'))}}
                            </div>
                            @error('is_booking_system')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Newsletter </label>
                                {{Form::select('is_ads_newsletter',array('no'=>' Nein ','yes'=>'Yes'),'',array('class'=>'form-control','id'=>'validationCustom01','required'))}}
                            </div>
                            @error('is_ads_newsletter')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Social Media </label>
                                {{Form::select('is_social_media_platforms',array('no'=>' Nein ','yes'=>'Yes'),'',array('class'=>'form-control','id'=>'validationCustom01','required'))}}
                            </div>
                            @error('is_social_media_platforms')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    {{Form::submit('Speichern',array('class'=>'btn btn-primary'))}}
                    <a href="{{URL::to('master-admin/plans')}}" class="btn btn-danger" >Abbrechen</a>
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

