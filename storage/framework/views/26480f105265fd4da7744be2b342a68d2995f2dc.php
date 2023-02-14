<?php $__env->startSection('service_title'); ?>
    Employee List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <h2 class="page-title"><span><?php echo e(count($data)); ?>  </span> Mitarbeiter </h2>
        <div class="appointment-header customers-header mb-3">
            <div class="appointment-search">
                <input type="text" placeholder="Suchen nach …" id="myInput">
                <a href="#"><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/search.svg')); ?>"
                                 alt=""></a>
            </div>
            <div class="sortby sortby2">
                <select class="select store_category">
                    <option value=""
                            data-value="">Alle Stores
                    </option>
                    <?php $__currentLoopData = $getStore; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(session('store_id') == $row->id): ?>

                            <option value="<?php echo e($row->id); ?>"
                                    data-value="<?php echo e($row->store_address); ?>" selected><?php echo e($row->store_name); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($row->id); ?>"
                                    data-value="<?php echo e($row->store_address); ?>"><?php echo e($row->store_name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="select-p-text"><?php echo e(session('address')); ?></p>
            </div>
            <a href="<?php echo e(URL::to('service-provider/add-employee')); ?>" class="employeebtn appointment-btn btn-yellow">Neuen Mitarbeiter hinzufügen</a>
            <a href="#" class="employeebtn employee-btn btn-main">Schichtplan</a>
        </div>
        <div class="row employee-rows">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-mb-6">
                    <div class="employee-item-box">
                        <div class="employee-item">
                            <div class="employee-item-profile">
								<?php
									$empnameArr = explode(" ", $row->emp_name);
									$empname = "";
									if(count($empnameArr) > 1){
										$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
									}else{
										$empname = strtoupper(substr( $row->emp_name, 0, 2));
									}
								?>
                                <?php if(file_exists(storage_path('app/public/store/employee/'.$row->image)) && $row->image != ''): ?>
                                    <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.$row->image)); ?>" alt="" >
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
                                <?php endif; ?>
                            </div>
                            <div class="employee-item-info">
                                <h5><?php echo e($row->emp_name); ?></h5>
                                <ul>
                                    <li>
                                        <span>Mitarbeiter ID:</span>
                                        <p><?php echo e($row->employee_id == '' ? '-' : $row->employee_id); ?></p>
                                    </li>
                                    <li>
                                        <span>Heutige Arbeitszeit: </span>
                                        <?php if(@$row->time->is_off == 'off'): ?>
                                            <p><?php echo e(\Carbon\Carbon::parse(@$row->time->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse(@$row->time->end_time)->format('H:i')); ?></p>
                                        <?php else: ?>
                                            <p class="text-red">nicht Verfügbar <i class="far fa-question-circle"></i></p>
                                        <?php endif; ?>

                                    </li>
                                    <li>
                                        <span>Kategorie:</span>
                                        <p><?php echo e(implode(',',$row->category)); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <a href="<?php echo e(URL::to('service-provider/employee-details/'.encrypt($row->id))); ?>"
                               class="btn btn-black-yellow more-detail-btn">Details anzeigen</a>
                        </div>
                        <a class="employee-contact-link" href="tel:<?php echo e($row->phone_number); ?>"><span><img
                                    src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/phone.svg')); ?>" alt=""></span><?php echo e($row->phone_number == '' ? '-' :$row->phone_number); ?>

                        </a>
                        <a class="employee-contact-link" href="mailto:<?php echo e($row->email); ?>"><span><img
                                    src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/mail-2.svg')); ?>" alt=""></span><?php echo e($row->email == '' ? '-' : $row->email); ?>

                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Employee/index.blade.php ENDPATH**/ ?>