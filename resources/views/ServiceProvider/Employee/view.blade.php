@extends('layouts.serviceProvider')
@section('service_title')
    Employee Details
@endsection
@section('service_css')
<style>
.account-info-box ul::after{background:transparent !important;}
.cd-main-action-info a.delete-icon{margin-left:15px;}
div#example_wrapper{overflow:hidden;}
.page-link{background:transparent !important;}
</style>
@endsection
@section('service_content')
    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Mitarbeiter</h2>
            <p><a href="{{URL::to('dienstleister/mitarbeiter')}}">Mitarbeiter  </a><span>/ Mitarbeiterinformationen</span></p>
        </div>
        <div class="cd-main-wrap">
            <div class="cd-main-profile">
			@php
				$empnameArr = explode(" ", $employee['emp_name']);
				$empname = "";
				if(count($empnameArr) > 1){
					$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
				}else{
					$empname = strtoupper(substr( $employee['emp_name'], 0, 2));
				}
			@endphp
                @if(file_exists(storage_path('app/public/store/employee/'.$employee['image'])) && $employee['image'] != '')
                    <img src="{{URL::to('storage/app/public/store/employee/'.$employee['image'])}}"
                         alt=""
                    >
                @else
                     <img src="https://via.placeholder.com/150x150/00000/FABA5F?text={{$empname}}" alt="employee">
                @endif
            </div>
            <div class="cd-main-profile-info">
                <h4>{{$employee['emp_name']}}</h4>
                <h6>{{$employee['address']}} {{!empty($employee['state'])?', '. $employee['state']:''}} {{!empty($employee['zipcode'])?', '. $employee['zipcode']:''}}</h6>
                <ul>
                    <li>
                        <!-- <p><a href="#">{{$employee['worktype'] == '' ? '-' :$employee['worktype'] }}</a></p> -->
                        @if($employee['worktype'] == '')
                            <p><a href="#">-</a></p>
                        @elseif($employee['worktype'] == 'Full-Time')
                            <p><a href="#">Vollzeit</a></p>
                        @else
                            <p><a href="#">Teilzeit</a></p>
                        @endif
                    </li>
                    <li>
                        <p><a href="#">{{$employee['hours_per_week']}} Std. / Woche</a></p>
                    </li>
                </ul>
            </div>
            <div class="cd-main-action-info">
                <div class="btn-add-edit">
                <a class="edit-btn" href="{{URL::to('dienstleister/mitarbeiter-bearbeiten/'.encrypt($employee['id']))}}">
                    <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/edit-employe.svg')}}">
                </a>
                <a class="delete-icon" data-id="{{$employee['id']}}"  href="#"><img
                        src="{{URL::to('storage/app/public/Serviceassets/images/icon/delete-2.svg')}}" alt=""></a>

              </div>
                <ul class="employee-extra-info">
                    <li>
                        <p>Mitarbeiter ID: <span> {{$employee['employee_id'] == '' ? '-' :$employee['employee_id']}}</span>
                        </p>
                    </li>
                    <!-- <li>
                        <a href="#" class="btn btn-black-yellow">Employee CV</a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-white-yellow">Leave Form & Report</a>
                    </li> -->
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="employee-box-bg">
                    <div class="personal-info-wrap">
                        <h3>Persönliche Infos</h3>
                        <h4>Kategorien: <span> {{implode(',',$category)}}</span></h4>
                    </div>
                    <ul class="personal-info">
                        <li>
                            <span>Telefonnummer </span>
                            <p>{{$employee['phone_number'] == '' ? '-' : $employee['phone_number']}}</p>
                        </li>
                        <li>
                            <span>E-Mail Adresse</span>
                            <p class="text-break">{{$employee['email'] == '' ? '-' : $employee['email']}}</p>
                        </li>
                        <li>
                            <span>Sprachen</span>
                            <p>{{$languages?implode(',',$languages):'-'}}</p>
                        </li>
                        <li>
                            <span>Geburtstag </span>
							@if(!empty($employee['dob']))
								<p>{{\Carbon\Carbon::parse($employee['dob'])->translatedFormat('d M Y')}}
									({{\Carbon\Carbon::parse($employee['dob'])->age}} Jahre)</p>
							@else
								<p>-</p>
							@endif
                        </li>
                        <li>
                            <span>Beginn der Tätigkeit </span>
							@if(!empty($employee['dob']))
                            <p>{{\Carbon\Carbon::parse($employee['joinning_date'])->translatedFormat('d M Y')}}
                                ({{\Carbon\Carbon::parse($employee['joinning_date'])->age}} Jahre)</p>
							@else
								<p>-</p>
							@endif
                        </li>
                        <li>
                            <span>Gehalt </span>
                            <p>{{number_format($employee['payout'], 2, ',', '.') }}€</p>
                        </li>
                    </ul>
                    <div class="account-info-box">
                        <h3>Bankdaten </h3>
                        <ul>
                            <li class="w-100">
                                <span>Name der Bank:</span>
                                <p>{{$employee['bank_name'] != '' ? $employee['bank_name'] : '-' }}</p>
                            </li>
                           <li class="w-100">
                                <span>IBAN:</span>
                                <p>{{$employee['iban'] != '' ? $employee['iban'] : '-' }}</p>
                            </li>
                           <li class="w-100">
                                <span>Kontoinhaber :</span>
                                <p>{{$employee['account_holder'] != '' ? $employee['account_holder'] : '-' }}</p>
                            </li>
                           <li class="w-100">
                                <span>SWIFT:</span>
                                <p>{{$employee['swift_code'] != '' ? $employee['swift_code'] : '-' }}</p>
                            </li>
                            <li class="w-100">
                                <span>Kontonummer :</span>
                                <p>{{$employee['account_number'] != '' ? $employee['account_number'] : '-' }}</p>
                            </li>
                           <li class="w-100">
                                <span>Verwendungszweck:</span>
                                <p>{{$employee['branch'] != '' ? $employee['branch'] : '-' }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- <ul class="upload-document">
                    <li class="done">
                    <span class="pdf-icon">
                        <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/pdf.svg')}}" alt="">
                    </span>
                        <div class="pdf-info">
                            <h6>Contract Document</h6>
                            <i>29KB &nbsp;&nbsp; PDF file</i>
                        </div>
                        <div class="pdf-action">
                            <a href="upload-cv.php" class="btn btn-black-yellow">Change</a>
                            <a href="view-cv.php" class="btn btn-yellow-black">Employee CV</a>
                        </div>
                    </li>
                    <li class="">
                    <span class="pdf-icon">
                        <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/pdf.svg')}}" alt="">
                    </span>
                        <div class="pdf-info">
                            <h6>ID Proof</h6>
                            <i>Upload PDF file (max. 20MB)</i>
                        </div>
                        <div class="pdf-action">
                            <a href="upload-cv.php" class="btn btn-dark-gray">Upload</a>
                        </div>
                    </li>
                    <li class="">
                    <span class="pdf-icon">
                        <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/pdf.svg')}}" alt="">
                    </span>
                        <div class="pdf-info">
                            <h6>Other Certificate</h6>
                            <i>Upload PDF file (max. 20MB)</i>
                        </div>
                        <div class="pdf-action">
                            <a href="upload-cv.php" class="btn btn-dark-gray">Upload</a>
                        </div>
                    </li>
                </ul> -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="working-list">
                            <h3>Arbeitszeiten</h3>
                            <ul>
                                    @if(\Carbon\Carbon::now()->format('l') == @$time[0]['day'])
                                        <li class="active">
                                            <span>Montag</span>
                                            @if(@$time[0]['is_off'] == 'off')
                                                <p>{{@$time[0]['start_time']}} - {{@$time[0]['end_time']}}</p>
                                                <i class="present-label">Jetzt</i>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <span>Montag</span>
                                            @if(@$time[0]['is_off'] == 'off')
                                                <p>{{@$time[0]['start_time']}} - {{@$time[0]['end_time']}}</p>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @endif

                                    @if(\Carbon\Carbon::now()->format('l') == @$time[1]['day'])
                                        <li class="active">
                                            <span>Dienstag</span>
                                            @if(@$time[1]['is_off'] == 'off')
                                                <p>{{@$time[1]['start_time']}} - {{@$time[1]['end_time']}}</p>
                                                <i class="present-label">Jetzt</i>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <span>Dienstag</span>
                                            @if(@$time[1]['is_off'] == 'off')
                                                <p>{{@$time[1]['start_time']}} - {{@$time[1]['end_time']}}</p>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @endif

                                    @if(\Carbon\Carbon::now()->format('l') == @$time[2]['day'])
                                        <li class="active">
                                            <span>Mittwoch</span>
                                            @if(@$time[2]['is_off'] == 'off')
                                                <p>{{@$time[2]['start_time']}} - {{@$time[2]['end_time']}}</p>
                                                <i class="present-label">Jetzt</i>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <span>Mittwoch</span>
                                            @if(@$time[2]['is_off'] == 'off')
                                                <p>{{@$time[2]['start_time']}} - {{@$time[2]['end_time']}}</p>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @endif

                                    @if(\Carbon\Carbon::now()->format('l') == @$time[3]['day'])
                                        <li class="active">
                                            <span>Donnerstag</span>
                                            @if(@$time[3]['is_off'] == 'off')
                                                <p>{{@$time[3]['start_time']}} - {{@$time[3]['end_time']}}</p>
                                                <i class="present-label">Jetzt</i>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <span>Donnerstag</span>
                                            @if(@$time[3]['is_off'] == 'off')
                                                <p>{{@$time[3]['start_time']}} - {{@$time[3]['end_time']}}</p>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @endif

                                    @if(\Carbon\Carbon::now()->format('l') == @$time[4]['day'])
                                        <li class="active">
                                            <span>Freitag</span>
                                            @if(@$time[4]['is_off'] == 'off')
                                                <p>{{@$time[4]['start_time']}} - {{@$time[4]['end_time']}}</p>
                                                <i class="present-label">Jetzt</i>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <span>Freitag</span>
                                            @if(@$time[4]['is_off'] == 'off')
                                                <p>{{@$time[4]['start_time']}} - {{@$time[4]['end_time']}}</p>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @endif

                                    @if(\Carbon\Carbon::now()->format('l') == @$time[5]['day'])
                                        <li class="active">
                                            <span>Samstag</span>
                                            @if(@$time[5]['is_off'] == 'off')
                                                <p>{{@$time[5]['start_time']}} - {{@$time[5]['end_time']}}</p>
                                                <i class="present-label">Jetzt</i>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <span>Samstag</span>
                                            @if(@$time[5]['is_off'] == 'off')
                                                <p>{{@$time[5]['start_time']}} - {{@$time[5]['end_time']}}</p>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @endif

                                    @if(\Carbon\Carbon::now()->format('l') == @$time[6]['day'])
                                        <li class="active">
                                            <span>Sonntag</span>
                                            @if(@$time[6]['is_off'] == 'off')
                                                <p>{{@$time[6]['start_time']}} - {{@$time[6]['end_time']}}</p>
                                                <i class="present-label">Jetzt</i>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <span>Sonntag</span>
                                            @if(@$time[6]['is_off'] == 'off')
                                                <p>{{@$time[6]['start_time']}} - {{@$time[6]['end_time']}}</p>
                                            @else
                                                <p><strong>Nicht verfügbar</strong></p>
                                            @endif
                                        </li>
                                    @endif
                            </ul>
                        </div>
						
						 <div class="working-list breaks-list mt-3" style="background:#F9F9FB;border-radius: 15px;padding: 20px;">
							<h3>Pausen</h3>
							 <div class="table-responsive2">
								<table id="example" class="table table-striped table-bordered  nowrap customers-table">
									<thead>
										<tr>
											<th class="cous-name">Tag</th>
											<th class="text-center">Zeit</th>
											<th>täglich </th>
										</tr>
									</thead>
									<tbody>
										@foreach($breaks as $break)
											<tr>
												<td>{{$break['everyday'] == 'on'?'--/--/----':\Carbon\Carbon::parse($break['day'])->translatedFormat('d/m/Y')}}</td>
												<td  class="text-center">{{ $break['start_time']}} - {{@$break['end_time']}}</td>
												<td>{{ $break['everyday'] == 'on'?'täglich':''}}</td>
											</tr>
										@endforeach
									
									</tbody>
								</table>
							</div>
                           <?php /* <ul>
								@foreach($breaks as $break)
									<li class="d-flex justify-content-between">
										<span>{{$break['everyday'] == 'on'?'--/--/----':\Carbon\Carbon::parse($break['day'])->translatedFormat('d/m/Y')}}</span>
										<p>{{ $break['start_time']}} - {{@$break['end_time']}}</p>
										<p class="ml-3" style="width:30px;">{{ $break['everyday'] == 'on'?'täglich':''}}</p>
									</li>
								@endforeach
							</ul> */ ?>
						 </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- <div class="work-portfolio-box">
                            <h3>Work Portfolio</h3>
                            <ul>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-1.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-2.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-3.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-4.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-5.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-6.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-1.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-2.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-3.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-4.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-5.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-6.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-1.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-2.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-3.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-4.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-5.jpg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/portfolio-6.jpg')}}" alt="">
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- deleteProfilemodal -->
    <div class="modal fade" id="deleteProfilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-profile-box">
                        <h4>Bestätigung</h4>
                        <p> - Sind Sie sicher, dass Sie diesen Mitarbeiter endgültig löschen möchten ?</p>
                    </div>
                    <div class="notes-btn-wrap">
                        {{Form::open(array('url'=>'service-provider/remove-employee','name'=>'delete-employee','method'=>'post'))}}
                        {{Form::hidden('id','',array('class'=>'delete_id'))}}
                        <button type="submit"  class="btn btn-black-yellow"> Ja, löschen?</button>
                        <a href="#" class="btn btn-gray" data-dismiss="modal" > Nein, zurück!</a>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('service_js')
    <script>
	 $('#example').DataTable({
        "lengthChange": false,
        "searching":     false,
		 "ordering":     false,
		 "pageLength" :5,
			"language": {
				"emptyTable":     "Keine Daten verfügbar.",
				"paginate": {
					"next":       "Nächste",
					"previous":   "Vorherige "
				},
			}
		});
        $(document).on('click','.delete-icon',function (){
            var id = $(this).data('id');
            $('.delete_id').val(id);
            $('#deleteProfilemodal').modal('toggle');
        })
    </script>
@endsection
