<div class="image-box" rel="imgUploadPortfolio{{$i}}" id="portfolio_img_area{{$i}}">
	<div class="customer-image">
		<img id="image_imgUploadPortfolio{{$i}}" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
	</div>
	<label id="file_namePortfolio{{$i}}" for="imgUploadPortfolio{{$i}}" class="d-flex align-items-center" >
		<p>Drag & Drop the image file or</p>
		@php $imageID = 'imgUploadPortfolio'.$i; @endphp
		{{ Form::hidden('portfolio_image['.$i.'][imagename]', NULL) }}
		<input id="imgUploadPortfolio{{$i}}" type="file" name="portfolio_image[{{$i}}][image]" accept="image/*" onchange="loadFile(event, '{{$imageID}}')">
		<span class="btn btn-pink btn-photo">Upload file here</span>
	</label>
</div>
<script type="text/javascript">
	var i = "{{$i}}";
	
	vars['image_drop_area'+i] = document.querySelector("#portfolio_img_area"+i);
	uploaded_imageN['uploaded_imageN'+i];
    img_relN['img_relN'+i];
	// Event listener for dragging the image over the div
	vars['image_drop_area'+i].addEventListener('dragover', (event) => {
	  event.stopPropagation();
	  event.preventDefault();
	  // Style the drag-and-drop as a "copy file" operation.
	  event.dataTransfer.dropEffect = 'copy';
	});

	// Event listener for dropping the image inside the div
	vars['image_drop_area'+i].addEventListener('drop', (event) => {
		var img_id = event.target.id;
		img_relN['img_relN'+i] = $('#'+img_id).attr('rel');
		
	  event.stopPropagation();
	  event.preventDefault();
	  fileList = event.dataTransfer.files;

	  //document.querySelector("#file_name").textContent = fileList[0].name;
	  
	  readImageN(fileList[0]);
	});

	// Converts the image into a data URI
	readImageN = (file) => {
	  const reader = new FileReader();
	  reader.addEventListener('load', (event) => {
		 
		uploaded_imageN['uploaded_imageN'+i] = event.target.result;
		//document.querySelector(".customer-image").style.backgroundImage = `url(${uploaded_image})`;
		var image_url = `url(${uploaded_imageN['uploaded_imageN'+i]})`;
		
		$("#image_"+img_relN['img_relN'+i]).attr('src', uploaded_imageN['uploaded_imageN'+i]);
	  });
	  reader.readAsDataURL(file);
	}
</script>