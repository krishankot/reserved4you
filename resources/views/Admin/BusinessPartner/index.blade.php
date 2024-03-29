@extends('layouts.admin')
@section('title')
    Partner Request
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
            <h4 class="mb-1 mt-1">Dienstleisteranfragen</h4>
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
                            <th>Store Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Telefonnummer</th>
                            <th>Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->store_name}}</td>
                                <td>{{$row->first_name}} {{$row->last_name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->phone_number}}</td>
                                <td>{{$row->location}}</td>
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

