<?php $__env->startSection('service_title'); ?>
    Edit Customer
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <h2 class="page-title">Kunden</h2>
        <?php echo e(Form::open(array('url'=>'service-provider/update-customer/'.encrypt($customer['id']),'method'=>'post','name'=>'add-customer','id'=>'add_customer','files'=>'true'))); ?>

        <div class="appointment-header customers-header">
            <h4>Kunden bearbeiten</h4>
            <button type="submit" class="appointment-btn btn-yellow">Speichern</button>
        </div>

        <div class="consumer-form">
            <h4>Kundeninformationen </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="image-box">
                        <div class="customer-image">

                            <?php if(file_exists(storage_path('app/public/store/customer/'.$customer['image'])) && $customer['image'] != ''): ?>
                                <img src="<?php echo e(URL::to('storage/app/public/store/customer/'.$customer['image'])); ?>"
                                     alt=""  id="output"
                                >
                            <?php else: ?>
                                <img id="output"
                                     src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')); ?>"/>
                            <?php endif; ?>
                        </div>
                        <label for="imgUpload">
                            <p>Kunden Profilbild</p>
                            <input id="imgUpload" type="file" name="image" accept="image/*" onchange="loadFile(event)">
                            <span class="btn btn-yellow btn-photo">Datei wählen</span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-6">

                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Vor-/Nachname" name="name" value="<?php echo e($customer['name']); ?>" class="consumer-input" required>
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Adresse" name="address" class="consumer-input" value="<?php echo e($customer['address']); ?>" id="autocomplete">
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="E-Mail" name="email"  class="consumer-input" value="<?php echo e($customer['email']); ?>" required>
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Land" name="state" class="consumer-input" value="<?php echo e($customer['state']); ?>">
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Telefonnummer " name="phone_number" class="consumer-input" value="<?php echo e($customer['phone_number']); ?>" required>
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Postleitzahl" name="zipcode" class="consumer-input zipcodes" value="<?php echo e($customer['zipcode']); ?>">
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

        document.getElementById('output').innerHTML = location.search;

        $('#add_customer').validate({ // initialize the plugin
            rules: {
                name: {
                    required: true,
                },
                
                email: {
                    required: true,
                    email: true
                },
                phone_number: {
                    required: false,
                    number: true,
                    minlength: 11,
                    maxlength: 13
                },
                zipcode : {
                    number: true,
                },
            },

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Customer/edit.blade.php ENDPATH**/ ?>