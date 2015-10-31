$(document).ready(function(){

	//User filter
	var userID = $_GET('_');
	if(parseInt(userID) && userID > 0) $('#select_ADK_HIKER').val($_GET('_'));
	$('#select_ADK_HIKER').on('change',function(){
		window.location = 'gallery?_=' + this.value;
	});

	//Peak filter
	$('#select_filter').on('change',function(){
		var lis = document.querySelectorAll('li.gallery');

		if(this.value === ''){
			for(var i = 0; i < lis.length; i++) lis[i].style.display = '';
		}
		else{
			for(var i = 0; i < lis.length; i++){
				var peaks = lis[i].getAttribute('data-peaks').split(',');
				if(peaks.indexOf(this.value) === -1) lis[i].style.display = 'none';
				else lis[i].style.display = '';
			}
		}
	});

    $('.photo').click(function(){
		var desc = getDownloadLink(this.getAttribute('data-id')) +
			'<strong>' + this.getAttribute('data-un') + '</strong><br />' + this.getAttribute('data-peaks') +
			'<div class="hr"></div>' + this.getAttribute('data-desc');
		document.getElementById('modal_gallery_label').innerHTML = this.children[0].getAttribute('alt');
		document.getElementById('modal_gallery_desc').innerHTML = desc;
		var img = this.children[0].cloneNode();
		img.setAttribute('data-original', img.src.replace('&t=t', ''));
		img.src = 'img/loading.gif';
		img.classList.remove('imghover');
		$('#modal_gallery_container').html('').append(img);
		$(img).attr('src', $(img).data('original'));

		return true;
	});

	$('.video').click(function(){
		var id = this.getAttribute('data-id'), name = this.children[0].innerHTML
			,desc = getDownloadLink(this.getAttribute('data-id')) +
				'<strong>' + this.getAttribute('data-un') + '</strong><br />' + this.getAttribute('data-peaks') +
				'<div class="hr"></div>' + this.getAttribute('data-desc');

		document.getElementById('modal_gallery_label').innerHTML = name;
		document.getElementById('modal_gallery_desc').innerHTML = desc;
		
		var video = document.createElement('video');
		video.setAttribute('id', 'video');
		video.setAttribute('controls', 'controls');
		video.setAttribute('width', '100%');
		video.innerHTML = '<source id="videosource" src="includes/getVideo.php?_=' + id + '" type="video/' + name.split('.').pop() + '" />';
		
		document.getElementById('modal_gallery_container').innerHTML = video.outerHTML;
		
		bindVideoError();

		return true;
	});

	

});

function getDownloadLink(id){
	return '<button class="btn btn-sm btn-default pull-right" onclick="getFile(' + id + ');">' +
				'Download&nbsp;<span class="glyphicon glyphicon-download"></span>' +
           '</button>';
}

function bindVideoError(){
	document.querySelector('source').addEventListener('error', function(){
		var errordiv = document.createElement('div');
		errordiv.innerHTML = 
			'<div class="text-center" style="margin:15px 0 28px;">' +
				'<p>This video format cannot be streamed, but you can still download it below.</p>' +
			'</div>';
		this.parentNode.parentNode.replaceChild(errordiv, this.parentNode);
	}, false);
}