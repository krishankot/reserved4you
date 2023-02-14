<?php $__env->startSection('service_title'); ?>
    Edit Employee
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
    ?>
	
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <?php echo e(Form::open(array('url'=>'service-provider/update-employee/'.encrypt($employee['id']),'method'=>'post','name'=>'edit-employee','id'=>'edit_employee','files'=>'true','novalidate'))); ?>

        
        
        
        
        
        <div class="page-title-div">
            <h2 class="page-title">Mitarbeiter </h2>
            <p><a href="<?php echo e(URL::to('service-provider/employee-list')); ?>" >Mitarbeiter </a> <span> / Profil bearbeiten</span></p>
        </div>
        <div class="appointment-header customers-header">
            <h4>Profil bearbeiten</h4>
            
            <a class="appointment-btn btn-yellow">Speichern</a>
        </div>
        <ul class="nav nav-pills eprofile-navs eprofile-navs2" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-basicDetail-tab" data-toggle="pill" href="#pills-basicDetail"
                   role="tab" aria-controls="pills-basicDetail" aria-selected="true">Informationen </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-woringHours-tab" data-toggle="pill" href="#pills-woringHours" role="tab"
                   aria-controls="pills-woringHours" aria-selected="false">Arbeitszeiten</a>
            </li>
			 <li class="nav-item">
                <a class="nav-link" id="pills-breakHours-tab" data-toggle="pill" href="#pills-breakHours" role="tab"
                   aria-controls="pills-breakHours" aria-selected="false">Pausenzeiten</a>
            </li>
            
            
            
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-basicDetail" role="tabpanel"
                 aria-labelledby="pills-basicDetail-tab">

                <div class="edit-basic-detail-main">
                    <div class="edit-basic-detail mb-0">
                        <h4>Mitarbeiterinformationen</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="image-box">
                                    <div class="customer-image">
                                        <?php if(file_exists(storage_path('app/public/store/employee/'.$employee['image'])) && $employee['image'] != ''): ?>
                                            <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.$employee['image'])); ?>"
                                                 alt=""
                                            >
                                        <?php else: ?>
                                            <img id="output"
                                                 src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')); ?>"/>
                                        <?php endif; ?>

                                    </div>
                                    <label for="imgUpload">
                                        <p>Mitarbeiter Profilbild </p>
                                        <input id="imgUpload" name="image" type="file" accept="image/*"
                                               onchange="loadFile(event)">
                                        <span class="btn btn-yellow btn-photo">Ändern</span>
                                        <a href="#" class="btn btn-remove">Löschen</a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <input type="text" name="emp_name" value="<?php echo e($employee['emp_name']); ?>" placeholder="Name" class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="address" id="autocomplete" value="<?php echo e($employee['address']); ?>" placeholder="Adresse" class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="mail" name="email" placeholder="E-Mail" value="<?php echo e($employee['email']); ?>" class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo e($employee['state']); ?>" name="state" placeholder="Land" class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="phone_number" value="<?php echo e($employee['phone_number']); ?>" placeholder="Telefonnummer "
                                       class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="zipcode" value="<?php echo e($employee['zipcode']); ?>" placeholder="Postleitzahl " class="consumer-input zipcodes">
                            </div>
                            <?php echo e(Form::hidden('latitude',$employee['latitude'],array('id'=>'latitude'))); ?>

                            <?php echo e(Form::hidden('longitude',$employee['longitude'],array('id'=>'longitude'))); ?>

                            <div class="col-lg-6">
                                <input type="text" name="employee_id" value="<?php echo e($employee['employee_id']); ?>" placeholder="Mitarbeiter ID" class="consumer-input">
                            </div>
                        </div>
                    </div>
                    <div class="edit-basic-detail edit-languages-detail">
                        <h4>Sprachen <span> (Mehrfachwahl)</span></h4>
                        <div class="select-arrows">

                            <?php echo e(Form::select('languages[]',array('Arabic'=>'Arabisch','English'=>'Englisch','French'=>'Französisch','German'=>'Deutsch','Russian'=>'Russisch','Spanish'=>'Spanisch','Turkish'=>'Türkisch'),$languages,array('class'=>'select2','multiple'=>'multiple'))); ?>

                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                    <div class="edit-basic-detail">
                        <h4>Geburtstag </h4>
                        <div class="select-arrows">
                            <input type="text" placeholder="Geburtstag " class="datepicker consumer-input mb-0" value="<?php echo e(!empty($employee['dob'])?\Carbon\Carbon::parse($employee['dob'])->format('d/m/Y'):''); ?>"
                                   name="dob">
                        </div>
                    </div>
                    <div class="edit-basic-detail mb-0">
                        <h4>Vertragsinformationen</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" placeholder="Beginn der Tätigkeit " name="joinning_date" value="<?php echo e(!empty($employee['joinning_date'])?\Carbon\Carbon::parse($employee['joinning_date'])->format('d/m/Y'):''); ?>"
                                       class="datepicker consumer-input mb-0">
                            </div>
                            <div class="col-lg-6">
                                <div class="job-price">
                                    <input type="text" value="<?php echo e($employee['payout']); ?>" name="payout" placeholder="Gehalt "
                                           class="consumer-input mb-0">
                                    <p>€</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h4>Kategorien <span> (Mehrfachwahl)</span></h4>
                            <div class="col-lg-12">
                                <div class="select-arrows select-jo">
                                    <?php echo e(Form::select('categories[]',$category,$store_category,array('class'=>'select2','multiple'=>'multiple','required'))); ?>

                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo e(Form::select('worktype',array('Full-Time'=>'Vollzeit','Part-Time'=>'Teilzeit'),$employee['worktype'],array('class'=>'select select-time'))); ?>

                            </div>
                            <div class="col-lg-6">
                                <div class="job-price">
                                    <input type="text" value="<?php echo e($employee['hours_per_week']); ?>" name="hours_per_week" placeholder="Stunden pro Woche "
                                           class="consumer-input mb-0">
                                    <p>Std./ Woche</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="edit-line"/>

                <div class="edit-basic-detail-main">
                    <div class="edit-basic-detail mb-0">
                        <h4>Bankdaten </h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo e($employee['bank_name']); ?>" name="bank_name" placeholder="Name der Bank "
                                       class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo e($employee['account_holder']); ?>" name="account_holder" placeholder="Kontoinhaber "
                                       class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo e($employee['account_number']); ?>" name="account_number" placeholder="Kontonummer "
                                       class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo e($employee['iban']); ?>" name="iban" placeholder="IBAN" class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo e($employee['swift_code']); ?>" name="swift_code" placeholder="BIC "
                                       class="consumer-input">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo e($employee['branch']); ?>" name="branch" placeholder="Verwendungszweck "
                                       class="consumer-input">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="pills-woringHours" role="tabpanel" aria-labelledby="pills-woringHours-tab">

                <div class="edit-basic-detail-main">
                    <div class="edit-basic-detail mb-0">
                        <h4>Öffnungszeiten</h4>
                        <!-- <input type="text" class="timepicker" id="picker2"> -->
                        <div class="hours-tabel-main">
                            <div class="hours-tabel-head-wrap">
                                <h6>Tag</h6>
                                <h6>Zeiten</h6>
                                <h6>Frei</h6>
                            </div>
                            <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[0]['day']): ?> active <?php endif; ?>">
                                <p>Montag</p>
                                <div class="hours-time-wrap">
                                    <?php echo e(Form::hidden('day[]','Monday')); ?>

                                    <span>Von</span>
                                    <input type="text" id="timepicker-24" class="timepicker start_time" name="start_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[0]['start_time']); ?>" <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Monday">
                                    <span>Bis</span>
                                    <input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[0]['end_time']); ?>"  <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Monday">
                                </div>
                                <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[0]['day']): ?>
                                    <i class="present-label">Present</i>
                                <?php endif; ?>
                                <label for="monday-check">
                                    <input type="checkbox" name="weekDays[]" data-id="Monday" class="weekdays" id="monday-check" <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                    <span><i class="fas fa-check"></i></span>
                                </label>
                            </div>
                            <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[1]['day']): ?> active <?php endif; ?>">
                                <p>Dienstag</p>
                                <div class="hours-time-wrap">
                                    <?php echo e(Form::hidden('day[]','Tuesday')); ?>

                                    <span>Von</span>
                                    <input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[1]['start_time']); ?>" <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Tuesday">
                                    <span>Bis</span>
                                    <input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[1]['end_time']); ?>"  <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Tuesday">
                                </div>
                                <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[1]['day']): ?>
                                    <i class="present-label">Present</i>
                                <?php endif; ?>
                                <label for="tuesday-check">
                                    <input type="checkbox" name="weekDays[]" data-id="Tuesday" class="weekdays" id="tuesday-check" <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                    <span><i class="fas fa-check"></i></span>
                                </label>
                            </div>
                            <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[2]['day']): ?> active <?php endif; ?>">
                                <p>Mittwoch</p>
                                <div class="hours-time-wrap">
                                    <?php echo e(Form::hidden('day[]','Wednesday')); ?>

                                    <span>Von</span>
                                    <input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[2]['start_time']); ?>" <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Wednesday">
                                    <span>Bis</span>
                                    <input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[2]['end_time']); ?>"  <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Wednesday">
                                </div>
                                <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[2]['day']): ?>
                                    <i class="present-label">Present</i>
                                <?php endif; ?>
                                <label for="wednesday-check">
                                    <input type="checkbox" name="weekDays[]" id="wednesday-check" class="weekdays" data-id="Wednesday" <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                    <span><i class="fas fa-check"></i></span>
                                </label>
                            </div>
                            <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[3]['day']): ?> active <?php endif; ?>">
                                <p>Donnerstag</p>
                                <div class="hours-time-wrap">
                                    <?php echo e(Form::hidden('day[]','Thursday')); ?>

                                    <span>Von</span>
                                    <input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[3]['start_time']); ?>" <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Thursday">
                                    <span>Bis</span>
                                    <input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[3]['end_time']); ?>"  <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Thursday">
                                </div>
                                <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[3]['day']): ?>
                                    <i class="present-label">Present</i>
                                <?php endif; ?>
                                <label for="thursday-check">
                                    <input type="checkbox" name="weekDays[]" id="thursday-check" class="weekdays" data-id="Thursday" <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                    <span><i class="fas fa-check"></i></span>
                                </label>
                            </div>
                            <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[4]['day']): ?> active <?php endif; ?>">
                                <p>Freitag</p>
                                <div class="hours-time-wrap">
                                    <?php echo e(Form::hidden('day[]','Friday')); ?>

                                    <span>Von</span>
                                    <input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[4]['start_time']); ?>" <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Friday">
                                    <span>Bis</span>
                                    <input type="text" class="timepicker end_time" name="end_time[]" value="<?php echo e(@$store_time[4]['end_time']); ?>"  <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    placeholder=" -- --" data-id="Friday">
                                </div>
                                <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[4]['day']): ?>
                                    <i class="present-label">Present</i>
                                <?php endif; ?>
                                <label for="friday-check">
                                    <input type="checkbox" name="weekDays[]" id="friday-check" class="weekdays" data-id="Friday" <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                    <span><i class="fas fa-check"></i></span>
                                </label>
                            </div>
                            <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[5]['day']): ?> active <?php endif; ?>">
                                <p>Samstag</p>
                                <div class="hours-time-wrap">
                                    <?php echo e(Form::hidden('day[]','Saturday')); ?>

                                    <span>Von</span>
                                    <input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[5]['start_time']); ?>" <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Saturday">
                                    <span>Bis</span>
                                    <input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[5]['end_time']); ?>"  <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Saturday">
                                </div>
                                <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[5]['day']): ?>
                                    <i class="present-label">Present</i>
                                <?php endif; ?>
                                <label for="saturday-check">
                                    <input type="checkbox" name="weekDays[]" data-id="Saturday" class="weekdays" id="saturday-check" <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                    <span><i class="fas fa-check"></i></span>
                                </label>
                            </div>
                            <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[6]['day']): ?> active <?php endif; ?>">
                                <p>Sonntag</p>
                                <div class="hours-time-wrap">
                                    <?php echo e(Form::hidden('day[]','Sunday')); ?>

                                    <span>Von</span>
                                    <input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[6]['start_time']); ?>" <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Sunday">
                                    <span>Bis</span>
                                    <input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" value="<?php echo e(@$store_time[6]['end_time']); ?>" <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                    data-id="Sunday">
                                </div>
                                <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[6]['day']): ?>
                                    <i class="present-label">Present</i>
                                <?php endif; ?>
                                <label for="sunday-check">
                                    <input type="checkbox" name="weekDays[]" id="sunday-check" class="weekdays"  data-id="Sunday" <?php echo @$store_time[6]['is_off'] == 'on' ? 'checked'  :''; ?> >
                                    <span><i class="fas fa-check"></i></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
			
			
			<div class="tab-pane fade" id="pills-breakHours" role="tabpanel" aria-labelledby="pills-breakHours-tab">

                <div class="edit-basic-detail-main">
                    <div class="edit-basic-detail mb-0">
                        
						<div class="service-header-wrap">
							<h4 class="mb-0">Pausenzeiten</h4>
							<a href="javascript:void(0);" class="btn btn-black-yellow create_breakhours">Hinzufügen</a>
						</div>
                        <!-- <input type="text" class="timepicker" id="picker2"> -->
                        <div class="hours-tabel-main">
                            <div class="hours-tabel-head-wrap">
								
                                <h6 class="ml-1">Tag</h6>
                                <h6 class="text-center">Zeit</h6>
                                <h6>täglich</h6>
                            </div>
							<?php $i = 1 ?>
							<div id="breakdivs">
								<div class="hours-tabel-body-wrap position-relative" id="break_wrap<?php echo e($i); ?>">
									<input type="hidden" name="breaks[<?php echo e($i); ?>][id]" />
									<input type="hidden" id="break_action<?php echo e($i); ?>" name="breaks[<?php echo e($i); ?>][break_action]" />
									<p>
									  <input type="text" placeholder="Datum auswählen" data-id="<?php echo e($i); ?>" class="break_day_input break_day datepicker consumer-input mb-0" value="<?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?>"
									   name="breaks[<?php echo e($i); ?>][day]">
									</p>
									<div class="hours-time-wrap">
										<span>Von</span>
										<input type="text" id="timepicker-24" class="timepicker start_time_break" name="breaks[<?php echo e($i); ?>][start_time]" placeholder=" -- --" value="" data-id="<?php echo e($i); ?>">
										<span>Bis</span>
										<input type="text" class="timepicker end_time_break" name="breaks[<?php echo e($i); ?>][end_time]" placeholder=" -- --" value="" data-id="<?php echo e($i); ?>">
									</div>
									<label for="everyday-check<?php echo e($i); ?>">
										<input type="checkbox" name="breaks[<?php echo e($i); ?>][everyday]" data-id="<?php echo e($i); ?>" class="everydays" id="everyday-check<?php echo e($i); ?>" >
										<span><i class="fas fa-check"></i></span>
									</label>
									<a href="javascript:void(0)" class="remove_breakhours" data-id="<?php echo e($i); ?>"><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/close-3.svg')); ?>" alt=""></a>
									
								</div>
								<?php $i++; ?>
								<?php $__currentLoopData = $emp_breaks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $break): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									 <div class="hours-tabel-body-wrap position-relative" id="break_wrap<?php echo e($i); ?>">
										<input type="hidden" name="breaks[<?php echo e($i); ?>][id]" value="<?php echo e($break->id); ?>" />
										<input type="hidden" id="break_action<?php echo e($i); ?>" name="breaks[<?php echo e($i); ?>][break_action]" />
										<p>
										  <input type="text" placeholder="Datum auswählen" style="<?php echo e(@$break['everyday'] == 'on' ?'pointer-events:none !important'  :''); ?>" data-id="<?php echo e($i); ?>" class="break_day_input break_day datepicker consumer-input mb-0" <?php echo @$break['everyday'] == 'on' ? 'readonly'  :''; ?> value="<?php echo e(@$break['everyday'] == 'on'?'':\Carbon\Carbon::parse($break->day)->format('d/m/Y')); ?>"
										   name="breaks[<?php echo e($i); ?>][day]">
										</p>
										<div class="hours-time-wrap">
											<span>Von</span>
											<input type="text" id="timepicker-24" class="timepicker start_time_break" name="breaks[<?php echo e($i); ?>][start_time]" placeholder=" -- --" value="<?php echo e(@$break['start_time']); ?>" 
											data-id="<?php echo e($i); ?>">
											<span>Bis</span>
											<input type="text" class="timepicker end_time_break" name="breaks[<?php echo e($i); ?>][end_time]" placeholder=" -- --" value="<?php echo e(@$break['end_time']); ?>" 
											data-id="<?php echo e($i); ?>">
										</div>
										<label for="everyday-check<?php echo e($i); ?>">
											<input type="checkbox" name="breaks[<?php echo e($i); ?>][everyday]" data-id="<?php echo e($i); ?>" class="everydays" id="everyday-check<?php echo e($i); ?>" <?php echo @$break['everyday'] == 'on' ? 'checked'  :''; ?> >
											<span><i class="fas fa-check"></i></span>
										</label>
										<a href="javascript:void(0)" class="remove_breakhours" data-id="<?php echo e($i); ?>"><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/close-3.svg')); ?>" alt=""></a>
									</div>
									
									<?php $i++; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
							</div>
							<span class="d-none break_span" rel="<?php echo e($i); ?>"></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php echo e(Form::close()); ?>


    </div>
	
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU&libraries=places&callback=initialize"
        type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({});
        });
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('autocomplete');
            var options = {
                componentRestrictions: {country: 'de'}
            };
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
                getZipcode(place.geometry['location'].lat(), place.geometry['location'].lng())
            });

        }

        function getZipcode(latitude, logitude) {
            var latlng = new google.maps.LatLng(latitude, logitude);
            geocoder = new google.maps.Geocoder();

            geocoder.geocode({'latLng': latlng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        for (j = 0; j < results[0].address_components.length; j++) {
                            if (results[0].address_components[j].types[0] == 'postal_code')
                                $('.zipcodes').val(results[0].address_components[j].short_name);
                        }
                    }
                } else {
                    alert("Geocoder failed due to: " + status);
                }
            });
        }

        // document.getElementById('output').innerHTML = location.search;

        $(document).on('click','.remove_breakhours',function (){
			var id  = $(this).data('id');
			$('#break_wrap'+id).remove();
		});
		
		
		function checkAppointmentExist(id) {
			swal({
				title: false,
				text: "Bitte beachte, dass alle Termine in dem gewählten Zeitraum automatisch verschoben bzw. storniert werden.",
				type:'warning',
				buttons: {
					reschedule:  'Verschieben',
					cancelled: 'Stornieren',
					cancel:  'Abbrechen'
				},
				dangerMode: false,
				buttonsStyling: true,
				 customClass: {
					rescheduleButton: 'example-class' //insert class here
				},
			}).then((value) => {
				if(value == 'reschedule'){
					$('#break_action'+id).val(1);
				}else if(value == 'cancelled'){
					$('#break_action'+id).val(2);
				}else{
					 $('.start_time_break[data-id='+id+']').val('');
					  $('.end_time_break[data-id='+id+']').val('');
				}
			});
			
		}
		var todaydate = "<?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?>";
		$(document).on('click','.create_breakhours',function (){
			var rel  = $('.break_span').attr('rel');
			var newid = parseInt(rel) + 1;
			$('.break_span').attr('rel', newid);
			var imgicon = "<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/close-3.svg')); ?>";
			var html = '<div class="hours-tabel-body-wrap position-relative" id="break_wrap'+rel+'">'+
								'<input type="hidden" name="breaks['+rel+'][id]">'+
								'<input type="hidden" id="break_action'+rel+'" name="breaks['+rel+'][break_action]" />'+
								'<p>'+
								  '<input type="text" placeholder="Datum auswählen" data-id="'+rel+'" class="break_day_input break_day datepicker consumer-input mb-0" value="'+todaydate+'" name="breaks['+rel+'][day]">'+
								'</p>'+
								'<div class="hours-time-wrap">'+
									'<span>Von</span>'+
									'<input type="text" id="timepicker-24" class="timepicker start_time_break" name="breaks['+rel+'][start_time]" placeholder=" -- --" value="" data-id="'+rel+'">'+
									'<span>Bis</span>'+
									'<input type="text" class="timepicker end_time_break" name="breaks['+rel+'][end_time]" placeholder=" -- --" value="" data-id="'+rel+'">'+
								'</div>'+
								'<label for="everyday-check'+rel+'">'+
									'<input type="checkbox" name="breaks['+rel+'][everyday]" data-id="'+rel+'" class="everydays" id="everyday-check'+rel+'">'+
									'<span><i class="fas fa-check"></i></span>'+
								'</label>'+
								'<a href="javascript:void(0)" class="remove_breakhours" data-id="'+rel+'"><img src="'+imgicon+'" alt=""></a>'+
								
							'</div>';
							
						$('#breakdivs').prepend(html);
		});
		$(document).on('click','.weekdays',function (){
            var id  = $(this).data('id');
            if ($(this).prop('checked')==true){
                $('.start_time[data-id='+id+']').css('pointer-events','none');
                $('.start_time[data-id='+id+']').attr('readonly', true);
                $('.start_time[data-id='+id+']').val('');
                $('.end_time[data-id='+id+']').css('pointer-events','none');
                $('.end_time[data-id='+id+']').attr('readonly', true);
                $('.end_time[data-id='+id+']').val('');
            } else {
                $('.start_time[data-id='+id+']').css('pointer-events','all');
                $('.start_time[data-id='+id+']').attr('readonly', false);
                $('.end_time[data-id='+id+']').css('pointer-events','all');
                $('.end_time[data-id='+id+']').attr('readonly', false);
                $('.start_time[data-id='+id+']').val('10:00');
                $('.end_time[data-id='+id+']').val('20:00');
            }
        });
		
		$(document).on('click','.everydays',function (){
            var id  = $(this).data('id');
            if ($(this).prop('checked')==true){
                $('.break_day[data-id='+id+']').css('pointer-events','none');
                $('.break_day[data-id='+id+']').attr('readonly', true);
                $('.break_day[data-id='+id+']').val('');
            } else {
                $('.break_day[data-id='+id+']').css('pointer-events','all');
                $('.break_day[data-id='+id+']').attr('readonly', false);
				 $('.break_day[data-id='+id+']').val(todaydate);
            }
        });

        $('#edit_employee').validate({ // initialize the plugin
            rules: {
                emp_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                phone_number: {
                   // required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 13
                },

            },
            // Specify validation error messages
            messages: {
                emp_name: {
                    required: "Please provide a Employee Name"
                },

                phone_number: {
                    required: "Please provide a Phone Number",
                    minlength: "Please enter valide Phone Number",
                    maxlength: "Please enter valide Phone Number",
                },
                email:{
                    required: "Please enter a valid email address",
                }
            },
        });

        $(document).on('click','.appointment-btn',function (){
            if($('#edit_employee').valid()){
                $('#edit_employee').submit();
            }
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Employee/edit.blade.php ENDPATH**/ ?>