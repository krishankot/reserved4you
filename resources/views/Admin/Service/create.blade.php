@extends('layouts.admin')
@section('title')
    Create Service
@endsection
@section('css')
@endsection
@section('content')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{URL::to('master-admin/store-profile/'.$store['id'])}}">Service</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Service</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Create Service</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-1">Create Service</h4>

                    <hr/>

                    {{Form::open(array('url'=>'master-admin/store-profile/'.$store['id'].'/service','method'=>'post','name'=>'create-service','files'=>'true','class'=>'needs-validation','novalidate'))}}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Name des Betriebs</label>
                                {{Form::text('store_id',$store['store_name'],array('class'=>'form-control','id'=>'validationCustom01','required','readonly'))}}
                                @error('store_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01"> Kategorien</label>
                                {{Form::select('category_id',$category,'',array('class'=>'form-control category','id'=>'validationCustom01','required'))}}
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Sub Category</label>
                                {{Form::select('subcategory_id',[''=>'Select Subcategory'],'',array('class'=>'form-control subcategory','id'=>'validationCustom01','required'))}}
                                @error('subcategory_id')
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
                                <label for="validationCustom01">Service </label>
                                {{Form::text('service_name','',array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Service','required'))}}
                                @error('service_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Description</label>
                                {{Form::textarea('description','',array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Description','required','rows'=>2))}}
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Is Popular</label>
                                {{Form::select('is_popular',array(''=>'Select Is Popular','yes'=>'Yes','no'=>'Nein '),'',array('class'=>'form-control','id'=>'validationCustom03','required'))}}
                                @error('is_popular')
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
                                <label for="validationCustom01">Discount (€ | %)</label>
                                {{Form::number('discount','',array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Discount','min'=>0))}}
                                @error('discount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="validationCustom01">Discount Type</label>
                                {{Form::select('discount_type',array(''=>'Select Discount Type','percentage'=>"Percentage",'amount'=>'Amount'),'',array('class'=>'form-control','id'=>'validationCustom01'))}}
                                @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Bild</label>
                            <div class="custom-file">
                                {{Form::file('image',array('class'=>$errors->has('image') ?'custom-file-input is-invalid' : 'custom-file-input','id'=>'customFile','accept'=>"image/*",'required'))}}
                                <label class="custom-file-label" for="customFile">Datei auswählen </label>

                            </div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>
                       

                    </div>
                   
                    <h6>Service Variant</h6>
                    <hr/>
                    <div class="variants">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="validationCustom01">Description</label>
                                    {{Form::text('description_variant[]','',array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Description','required'))}}
                                    @error('description_variant')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="validationCustom01">Preis €</label>
                                    {{Form::number('price_variant[]','',array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Price','required','min'=>0))}}
                                    @error('price_variant')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="validationCustom01">Duration Of Service (min)</label>
                                    {{Form::text('duration_of_service_variant[]','',array('class'=>'form-control','id'=>'validationCustom03','placeholder'=>'Duration Of Service','required'))}}
                                    @error('duration_of_service_variant')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group mb-3 mt-4">
                                <button type="button" class="btn btn-primary addVariant">+</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{Form::submit(' Speichern',array('class'=>'btn btn-primary'))}}
                    <a href="{{URL::to('master-admin/store-profile/'.$store['id'])}}" class="btn btn-danger">Abbrechen</a>
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
        $('input[name="image"]').change(function (e) {

            var fileName = e.target.files[0].name;
            $('.custom-file-label').text(fileName);

        });

        $(document).on('change','.category',function (){
            var value = $(this).val();

            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: "{{URL::to('master-admin/service/category')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: value,
                },
                success: function(response) {
                    var status = response.status;

                   var html = '<option value="">Select Subcategory</option>';

                    $(response.data).each(function(index, value) {

                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                    });

                    if(response.data.length > 0){
                        $('.subcategory').prop('required',true);
                    }

                    $('.subcategory').html(html);

                },
                error: function(e) {

                }
            });

        });


    </script>
    <script>
        $(document).on('click','.addVariant',function(){
            var html = '<div class="row">'+
                            '<div class="col-lg-3">'+
                                '<div class="form-group mb-3">'+
                                    '<label for="validationCustom01">Description</label>'+
                                    '<input type="text" name="description_variant[]" class="form-control" id="validationCustom03" placeholder="Description" required>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-lg-3">'+
                                '<div class="form-group mb-3">'+
                                    '<label for="validationCustom01">Price (€)</label>'+
                                    '<input type="number" name="price_variant[]" class="form-control" id="validationCustom03" placeholder="Price" required min="0">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-lg-3">'+
                                '<div class="form-group mb-3">'+
                                    '<label for="validationCustom01">Duration Of Service (min)</label>'+
                                    '<input type="text" name="duration_of_service_variant[]" class="form-control" id="validationCustom03" placeholder="Duration Of Service" required>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-lg-1">'+
                                '<div class="form-group mb-3 mt-4">'+
                                '<button type="button"  class="btn btn-danger removeVariant">-</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>';

                $('.variants').append(html);
        });
        $(document).on('click','.removeVariant',function(){
                $(this).closest('.row').remove();
        });
    </script>

@endsection

