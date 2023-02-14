@extends('layouts.admin')
@section('title')
    Appointment Lists
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
            <h4 class="mb-1 mt-1">Terminübersicht</h4>
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
                            <th>Buchungsnummer</th>
                            <th>Name des Betriebs</th>
                            <th>Service Name</th>
                            <th>Kundenname</th>
                            <th>Datum und Zeit</th>
                            <th>Preis</th>
                            <th>Status</th>
                            <th>Termintyp</th>
{{--                        <th>Aktion</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>#{{$row->order_id}}</td>
                                <td>{{@$row->storeDetails->store_name == '' ? '-' : @$row->storeDetails->store_name}}</td>
                                <td>{{@$row->serviceDetails->service_name == '' ? '-' : @$row->serviceDetails->service_name}}</td>
                                <td>{{@$row->appointmentDetails->first_name != '' ? @$row->appointmentDetails->first_name.' '. @$row->appointmentDetails->last_name : (@$row->appointmentDetails->first_name == '' ? '-' : @$row->appointmentDetails->first_name.' '.@$row->last_name )}}</td>
                                <td>{{\Carbon\Carbon::parse($row->appo_date)->format('M d,Y')}} | {{\Carbon\Carbon::parse($row->appo_time)->format('H:i')}}</td>
                                <td>£ {{$row->price}}</td>
                                <td>{{$row->status}}</td>
                                <td>{{$row->appointmentDetails->appointment_type == '' ? '-' : $row->appointmentDetails->appointment_type}}</td>
{{--                                <td>--}}
{{--                                    <a class="" href="{{URL::to('master-admin/appointment-list/'.$row->id)}}"> <i--}}
{{--                                            class="uil-eye"></i></a>--}}
{{--                                    <a class="" href="{{URL::to('master-admin/appointment-list/'.$row->id.'/edit')}}"> <i--}}
{{--                                            class="uil-pen"></i></a>--}}

{{--                                </td>--}}
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
