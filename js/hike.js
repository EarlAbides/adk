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

	$('#form_addUpdateHike').on('change', enableDisable_addHike);

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

	
    var url = document.getElementById('h4span_addUpdateHike').innerHTML === 'Add Hike'? 'includes/hikeSave.php': 'includes/hikeUpdate.php';
	$.ajax({
		url: url
		,data: new FormData(form)
		,processData: false
		,contentType: false
		,enctype: 'multipart/form-data'
		,type: 'POST'
		,timeout: 120000
		,success: function(ret){
			$('#div_modal_loading').modal('hide');
			document.getElementById('div_table_hikes').innerHTML = ret;
			var table_hikes = document.getElementById('table_hikes');
			document.getElementById('span_numclimbed').innerHTML = table_hikes.getAttribute('data-numclimbed');
			document.getElementById('span_numpeaks').innerHTML = table_hikes.getAttribute('data-numpeaks') + ' (' + table_hikes.getAttribute('data-percent') + '%)';
			cancelHike();
			var a_maxmin_hike_data = document.getElementById('a_maxmin_hike_data');
			if(a_maxmin_hike_data.children[0].className.indexOf('down') !== -1) $(a_maxmin_hike_data).click();
			$('.dt').DataTable({pageLength: 20, lengthChange: false, order: [2, 'desc'], columnDefs: [{targets: 0, searchable: false, sortable: false}]});
		}
		,error: function(ret){
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
	
	
	enableDisable_addHike();
	
    //Scroll
    $('html, body').animate({scrollTo: $(span_maxminAddUpdateHike).offset().top}, 600);
}

function deleteHike(){
	cancelHike();
	var td = document.getElementsByClassName('viewing')[0];
	$.post('includes/hikeDelete.php'
		,{
			userid: document.getElementById('hikerId').value
			,hikeid: getHikeInfo(td).ADK_HIKE_ID
		}
		,function(ret){
			var cont = document.getElementById('div_hike_data').parentNode;
            cont.className = cont.className.replace('max', 'min');
            document.getElementById('div_table_hikes').innerHTML = ret;
			document.getElementById('span_totalpeaks').innerHTML = document.getElementById('table_hikes').getAttribute('data-numpeaks');
			$('.dt').DataTable({pageLength: 20, lengthChange: false, order: [2, 'desc'], columnDefs: [{targets: 0, searchable: false, sortable: false}]});
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
    var select_remainingpeaks = document.getElementById('select_remainingpeaks');

    document.getElementById('h4span_addUpdateHike').innerHTML = 'Add Hike';
	document.getElementById('button_addUpdateHike').innerHTML = 'Add Hike'
    
    select_remainingpeaks.value = '';
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
}

function getHikeInfo(td){
    var ADK_HIKE_ID = td.children[0].value;
    var ADK_HIKE_NOTES = td.children[2].innerHTML;
    var ADK_HIKE_DTE = td.children[3].value !== 'N/A'? td.children[3].value: '';
    
	var ADK_PEAKS = [].slice.call(td.children[4].children).map(function(x){
		return {
			ADK_PEAK_ID: $(x).data('id')
			,ADK_PEAK_NAME: $(x).data('name')
			,ADK_PEAK_HEIGHT: $(x).data('height')
			,ADK_PEAK_DTE: $(x).data('date')
		};
	});
	
    var ADK_FILES = [].slice.call(td.children[5].children).map(function(x){
		return {
			ADK_FILE_ID: $(x).data('id')
			,ADK_FILE_NAME: $(x).data('name')
			,ADK_FILE_DESC: $(x).data('desc')
			,ADK_FILE_SIZE: $(x).data('size')
		};
	});

    return {
        ADK_HIKE_ID: ADK_HIKE_ID,
        ADK_HIKE_NOTES: ADK_HIKE_NOTES,
        ADK_HIKE_DTE: ADK_HIKE_DTE,
        ADK_PEAKS: ADK_PEAKS,
        ADK_FILES: ADK_FILES
    }
}

function viewHike(td){
	function getFileCategory(ADK_FILE_NAME){
		var ext = ADK_FILE_NAME.split('.').pop();
		switch(ext){
            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'tif': case 'tiff':
				return 'Picture';
            case 'mpg': case 'mpeg': case 'avi': case 'mov': case 'webm': case 'mkv': case 'flv': case 'ogg': case 'oggv': case 'wmv': case 'mp4':
				return 'Video';
            default:
				return 'Doc/File';
        }
	}
	
    $('.viewing').each(function(){this.classList.remove('viewing');});
    td.classList.add('viewing');
    var ADK_HIKE = getHikeInfo(td);
	
    var table_hikespeaks = document.getElementById('table_hikespeaks');
    var table_hikeattachments = document.getElementById('table_hikeattachments');
    var span_hikenotes = document.getElementById('span_hikenotes');
	
    table_hikespeaks.children[1].innerHTML = '';
    table_hikeattachments.children[1].innerHTML = '';
    span_hikenotes.innerHTML = ADK_HIKE.ADK_HIKE_NOTES;
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
	
	//files
    for(var i = 0; i < ADK_HIKE.ADK_FILES.length; i++){
        var tr = document.createElement('tr');
        var td1 = document.createElement('td');
        td1.innerHTML = '<a class="pointer hoverbtn" onclick="getFile(' + ADK_HIKE.ADK_FILES[i].ADK_FILE_ID + ');"><span class="glyphicon glyphicon-download" title=\"Download\" data-toggle=\"tooltip\" data-placement=\"top\" data-container=\"body\"></span></a>';
        td1.style['padding-left'] = '0';
        var td2 = document.createElement('td');
        td2.innerHTML = ADK_HIKE.ADK_FILES[i].ADK_FILE_NAME;
        var td3 = document.createElement('td');
        td3.innerHTML = ADK_HIKE.ADK_FILES[i].ADK_FILE_DESC;
        var td4 = document.createElement('td');
        td4.innerHTML = getFileCategory(ADK_HIKE.ADK_FILES[i].ADK_FILE_NAME);
        var td5 = document.createElement('td');
        td5.innerHTML = $.fn.downloader.bytesToSize(ADK_HIKE.ADK_FILES[i].ADK_FILE_SIZE);
        tr.appendChild(td1); tr.appendChild(td2); tr.appendChild(td3);
        tr.appendChild(td4); tr.appendChild(td5);
        table_hikeattachments.children[1].appendChild(tr);
    }
	
    //Maximize if minimized
    if($(td).parents('div.container-fluid')[0].nextElementSibling.classList.contains('content-min')) $('#a_maxmin_hike_data').click();
	
	tooltip();
    //$('.selecttable').trigger('update');
	
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

	if(document.getElementById('select_remainingpeaks').value === ''
		&& document.getElementById('ul_addpeaks').innerHTML === ''
		&& document.getElementById('textbox_hikedate').innerHTML === ''){
		disable(true);
		return;
	}
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

//Peak
function addPeak(select){
	if(!select) select = document.getElementById('select_remainingpeaks');
    if(select.value === '') return;
    var option = select.options[select.selectedIndex];
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
	var $a_date = $('<a class="addpeak-date">' + ADK_PEAK.ADK_PEAK_DTE + '</a>');

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
		$(this).remove();
	});
}

function removePeak(a){
	$(a.parentNode).remove();
	enableDisable_addHike();
	tooltip();
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