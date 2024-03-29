	@extends('layouts.admin')
@section('title')
   {{$store['store_name']}} Services
@endsection
@section('css')
    <!-- plugin css -->
    <link href="{{URL::to('storage/app/public/Adminassets/libs/datatables/dataTables.bootstrap4.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{URL::to('storage/app/public/Adminassets/libs/datatables/responsive.bootstrap4.min.css')}}"
          rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right">
                <a href="{{URL::to('master-admin/store-profile/'.$store['id'].'/advantages')}}" class="btn btn-dark text-white">Store Advantages</a>
                <a href="{{URL::to('master-admin/store-profile/'.$store['id'].'/public-transportation')}}" class="btn btn-danger text-white">Store Public Transportation</a>
                <a href="{{URL::to('master-admin/store-profile/'.$store['id'].'/parking')}}" class="btn btn-danger text-white">Store Parking</a>
                <a href="{{URL::to('master-admin/store-profile/'.$store['id'].'/service/create')}}" class="btn btn-primary text-white">+ Create Services</a>
            </nav>
            <h4 class="mb-1 mt-1">{{$store['store_name']}} Services</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Service Name</th>
                            <th>Katergoriename </th>
                            <th>Subcategory Name</th>
                            {{-- <th>Price</th>
                            <th>Duration of service</th> --}}
                            <th>Bild</th>
                            <th>Status</th>
                            <th>Aktion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->service_name}}</td>
                                <td>{{@$row->CategoryData->name == '' ? '-' : @$row->CategoryData->name}}</td>
                                <td>{{@$row->SubCategoryData->name == '' ? '-' : @$row->SubCategoryData->name}}</td>
                                {{-- <td>{{$row->price == '' ? '-' : $row->price}}</td>
                                <td>{{$row->duration_of_service}} Min.</td> --}}

                                <td>
                                    @if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != '')
                                        <img src="{{URL::to('storage/app/public/service/'.$row->image)}}"
                                             class="rounded avatar-sm"
                                             alt="user">
                                    @else
                                        <img src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                             class="rounded avatar-sm"
                                             alt="user">
                                    @endif
                                </td>
                                <td>
                                    <label
                                        class="badge badge-soft-{{$row->status == 'active' ? 'success' : 'danger'}}">{{$row->status}}</label>

                                </td>
                                <td>
                                    <a class="" href="{{URL::to('master-admin/store-profile/'.$store['id'].'/service/'.$row->id.'/edit')}}"> <i
                                            class="uil-pen"></i></a>
                                    <a class="" href="{{URL::to('master-admin/store-profile/'.$store['id'].'/service/'.$row->id.'/destroy')}}"><i
                                            class="uil-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
@endsection
@section('plugin')
    <script src="{{URL::to('storage/app/public/Adminassets/libs/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Adminassets/libs/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Adminassets/libs/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Adminassets/libs/datatables/responsive.bootstrap4.min.js')}}"></script>
@endsection
@section('js')
    <!-- Datatables init -->
    <script src="{{URL::to('storage/app/public/Adminassets/js/pages/datatables.init.js')}}"></script>
@endsection

