$(document).ready(function(){
    var hidden_ADK_MESSAGE_JSON = document.getElementById('hidden_ADK_MESSAGE_JSON');
    if(hidden_ADK_MESSAGE_JSON){
        var ADK_MESSAGE = JSON.parse(hidden_ADK_MESSAGE_JSON.value);

        document.getElementById('textbox_notes').value = ADK_MESSAGE.content;

        var messagefileids = [];
        for(var i = 0; i < ADK_MESSAGE.files.length; i ++){
            messagefileids.push(ADK_MESSAGE.files[i].id);
            var html = '<li><a class="pointer hoverbtn" data-id="' + ADK_MESSAGE.files[i].id + '" ' +
                        'data-desc="' + ADK_MESSAGE.files[i].desc + '" data-size="' + ADK_MESSAGE.files[i].size + '"' +
                        'onclick="getFile(' + ADK_MESSAGE.files[i].id + ');">' + ADK_MESSAGE.files[i].name + '</a></li>';
            
            document.getElementById('ul_hikeattachments').innerHTML += html;
        }
        document.getElementById('hidden_prefileids').value = messagefileids.join(',');

        //Scroll
        $('html, body').animate({scrollTop: $(span_maxminAddUpdateHike).offset().top}, 600);
    }

	$('#form_addUpdateHike, #textbox_hikedate').on('change', enableDisable_addHike);

	if(parseInt(window.location.hash.replace('#', ''))){
		var ADK_HIKE_ID = window.location.hash.replace('#', '');
		$('input[name="hikeid"][value="' + ADK_HIKE_ID + '"]').parent().children().last().click();
	}

	//addpeak remove/change date bindings
	$('#ul_addpeaks').on('click', '.addpeak-name', function(){removePeak(this);})
	.on('mouseenter', '.addpeak-name', function(){
		this.parentNode.classList.add('redhover-on');
	})
	.on('mouseleave', '.addpeak-name', function(){
		this.parentNode.classList.remove('redhover-on');
	})
	$('#ul_addpeaks').on('click', '.addpeak-date', function(){editPeakDate(this);});

	markCompletedPeaks();
});

//Hike
function addUpdateHike(form){
	function getPeaks(){
		return $('#ul_addpeaks li').get().map(function(li){
			ADK_PEAK = {
				ADK_PEAK_ID: $(li.children[0]).data('peakid')
				,ADK_PEAK_DTE: li.children[1].innerHTML
			};			
			return ADK_PEAK;
		});
	}

    addPeak();
    var ADK_PEAKS = getPeaks();
    if(ADK_PEAKS.length == 0) return false;
    document.getElementById('hidden_peaks').value = ADK_PEAKS.map(function(p){return p.ADK_PEAK_ID + ' ' + p.ADK_PEAK_DTE}).join(',');

	var currentHikeID = $('.viewing a.hoverbtn').data('id');
	
    var url = document.getElementById('h4span_addUpdateHike').innerHTML === 'Add Hike'? 'includes/hikeSave.php': 'includes/hikeUpdate.php';
	$.ajax({
		url: url
		, data: new FormData(form)
		, processData: false
		, contentType: false
		, enctype: 'multipart/form-data'
		, type: 'POST'
		, timeout: 120000
		, success: function(ret){
			$('#div_modal_loading').modal('hide');
			document.getElementById('div_table_hikes').innerHTML = ret;
			var table_hikes = document.getElementById('table_hikes');
			document.getElementById('span_numclimbed').innerHTML = table_hikes.getAttribute('data-numclimbed');
			document.getElementById('span_numpeaks').innerHTML = table_hikes.getAttribute('data-numpeaks') + ' (' + table_hikes.getAttribute('data-percent') + '%)';
			cancelHike();
			var a_maxmin_hike_data = document.getElementById('a_maxmin_hike_data');
			$('a.hoverbtn[data-id="' + currentHikeID + '"]').click();
			$('.dt').DataTable({pageLength: 20, lengthChange: false, order: [2, 'desc'], columnDefs: [{targets: 0, searchable: false, sortable: false}]});
			markCompletedPeaks();
		}
		, error: function(ret){
			var errMess = '';
			if(ret.responseText.indexOf('t') !== -1) errMess += 'Invalid file type\r\n';
			if(ret.responseText.indexOf('p') !== -1){
				if(ret.responseText.indexOf('1') !== -1 || ret.responseText.indexOf('2') !== -1) errMess += 'Max file size exceeded\r\n';
				else errMess += 'Error uploading file\r\n';
			}
			alert(errMess);
			console.log(errMess);
			$('#div_modal_loading').modal('hide');
		}
	});

	$('#div_modal_loading').modal('show');
}

function editHike(){
    cancelHike();

    //Expand addUpdate Hike section
    var span_maxminAddUpdateHike = document.getElementById('span_maxminAddUpdateHike');
    if(span_maxminAddUpdateHike.classList.contains('glyphicon-chevron-up')) $(span_maxminAddUpdateHike.parentNode).click();

    var td = document.getElementsByClassName('viewing')[0];
    var ADK_HIKE = getHikeInfo(td);

    var ul_addpeaks = document.getElementById('ul_addpeaks');
    var ul_hikeattachments = document.getElementById('ul_hikeattachments');

    //Form
    document.getElementById('h4span_addUpdateHike').innerHTML = 'Update Hike';
    document.getElementById('button_addUpdateHike').innerHTML = 'Update Hike';
    document.getElementById('hidden_hikeid').value = ADK_HIKE.ADK_HIKE_ID;

    //Peaks
    for(var i = 0; i < ADK_HIKE.ADK_PEAKS.length; i++) addPeakLi(ADK_HIKE.ADK_PEAKS[i]);
    
    //Files
    var fileIDs = [];
    for(var i = 0; i < ADK_HIKE.ADK_FILES.length; i++){
        var li = document.createElement('li');
        li.innerHTML = '<a class="pointer hoverbtn redhover" onclick="removeFile(this, \'' + ADK_HIKE.ADK_FILES[i].ADK_FILE_ID + '\');" title="Size: ' + $.fn.downloader.bytesToSize(ADK_HIKE.ADK_FILES[i].ADK_FILE_SIZE) + '  Desc: ' + ADK_HIKE.ADK_FILES[i].ADK_FILE_DESC + '">' + ADK_HIKE.ADK_FILES[i].ADK_FILE_NAME +'</a>';
        li.className = 'redhover';
        ul_hikeattachments.appendChild(li);
        fileIDs.push(ADK_HIKE.ADK_FILES[i].ADK_FILE_ID);
    }
    document.getElementById('hidden_prefileids').value = fileIDs.join(',');

    //Date
    document.getElementById('textbox_hikedate').value = ADK_HIKE.ADK_HIKE_DTE;

    //Notes
	var wysiIframeBody = getWysiIframeBody();
	if(wysiIframeBody) wysiIframeBody.innerHTML = ADK_HIKE.ADK_HIKE_NOTES;
    else document.getElementById('textbox_notes').value = ADK_HIKE.ADK_HIKE_NOTES;

    //Attachments
	
		
    //Scroll
    $('html, body').animate({scrollTo: $(span_maxminAddUpdateHike).offset().top}, 600);
	
	enableDisable_addHike();
}

function deleteHike(){
	cancelHike();
	var td = document.getElementsByClassName('viewing')[0];
	$.post('includes/hikeDelete.php'
		, {
			userid: document.getElementById('hikerId').value
			, hikeid: getHikeInfo(td).ADK_HIKE_ID
		}
		, function(ret){
			var cont = document.getElementById('div_hike_data').parentNode;
            cont.className = cont.className.replace('max', 'min');
            document.getElementById('div_table_hikes').innerHTML = ret;
			document.getElementById('span_numpeaks').innerHTML = document.getElementById('table_hikes').getAttribute('data-numpeaks');
			$('.dt').DataTable({pageLength: 20, lengthChange: false, order: [2, 'desc'], columnDefs: [{targets: 0, searchable: false, sortable: false}]});
			markCompletedPeaks();
		}
	).error(function(ret){
		var errMess = '';
		if(ret.responseText.indexOf('t') !== -1) errMess += 'Invalid file type\r\n';
		if(ret.responseText.indexOf('p') !== -1){
			if(ret.responseText.indexOf('1') !== -1 || ret.responseText.indexOf('2') !== -1) errMess += 'Max file size exceeded\r\n';
			else errMess += 'Error uploading file\r\n';
		}
		alert(errMess);
		console.log(errMess);
		$('#div_modal_loading').modal('hide');	
	});
}

function cancelHike(){
    var select_addpeaks = document.getElementById('select_addpeaks');

    document.getElementById('h4span_addUpdateHike').innerHTML = 'Add Hike';
	document.getElementById('button_addUpdateHike').innerHTML = 'Add Hike'
    
    select_addpeaks.value = '';
    document.getElementById('textbox_hikedate').value = '';
    document.getElementById('textbox_notes').value = '';
	document.getElementById('hidden_prefileids').value = '';
	var wysiIframeBody = getWysiIframeBody();
	if(wysiIframeBody) wysiIframeBody.innerHTML = '';
	var ul_addpeaks = document.getElementById('ul_addpeaks');
	while(ul_addpeaks.firstChild) ul_addpeaks.removeChild(ul_addpeaks.firstChild);
    document.getElementById('ul_hikeattachments').innerHTML = '';
	while(ul_hikeattachments.firstChild) ul_hikeattachments.removeChild(ul_hikeattachments.firstChild);
    $.fn.downloader.removeAll();

	$('.wysihtml5-command-active').each(function(){$(this).click();});
	markCompletedPeaks();
}

function getHikeInfo(td){
    var ADK_HIKE_ID = td.children[0].value;
    var ADK_HIKE_NOTES = td.children[2].innerHTML;
    var ADK_HIKE_DTE = td.children[3].value !== '--'? td.children[3].value: '';
    
	var ADK_PEAKS = [].slice.call(td.children[4].children).map(function(x){
		return {
			ADK_PEAK_ID: $(x).data('id')
			, ADK_PEAK_NAME: $(x).data('name')
			, ADK_PEAK_HEIGHT: $(x).data('height')
			, ADK_PEAK_DTE: $(x).data('date')
		};
	});
	
    var ADK_FILES = [].slice.call(td.children[5].children).map(function(x){
		return {
			ADK_FILE_ID: $(x).data('id')
			, ADK_FILE_NAME: $(x).data('name')
			, ADK_FILE_DESC: $(x).data('desc')
			, ADK_FILE_SIZE: $(x).data('size')
			, ADK_FILE_TYPE: $(x).data('type')
		};
	});

    return {
        ADK_HIKE_ID: ADK_HIKE_ID
        , ADK_HIKE_NOTES: ADK_HIKE_NOTES
        , ADK_HIKE_DTE: ADK_HIKE_DTE
        , ADK_PEAKS: ADK_PEAKS
        , ADK_FILES: ADK_FILES
    }
}

function viewHike(td){
	function getTitle(ADK_FILE){
		return ADK_FILE.ADK_FILE_NAME + "\n" + (ADK_FILE.ADK_FILE_DESC ? ADK_FILE.ADK_FILE_DESC + "\n" : '') + $.fn.downloader.bytesToSize(ADK_FILE.ADK_FILE_SIZE);
	}

	$('.viewing').each(function(){this.classList.remove('viewing');});
    td.classList.add('viewing');
    var ADK_HIKE = getHikeInfo(td);
	
    var table_hikespeaks = document.getElementById('table_hikespeaks');
    var p_hikenotes = document.getElementById('p_hikenotes');
	
    table_hikespeaks.children[1].innerHTML = '';
    p_hikenotes.innerHTML = ADK_HIKE.ADK_HIKE_NOTES;
    document.getElementById('a_heightFormat').innerHTML = '(ft)';
	
	//peaks
    for(var i = 0; i < ADK_HIKE.ADK_PEAKS.length; i++){
        var tr = document.createElement('tr');
        var td1 = document.createElement('td');
        td1.innerHTML = ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_NAME;
        var td2 = document.createElement('td');
        td2.innerHTML = ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_DTE;
		var td3 = document.createElement('td');
        td3.innerHTML = ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_HEIGHT;
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        table_hikespeaks.children[1].appendChild(tr);
    }
	
	////files
	var hasVideos = false, hasDocs = false;
    var $ul_photos = $('ul.gallery-photo')
		, $ul_videos = $('ul.gallery-video')
		, $ul_docs = $('ul.gallery-files');
	$ul_photos.empty();
	$ul_videos.empty();
	$ul_docs.empty();

	for(var i = 0; i < ADK_HIKE.ADK_FILES.length; i++){		
		switch(ADK_HIKE.ADK_FILES[i].ADK_FILE_TYPE){
			case 'photo':
				$li = $('<li class="gallery col-xs-6 col-sm-4 col-md-3 col-lg-2">');
				$a = $('<a href="#" class="photo" data-toggle="modal" data-target="#modal_gallery" data-id="' + ADK_HIKE.ADK_FILES[i].ADK_FILE_ID + '" data-desc="' + ADK_HIKE.ADK_FILES[i].ADK_FILE_DESC + '">');
				$img = $('<img src="img/loading.gif" data-original="includes/fileGetImage.php?_=' + ADK_HIKE.ADK_FILES[i].ADK_FILE_ID + '&t=t" class="img-responsive imghover lazy" alt="' + ADK_HIKE.ADK_FILES[i].ADK_FILE_NAME + '" title="' + getTitle(ADK_HIKE.ADK_FILES[i]) + '" data-toggle="tooltip" data-container="body" data-placement="bottom" />');

				$li.append($a.append($img));
				$ul_photos.append($li);

				break;
			case 'video':
				var hasVideos = true;
				$li = $('<li class="gallery" data-peaks="' + ADK_HIKE.ADK_PEAKS.join(', ') + '">');
				$a = $('<a href="#" class="video" data-toggle="modal" data-target="#modal_gallery" data-id="' + ADK_HIKE.ADK_FILES[i].ADK_FILE_ID + '" data-desc="' + ADK_HIKE.ADK_FILES[i].ADK_FILE_DESC + '">');
				$span = $('<span title="' + getTitle(ADK_HIKE.ADK_FILES[i]) + '" data-toggle="tooltip" data-container="body" data-placement="right">' + ADK_HIKE.ADK_FILES[i].ADK_FILE_NAME + '</span>');
				$ul_videos.append($li.append($a.append($span)));

				break;
			case 'doc':
				hasDocs = true;
				$li = $('<li class="gallery" data-peaks="' + ADK_HIKE.ADK_PEAKS.join(', ') + '">');
				$a = $('<a href="#" data-id="' + ADK_HIKE.ADK_FILES[i].ADK_FILE_ID + '">');
				$span = $('<span title="' + getTitle(ADK_HIKE.ADK_FILES[i]) + '" data-toggle="tooltip" data-container="body" data-placement="right">' + ADK_HIKE.ADK_FILES[i].ADK_FILE_NAME + '</span>');
				$ul_docs.append($li.append($a.append($span)));

				$a.on('click', function(){getFile($(this).data('id'));});

				break;
		}
    }
	
	$('img.lazy').lazyload({
		container: $('#div_photos')
		, effect: 'fadeIn'
		, threshold: 10
	});

	bindPhotoModal();

	if(hasVideos) $('.gallery-video-header').show(); else $('.gallery-video-header').hide();
	if(hasDocs) $('.gallery-doc-header').show(); else $('.gallery-doc-header').hide();
	
    //Maximize if minimized
    if($(td).parents('div.container-fluid')[0].nextElementSibling.classList.contains('content-min')) $('#a_maxmin_hike_data').click();
	
	tooltip();
    $('.selecttable').trigger('update');
	
	$('html, body').animate({scrollTop: $("#div_hike_data").offset().top}, 600);
}

function convertFormat(a){
    var table_hikespeaks = document.getElementById('table_hikespeaks').children[1];
    if(a.innerHTML.indexOf('m') === -1){//ft to m
        for(var i = 0; i < table_hikespeaks.children.length; i++){
            var td = table_hikespeaks.children[i].children[2];
            td.innerHTML = Math.round(parseFloat(td.innerHTML) / 3.2808);
        }
        a.innerHTML = '(m)';
    }
    else{//m to ft
        for(var i = 0; i < table_hikespeaks.children.length; i++){
            var td = table_hikespeaks.children[i].children[2];
            td.innerHTML = Math.round(parseFloat(td.innerHTML) * 3.2808);
        }
        a.innerHTML = '(ft)';
    }
}

function enableDisable_addHike(){
	function disable(disable){if(disable){button.disabled = true; button.classList.add('disabled');}else{button.disabled = false; button.classList.remove('disabled');}}
	var button = document.getElementById('button_addUpdateHike');
	disable(false);
	
	if(document.getElementById('span_fileerror').innerHTML !== ''){
		document.getElementsByClassName('jqdl-attachments')[0].classList.add('has-error');
		disable(true);
		return;
	}
	if($(this).find('.has-error').length > 0){disable(true); return;}

	var ul_addpeaks = document.getElementById('ul_addpeaks');
	if(document.getElementById('select_addpeaks').value === '' && ul_addpeaks.innerHTML === ''){disable(true); return;}

	$('.addpeak-date').each(function(){if(this.innerHTML === '???'){disable(true); return;}});

	if(ul_addpeaks.innerHTML === '' || (document.getElementById('select_addpeaks').value === '' && document.getElementById('textbox_hikedate').value === '')){disable(false); return;}
}

function modal_hike(){
	var ADK_HIKE = getHikeInfo(document.querySelector('td.viewing'));
	document.getElementById('h4_modal_hike_label').innerHTML = ADK_HIKE.ADK_PEAKS.map(function(x){return x.ADK_PEAK_NAME}).join(', ');
	document.getElementById('span_modal_hike_date').innerHTML = ADK_HIKE.ADK_HIKE_DTE;
	document.getElementById('modal_dike_notes').innerHTML = ADK_HIKE.ADK_HIKE_NOTES;
}

function printView(){
	var ADK_USER = {
			ADK_USER_NAME: document.getElementById('hidden_ADK_HIKER_NAME').value
			,ADK_USER_USERNAME: document.getElementById('hidden_ADK_HIKER_USERNAME').value
		}
		,ADK_HIKE = getHikeInfo(document.querySelector('td.viewing'));

	var newWindow = window.open();

	var fontSizeScript = "<script>function a(d){var b=document.body.style.fontSize? parseInt(document.body.style.fontSize.replace(/\D/g,'')):100;if(b>=50&&b<=150){if(d)b+=10;else b-=10;}if(b<50)b=50;if(b>150)b=150;document.body.style.fontSize=b+'%';}</script>";

	var html = '<h3 style="margin-bottom:8px;text-align:center;">The Adirondack Forty-Sixers';
	html += '<div class="noprint" style="font-size:16px;float:right;"><a href="#" style="text-decoration:none;" onclick="a(0)" title="Zoom out">-</a>&nbsp;|&nbsp;<a href="#" style="text-decoration:none;" onclick="a(1)" title="Zoom in">+</a><br /></div>';
	html += '</h3>';

	html += '<img src="img/letterhead.png" style="height:70px;float:right;margin-right:10%;" onload="window.print()" />';

	html += '';
	html += '<span>' + ADK_USER.ADK_USER_NAME + ' (' + ADK_USER.ADK_USER_USERNAME + ')</span><br /><br />';
	html += '<span>Date: ' + ADK_HIKE.ADK_HIKE_DTE + '</span><br />';
	html += '<span>' + ADK_HIKE.ADK_PEAKS.map(function(x){return x.ADK_PEAK_NAME}).join(', ') + '</span><br />';
	html += '----------------------------------------<br /><br />';
	html += '<pre style="word-break:break-word;">' + ADK_HIKE.ADK_HIKE_NOTES + '</pre>';

	newWindow.document.write(fontSizeScript + html);
}

function bindPhotoModal(){
	$('#div_photos .photo').on('click', function(){
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
	$('#div_videos .video').on('click', function(){
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
		video.innerHTML = '<source id="videosource" src="includes/fileGetVideo.php?_=' + id + '" type="video/' + name.split('.').pop() + '" />';
		
		document.getElementById('modal_gallery_container').innerHTML = video.outerHTML;
		
		bindVideoError();

		return true;
	});
}

//Peak
function addPeak(select){
	if(!select) select = document.getElementById('select_addpeaks');
    if(select.value === '') return;
    var option = select.options[select.selectedIndex];
	option.classList.add('font-italic');
	var textbox_hikedate = document.getElementById('textbox_hikedate');
    var ADK_PEAK = {
		ADK_PEAK_ID: select.value
		,ADK_PEAK_NAME: option.innerHTML
		,ADK_PEAK_DTE: textbox_hikedate.value
	};
	
	if(!/(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d/.test(ADK_PEAK.ADK_PEAK_DTE)){
		$(textbox_hikedate).blur();
		return false;
	}

    select.selectedIndex = -1;

	addPeakLi(ADK_PEAK);
    
	tooltip();
}
function addPeakLi(ADK_PEAK){
	var ul_addpeaks = document.getElementById('ul_addpeaks');

	var $li = $('<li>');
	var $a_name = $('<a class="addpeak-name" title="Remove Peak" data-toggle="tooltip" data-container="body" data-peakid="' + ADK_PEAK.ADK_PEAK_ID + '">' + ADK_PEAK.ADK_PEAK_NAME + '</a>');
	var $a_date = $('<a class="addpeak-date">' + (ADK_PEAK.ADK_PEAK_DTE === '--'? '???': ADK_PEAK.ADK_PEAK_DTE) + '</a>');

	$li.append($a_name);
	$li[0].innerHTML += '(';
	$li.append($a_date);
	$li[0].innerHTML += ')';

    ul_addpeaks.appendChild($li[0]);
}

function editPeakDate(a){
	var $input = $('<input type="text" class="date" value="' + a.innerHTML + '" style="visibility:hidden;width:0;height:0;">')
	$(a.parentNode).append($input);
	$input.datepicker({
		changeMonth: true
		,changeYear: true
		,maxDate: '+2d'
		,yearRange: '-100:+0'
	})
	.datepicker('show')
	.on('change', function(){
		$(this).datepicker('hide').datepicker('destroy');
		a.innerHTML = this.value;
		enableDisable_addHike();
		$(this).remove();
	})
	.on('blur', function(){
		enableDisable_addHike();
		$(this).remove();
	});
}

function removePeak(a){
	$(a.parentNode).remove();
	enableDisable_addHike();
	tooltip();
	markCompletedPeaks();
	var select_addpeak_opts = document.getElementById('select_addpeaks').children;
	$('.addpeak-name').each(function(){
		for(var i = 0; i < select_addpeak_opts.length; i++){
			if($(this).data('peakid') == select_addpeak_opts[i].value) select_addpeak_opts[i].classList.add('font-italic');
		}
	});
}

function markCompletedPeaks(){
	var peakIDs = document.getElementById('hidden_usedPeakIDs').value.split(',');
	$('#select_addpeaks option').each(function(){
		if(peakIDs.indexOf(this.value) !== -1) this.classList.add('font-italic');
		else this.classList.remove('font-italic');
	});
}

//File
function removeFile(a, id){
    hidden_prefileids = document.getElementById('hidden_prefileids');
    var prefileids = hidden_prefileids.value.split(',');
    var newprefileids = [];
    for(var i = 0; i < prefileids.length; i++)
        if(prefileids[i] !== id) newprefileids.push(prefileids[i]);
    hidden_prefileids.value = newprefileids.join(',');
    a.parentNode.outerHTML = '';
}