@extends('layouts.admin')
@section('title')
    Contract Lists
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
            <h4 class="mb-1 mt-1">Contract Lists</h4>
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
                            <th>Name des Betriebs</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Telefonnummer</th>
                            <th>District</th>
                            <th>Postleitzahl</th>
                            <th>Actual_plan</th>
                            <th>Employee Name</th>
                            <th>Employee ID</th>
                            <th>Aktion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($storedetails as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->storename}}</td>
                                <td>{{$row->firstname}} {{$row->Lastname}}</td>
                                <td>{{$row->Email}}</td>
                                <td>{{$row->Phone}}</td>
                                <td>{{$row->District}}</td>
                                <td>{{$row->Zipcode}}</td>
                                <td>{{$row->Actual_plan}}</td>
                                <td>{{@$row->salesStaff->firstname}} {{@$row->salesStaff->lastname}}</td>
                                <td>{{@$row->salesStaff->Staff_id_no}}</td>
                                <td>
                                    <a class="" href="{{URL::to('master-admin/contract-list/'.$row->id)}}"> <i
                                            class="uil-eye"></i></a>
{{--                                    <a class=""--}}
{{--                                       href="{{URL::to('master-admin/contract-list/'.$row->id.'/delete    ')}}">--}}
{{--                                        <i--}}
{{--                                            class="uil-pen"></i></a>--}}

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

