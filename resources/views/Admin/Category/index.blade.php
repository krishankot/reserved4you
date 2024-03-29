@extends('layouts.admin')
@section('title')
    Gastronomy Category
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
                <a href="{{URL::to('master-admin/category/create')}}" class="btn btn-primary text-white">+ Kosmetik Kategorie erstellen </a>
            </nav>
            <h4 class="mb-1 mt-1">Gastronomy  Kategorie</h4>
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
                            <th>Hauptkategorie</th>
                            <th>Katergoriename</th>
                            <th> Bild </th>
                            <th>Status</th>
                            <th>Aktion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{@$row->CategoryData->name}}</td>
                                <td>{{$row->name}}</td>
                                <td>
                                    @if(file_exists(storage_path('app/public/category/'.$row->image)) && $row->image != '')
                                        <img src="{{URL::to('storage/app/public/category/'.$row->image)}}"
                                             class="rounded avatar-sm"
                                             alt="user">
                                    @else
                                        <img src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                             class="rounded avatar-sm"
                                             alt="user">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{URL::to('master-admin/category/'.$row->id.'/status')}}"> <label
                                            class="badge badge-soft-{{$row->status == 'active' ? 'success' : 'danger'}}">{{$row->status}}</label>
                                    </a>
                                </td>
                                <td>
                                    <a class="" href="{{URL::to('master-admin/category/'.$row->id.'/edit')}}"> <i
                                            class="uil-pen"></i></a>
                                    <a class="" href="{{URL::to('master-admin/category/'.$row->id.'/destroy')}}"><i
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
    <!-- <script src="{{URL::to('storage/app/public/Adminassets/js/pages/datatables.init.js')}}"></script> -->
    <script>
        var table = $('#basic-datatable').DataTable({order:[[0,"desc"]]});
    </script>
@endsection

