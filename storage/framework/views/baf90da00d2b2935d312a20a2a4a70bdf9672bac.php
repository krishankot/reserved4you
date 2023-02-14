<aside class="sidebar">
    <a href="<?php echo e(url('dienstleister')); ?>" class="sidebar-logo">
        <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/logo.png')); ?>" alt="">
    </a>
    <ul class="sidebar">
        <li>
            <a href="<?php echo e(URL::to('dienstleister/')); ?>" class="<?php echo e(Request::is('dienstleister') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/kalender')); ?>"
               class="<?php echo e(Request::is('dienstleister/kalender') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/buchung')); ?>"
               class="<?php echo e(Request::is('dienstleister/buchung') || Request::is('dienstleister/buchung-erstellen') || Request::is('dienstleister/checkout-prozess') || Request::is('dienstleister/zahlungsabschluss') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/kunden')); ?>"
               class="<?php echo e(Request::is('dienstleister/kunden') || Request::is('dienstleister/kunden-hinzufuegen') || Request::is('dienstleister/kunden-bearbeiten') || Request::is('service-provider/add-customer') || Request::is('service-provider/edit-customer*') || Request::is('service-provider/customer-details*') || Request::is('dienstleister/kunden-details*') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/mitarbeiter')); ?>"
               class="<?php echo e(Request::is('dienstleister/mitarbeiter') || Request::is('dienstleister/mitarbeiter-details*') || Request::is('dienstleister/mitarbeiter-hinzufuegen') || Request::is('dienstleister/mitarbeiter-bearbeiten*') || Request::is('service-provider/add-employee') || Request::is('service-provider/edit-employee*') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/betriebsprofil')); ?>"
               class="<?php echo e(Request::is('dienstleister/betriebsprofil') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/statistiken')); ?>"
               class="<?php echo e(Request::is('dienstleister/statistiken') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/finanzen')); ?>"
               class="<?php echo e(Request::is('dienstleister/finanzen') ? 'active' : ''); ?>">
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
            <a href="<?php echo e(URL::to('dienstleister/einstellungen')); ?>" class="<?php echo e(Request::is('dienstleister/einstellungen') ? 'active' : ''); ?>">
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
                        <h4><?php echo e(__('Confirmation')); ?></h4>
                        <p><?php echo e(__('Are you sure you want to change the store')); ?></p>

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
<?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/Includes/Service/sidebar.blade.php ENDPATH**/ ?>