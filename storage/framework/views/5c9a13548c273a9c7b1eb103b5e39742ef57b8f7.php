<aside class="sidebar">
    <a href="<?php echo e(url('service-provider')); ?>" class="sidebar-logo">
        <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/logo.png')); ?>" alt="">
    </a>
    <ul class="sidebar">
        <li>
            <a href="<?php echo e(URL::to('service-provider/')); ?>" class="<?php echo e(Request::is('service-provider') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
                    <?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/home.svg'); ?>

                </span>
                <p>Dashboard</p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo e(URL::to('service-provider/calender')); ?>"
               class="<?php echo e(Request::is('service-provider/calender') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
					<?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/calendar.svg'); ?>

                </span>
                <p>Kalender </p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(URL::to('service-provider/appointment')); ?>"
               class="<?php echo e(Request::is('service-provider/appointment') || Request::is('service-provider/create-appointment') || Request::is('service-provider/checkout-data') || Request::is('service-provider/proceed-to-pay') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
                   <?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/appointments.svg'); ?>

                </span>
                <p>Buchungen</p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(URL::to('service-provider/customers')); ?>"
               class="<?php echo e(Request::is('service-provider/customers') || Request::is('service-provider/add-customer') || Request::is('service-provider/edit-customer*')|| Request::is('service-provider/customer-details*') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
					<?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/customers.svg'); ?>

                </span>
                <p>Kunden</p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(URL::to('service-provider/employee-list')); ?>"
               class="<?php echo e(Request::is('service-provider/employee-list') || Request::is('service-provider/employee-details*') || Request::is('service-provider/add-employee') || Request::is('service-provider/edit-employee*') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
					<?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/employees.svg'); ?>

                </span>
                <p>Mitarbeiter </p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(URL::to('service-provider/store-profile')); ?>"
               class="<?php echo e(Request::is('service-provider/store-profile') ? 'active' : ''); ?>">
                <span class="sidebar-icon storeico">
                   <?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/store-profile.svg'); ?>

                </span>
                <p>Betriebsprofil</p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(URL::to('service-provider/statistics')); ?>"
               class="<?php echo e(Request::is('service-provider/statistics') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
                   <?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/statistics.svg'); ?>

                </span>
                <p>Statistiken</p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(URL::to('service-provider/wallet')); ?>"
               class="<?php echo e(Request::is('service-provider/wallet') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
                    <?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/wallet.svg'); ?>

                </span>
                <p>Finanzen</p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(URL::to('service-provider/settings')); ?>" class="<?php echo e(Request::is('service-provider/settings') ? 'active' : ''); ?>">
                <span class="sidebar-icon">
                    <?php echo file_get_contents('storage/app/public/Serviceassets/images/icon/sidebar/setting.svg'); ?>

                </span>
                <p>Einstellungen </p>
                <span class="sidebar-arrow">
                    <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/sidebar/sidebar-arrow.svg')); ?>"
                         alt="">
                </span>
            </a>
        </li>
    </ul>

    <div class="sidebar-profile">
        <div class="sidebar-profile-heading">
            <span>Mein Store </span>
            <a href="#" data-toggle="modal" data-target="#andernModal">Ändern</a>
        </div>
        <div class="sidebar-profile-wrap">
             <span>
                 <img src="<?php echo e(session('store_profile') == '' ? URL::to('storage/app/public/default/default_store.jpeg') : session('store_profile')); ?>" alt="">
             </span>
            <div>
                <h6><?php echo e(session('store_name') == '' ? 'Alle Stores' : session('store_name')); ?></h6>
                <p><?php echo e(session('address')); ?></p>
            </div>
        </div>
    </div>
</aside>


<div class="modal fade show" id="andernModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-profile-box">
                        <h4>Confirmation</h4>
                        <p>Are you sure you want to change the store?</p>

                    <select class="select store_category store_category2 my-5 ">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH /var/www/html/resources/views/Includes/Service/sidebar.blade.php ENDPATH**/ ?>