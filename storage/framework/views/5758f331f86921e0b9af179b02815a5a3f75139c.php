<?php $__env->startSection('service_title'); ?>
    Customer List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>

    <div class="main-content">
        <h2 class="page-title"><span><?php echo e(count($customerData)); ?> </span> Kunden</h2>

        <div class="appointment-header customers-header">
            <div class="appointment-search">
                <input type="text" placeholder="Suchen nach …" id="myInput">
                <a href="#"><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/search.svg')); ?>" alt=""></a>
            </div>
            <div class="sortby">





            </div>
            <a href="<?php echo e(URL::to('service-provider/add-customer')); ?>" class="appointment-btn btn-yellow">Neuen Kunden hinzufügen </a>
        </div>
        <div class="tabel-responsive">
            <table id="example" class="table table-striped table-bordered dt-responsive nowrap customers-table"
                style="width:100% !important;">
                <thead>
                <tr>
                    <th>
                        <label for="checkbox" class="checkbox-customer-2">
                        <input type="checkbox" id="checkbox" >
                        <span><i class="fas fa-check"></i></span>
                        </label>
                    </th>
                    <th>Name</th>
					<th>Telefonnummer</th>
					<th>Letzte Buchung</th>
                    <th>Buchungen</th>
                    <th>Zahlungen </th>
                     <th class="btn-delete-customer">
                    <a href="javascript:void(0)" class="btn btn-black-yellow more-detail-btn customer-delete-btn">Löschen</a>                   
                 </th>
                </tr>
                </thead>
                <tbody class="customer-rows">
                <?php $__currentLoopData = $customerData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$cnameArr = explode(" ", $row['name']);
						$cname = "";
						if(count($cnameArr) > 1){
							$cname = strtoupper(substr($cnameArr[0], 0, 1)).strtoupper(substr($cnameArr[1], 0, 1));
						}else{
							$cname = strtoupper(substr($row['name'], 0, 2));
						}
					
					?>
                    <tr> 
                        <td>
                        <label for="checkbox<?php echo e($row['c_id']); ?>" class="checkbox-customer-2">
                        <input type="checkbox" class="selectbox" id="checkbox<?php echo e($row['c_id']); ?>" name='ids' value="<?php echo e($row['c_id']); ?>">
                        <span><i class="fas fa-check"></i></span>
                        </label>
                        </td>
                        <td class="nametd">
                            <div class="tabel-profile">
                                <span>
                                <?php if(file_exists(storage_path('app/public/store/customer/'.$row['image'])) && $row['image'] != ''): ?>
                                        <img src="<?php echo e(URL::to('storage/app/public/store/customer/'.$row['image'])); ?>"
                                            alt="user">
								 <?php elseif(\BaseFunction::getUserDetailsByEmail($row['email'], 'user_image_path')): ?>
									 <img src="<?php echo e(\BaseFunction::getUserDetailsByEmail($row['email'], 'user_image_path')); ?>"
										 alt="user">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e($cname); ?>"
                                            alt="user">
                                    <?php endif; ?>
                                </span>
                                <h6>
									<?php echo e($row['name']); ?><br />
									E-Mail : <?php echo e($row['email']); ?>

								</h6>
                            </div>
                        </td>
                        <td><?php echo e($row['phone_number']); ?></td>
                        <td>
							<?php if(!empty($row['created_at'])): ?>
								<?php echo e(\Carbon\Carbon::parse($row['created_at'])->translatedFormat('d M, Y')); ?> (<?php echo e(\Carbon\Carbon::parse($row['created_at'])->translatedFormat('D')); ?>) <?php echo e(\Carbon\Carbon::parse($row['created_at'])->format('H:i')); ?>

							<?php else: ?>
								---
							<?php endif; ?>
						</td>
                        <td><?php echo e($row['total_booking']); ?></td>
                        <td><?php echo e(number_format($row['total_payment'], 2, ',', '.')); ?>€</td>
                        <td>
                            <div class="tabel-action">
								<a class="edit-link" href="<?php echo e(URL::to('service-provider/customer-details/view/'.encrypt($row['c_id']))); ?>"><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/view-eye.svg')); ?>" alt=""></a>
								<a class="edit-link" href="<?php echo e(URL::to('service-provider/edit-customer/'.encrypt($row['c_id']))); ?>"> <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/edit.svg')); ?>" alt=""></a>
                                <a class="delete-link"  href="javascript:void(0)" data-id="<?php echo e($row['c_id']); ?>"> <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/delete.svg')); ?>" alt=""></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- deleteProfilemodal -->
    <div class="modal fade" id="deleteProfilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-profile-box">
                        <h4>Bestätigung </h4>
                        <p>Sind Sie sicher, dass Sie dieses Profil endgültig löschen möchten ?</p>
                    </div>
                    <div class="notes-btn-wrap">
                        <?php echo e(Form::open(array('url'=>'service-provider/delete-customer','name'=>'delete-customer','method'=>'post'))); ?>

                        <?php echo e(Form::hidden('id','',array('class'=>'delete_id'))); ?>

                        <button type="submit"  class="btn btn-black-yellow">Ja, löschen ! </button>
                        <a href="#" class="btn btn-gray" data-dismiss="modal" >Nein, zurück!</a>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
    <script>
        // $(document).ready(function () {
        //     $('#example').DataTable({});
        // });
        $(document).ready(function () {
            $(document).on("keyup", '#myInput', function () {
                var value = $(this).val().toLowerCase();
                $(".customer-rows tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        $(document).on('click','.delete-link',function (){
            var id = $(this).data('id');
            $('.delete_id').val(id);
            $('#deleteProfilemodal').modal('toggle');
        })

        $(document).on('click','#checkbox',function(){
            if($(this).prop("checked") == true){
                $(".selectbox").prop("checked", true);
            } else {
                $(".selectbox").prop("checked", false);
            }
        });

         $(document).on('click','.customer-delete-btn',function(){

            var colors = [];
            $.each($("input[name='ids']:checked"), function() {
                colors.push($(this).val());
            });

            if(colors.length != 0){
                $('.delete_id').val(colors);
                $('#deleteProfilemodal').modal('toggle');
            }
            console.log(colors);

         });


    
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Customer/index.blade.php ENDPATH**/ ?>