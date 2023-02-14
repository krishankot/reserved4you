@extends('layouts.serviceProvider')
@section('service_title')
    Employee List
@endsection
@section('service_css')
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
    ?>
@endsection
@section('service_content')
    <div class="main-content">
        <h2 class="page-title"><span>{{count($data)}}  </span> Mitarbeiter </h2>
        <div class="appointment-header customers-header mb-3">
            <div class="appointment-search">
                <input type="text" placeholder="Suchen nach …" id="myInput">
                <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/search.svg')}}"
                                 alt=""></a>
            </div>
            <div class="sortby sortby2">
                <select class="select store_category">
                    <option value=""
                            data-value="">Alle Stores
                    </option>
                    @foreach($getStore as $row)
                        @if(session('store_id') == $row->id)

                            <option value="{{$row->id}}"
                                    data-value="{{$row->store_address}}" selected>{{$row->store_name}}</option>
                        @else
                            <option value="{{$row->id}}"
                                    data-value="{{$row->store_address}}">{{$row->store_name}}</option>
                        @endif
                    @endforeach
                </select>
                <p class="select-p-text">{{session('address')}}</p>
            </div>
            <a href="{{URL::to('dienstleister/mitarbeiter-hinzufuegen')}}" class="employeebtn appointment-btn btn-yellow">Neuen Mitarbeiter hinzufügen</a>
            <a href="#" class="employeebtn employee-btn btn-main">Schichtplan</a>
        </div>
        <div class="row employee-rows">
            @foreach($data as $row)
                <div class="col-lg-4 col-mb-6">
                    <div class="employee-item-box">
                        <div class="employee-item">
                            <div class="employee-item-profile">
								@php
									$empnameArr = explode(" ", $row->emp_name);
									$empname = "";
									if(count($empnameArr) > 1){
										$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
									}else{
										$empname = strtoupper(substr( $row->emp_name, 0, 2));
									}
								@endphp
                                @if(file_exists(storage_path('app/public/store/employee/'.$row->image)) && $row->image != '')
                                    <img src="{{URL::to('storage/app/public/store/employee/'.$row->image)}}" alt="" >
                                @else
                                    <img src="https://via.placeholder.com/150x150/00000/FABA5F?text={{$empname}}" alt="employee">
                                @endif
                            </div>
                            <div class="employee-item-info">
                                <h5>{{$row->emp_name}}</h5>
                                <ul>
                                    <li>
                                        <span>Mitarbeiter ID:</span>
                                        <p>{{$row->employee_id == '' ? '-' : $row->employee_id}}</p>
                                    </li>
                                    <li>
                                        <span>Heutige Arbeitszeit: </span>
                                        @if(@$row->time->is_off == 'off')
                                            <p>{{\Carbon\Carbon::parse(@$row->time->start_time)->format('H:i')}} - {{\Carbon\Carbon::parse(@$row->time->end_time)->format('H:i')}}</p>
                                        @else
                                            <p class="text-red">nicht Verfügbar <i class="far fa-question-circle"></i></p>
                                        @endif

                                    </li>
                                    <li>
                                        <span>Kategorie:</span>
                                        <p>{{implode(',',$row->category)}}</p>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{URL::to('dienstleister/mitarbeiter-details/'.encrypt($row->id))}}"
                               class="btn btn-black-yellow more-detail-btn">Details anzeigen</a>
                        </div>
                        <a class="employee-contact-link" href="tel:{{$row->phone_number}}"><span><img
                                    src="{{URL::to('storage/app/public/Serviceassets/images/icon/phone.svg')}}" alt=""></span>{{$row->phone_number == '' ? '-' :$row->phone_number}}
                        </a>
                        <a class="employee-contact-link" href="mailto:{{$row->email}}"><span><img
                                    src="{{URL::to('storage/app/public/Serviceassets/images/icon/mail-2.svg')}}" alt=""></span>{{$row->email == '' ? '-' : $row->email}}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('service_js')
    <script>
        $(document).ready(function () {
            $(document).on("keyup", '#myInput', function () {
                var value = $(this).val().toLowerCase();
                $(".employee-rows div.col-lg-4").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection

