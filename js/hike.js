$(document).ready(function(){
    $('#span_addPeak').click(function(){enable_disable_addPeak()});
    $('#textbox_hikedate, #select_remainingpeaks').keyup(function(){enable_disable_addPeak()});

    var hidden_ADK_MESSAGE_JSON = document.getElementById('hidden_ADK_MESSAGE_JSON');
    if(hidden_ADK_MESSAGE_JSON){
        var ADK_MESSAGE = JSON.parse(hidden_ADK_MESSAGE_JSON.value);

        document.getElementById('textbox_notes').value = ADK_MESSAGE.ADK_MESSAGE_CONTENT;

        var messagefileids = [];
        for(var i = 0; i < ADK_MESSAGE.ADK_FILES.length; i ++){
            messagefileids.push(ADK_MESSAGE.ADK_FILES[i].ADK_FILE_ID);
            var html = '<li><a class="pointer hoverbtn" data-id="' + ADK_MESSAGE.ADK_FILES[i].ADK_FILE_ID + '" ' +
                        'data-desc="' + ADK_MESSAGE.ADK_FILES[i].ADK_FILE_DESC + '" data-size="' + ADK_MESSAGE.ADK_FILES[i].ADK_FILE_SIZE + '"' +
                        'onclick="getFile(' + ADK_MESSAGE.ADK_FILES[i].ADK_FILE_ID + ');">' + ADK_MESSAGE.ADK_FILES[i].ADK_FILE_NAME + '</a></li>';
            
            document.getElementById('ul_hikeattachments').innerHTML += html;
        }
        document.getElementById('hidden_prefileids').value = messagefileids.join(',');

        //Scroll
        $('html, body').animate({scrollTop: $(span_maxminAddUpdateHike).offset().top}, 600);
    }

	$('#form_addUpdateHike').on('change', enableDisable_addHike);
});

//Hike
function addUpdateHike(form){
    addPeak();

    var ADK_PEAK_IDS = getPeakIds();
    if(ADK_PEAK_IDS.length == 0) return false;
    document.getElementById('hidden_peakids').value = ADK_PEAK_IDS.join(',');

	
    var url = document.getElementById('h4span_addUpdateHike').innerHTML === 'Add Hike'? 'includes/ajax_addHike.php': 'includes/ajax_updateHike.php';
	$.ajax({
		url: url
		,data: new FormData(form)
		,processData: false
		,contentType: false
		,enctype: 'multipart/form-data'
		,type: 'POST'
		,success: function(ret){
			$('#div_modal_loading').modal('hide');
			document.getElementById('div_table_hikes').innerHTML = ret;
			document.getElementById('span_totalpeaks').innerHTML = getUsedPeakIDs().length;
			cancelHike();
			var a_maxmin_hike_data = document.getElementById('a_maxmin_hike_data');
			if(a_maxmin_hike_data.children[0].className.indexOf('down') !== -1) $(a_maxmin_hike_data).click();
		}
		,fail: function(ret){
			$('#div_modal_loading').modal('hide');
			console.log(ret);
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

    var div_peaks_container = document.getElementById('div_peaks_container');
    var ul_hikeattachments = document.getElementById('ul_hikeattachments');

    //Form
    document.getElementById('h4span_addUpdateHike').innerHTML = 'Update Hike';
    document.getElementById('button_addUpdateHike').innerHTML = 'Update Hike';
    document.getElementById('hidden_hikeid').value = ADK_HIKE.ADK_HIKE_ID;

    //Peaks
    for(var i = 0; i < ADK_HIKE.ADK_PEAKS.length; i++){
        var span = document.createElement('span');
        span.innerHTML = ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_NAME;
        span.className = 'redhover';
        span.setAttribute('onclick', 'removePeak(this);');
        span.setAttribute('data-peakid', ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_ID);
        div_peaks_container.appendChild(span);
    }
    
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
    document.getElementById('textbox_notes').value = ADK_HIKE.ADK_HIKE_NOTES;

    //Attachments


    //Scroll
    $('html, body').animate({scrollTo: $(span_maxminAddUpdateHike).offset().top}, 600);
}

function deleteHike(){
	cancelHike();
	var td = document.getElementsByClassName('viewing')[0];
	$.post('includes/ajax_deleteHike.php'
		,{
			userid: document.getElementById('hikerId').value
			,hikeid: getHikeInfo(td).ADK_HIKE_ID
		}
		,function(ret){
            document.getElementById('div_table_hikes').innerHTML = ret;
            document.getElementById('span_totalpeaks').innerHTML = getUsedPeakIDs().length;
            document.getElementById('div_hike_data').parentNode.className.replace('max', 'min');
			enableDisableSelectOptions(getUsedPeakIDs());
		}
	);
}

function cancelHike(){
    var h4span_addUpdateHike = document.getElementById('h4span_addUpdateHike');
    var select_remainingpeaks = document.getElementById('select_remainingpeaks');

    if(h4span_addUpdateHike.innerHTML !== 'Add Hike'){//Cancel Edit hike
        h4span_addUpdateHike.innerHTML = 'Add Hike';
        document.getElementById('button_addUpdateHike').innerHTML = 'Add Hike';
    }
    
    select_remainingpeaks.value = '';
    var usedPeakIDs = getUsedPeakIDs();
    enableDisableSelectOptions(usedPeakIDs);
    document.getElementById('textbox_hikedate').value = '';
    document.getElementById('textbox_notes').value = '';
    document.getElementById('div_peaks_container').innerHTML = '';
    document.getElementById('ul_hikeattachments').innerHTML = '';
    $.fn.downloader.removeAll();
    document.getElementById('hidden_hikeid').value
}

function getHikeInfo(td){
    var ADK_HIKE_ID = td.children[0].value;
    var ADK_HIKE_NOTES = td.children[2].value;
    var ADK_HIKE_DTE = td.children[3].value !== 'N/A'? td.children[3].value: '';
    var ADK_PEAKS = [];
    var ADK_FILES = [];

    var peaks = td.children[4].children;
    for(var i = 0; i < peaks.length; i++){
        var ADK_PEAK = {};
        ADK_PEAK.ADK_PEAK_ID = $(peaks[i]).data('id');
        ADK_PEAK.ADK_PEAK_NAME = $(peaks[i]).data('name');
        ADK_PEAK.ADK_PEAK_HEIGHT = $(peaks[i]).data('height');
        ADK_PEAKS.push(ADK_PEAK);
    }

    var files = td.children[5].children;
    for(var i = 0; i < files.length; i++){
        var ADK_FILE = {};
        ADK_FILE.ADK_FILE_ID = $(files[i]).data('id');
        ADK_FILE.ADK_FILE_NAME = $(files[i]).data('name');
        ADK_FILE.ADK_FILE_DESC = $(files[i]).data('desc');
        ADK_FILE.ADK_FILE_SIZE = $(files[i]).data('size');
        ADK_FILES.push(ADK_FILE);
    }

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
            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'tif': case 'tiff': return 'Picture';
            case 'mpg': case 'mpeg': case 'avi': case 'mov': case 'webm': case 'mkv': case 'flv': case 'ogg':
            case 'oggv': case 'wmv': case 'mp4': return 'Video';
            default: return 'Doc/File';
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

    for(var i = 0; i < ADK_HIKE.ADK_PEAKS.length; i++){
        var tr = document.createElement('tr');
        var td1 = document.createElement('td');
        td1.innerHTML = ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_NAME;
        var td2 = document.createElement('td');
        td2.innerHTML = ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_HEIGHT;
        tr.appendChild(td1);
        tr.appendChild(td2);
        table_hikespeaks.children[1].appendChild(tr);
    }

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
    if($(td).parents('div.container-fluid')[0].nextElementSibling.classList.contains('content-min'))
        $('#a_maxmin_hike_data').click();

	tooltip();
    $('.selecttable').trigger('update');

	$('html, body').animate({scrollTop: $("#div_hike_data").offset().top}, 600);
}

function getPeakIds(){
    var spans = document.getElementById('div_peaks_container').querySelectorAll('span');
    var ADK_PEAK_IDS = [];
    for(var i = 0; i < spans.length; i++) ADK_PEAK_IDS.push($(spans[i]).data('peakid'));
    return ADK_PEAK_IDS;
}

function getUsedPeakIDs(){
    var usedPeakIDs = document.getElementById('hidden_usedPeakIDs').value.split(',');
    for(var i = 0; i < usedPeakIDs.length; i++) usedPeakIDs[i] = parseInt(usedPeakIDs[i]);
    return usedPeakIDs;
}

function convertFormat(a){
    var table_hikespeaks = document.getElementById('table_hikespeaks').children[1];
    if(a.innerHTML.indexOf('m') === -1){//ft to m
        for(var i = 0; i < table_hikespeaks.children.length; i++){
            var td = table_hikespeaks.children[i].children[1];
            td.innerHTML = Math.round(parseFloat(td.innerHTML) / 3.2808);
        }
        a.innerHTML = '(m)';
    }
    else{//m to ft
        for(var i = 0; i < table_hikespeaks.children.length; i++){
            var td = table_hikespeaks.children[i].children[1];
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

	if((document.getElementById('select_remainingpeaks').value === '' && document.getElementById('div_peaks_container').innerHTML === '')
		&& document.getElementById('textbox_hikedate').innerHTML === ''){disable(true); return;}
}

//Peak
function addPeak(select){
    if(!select) select = document.getElementById('select_remainingpeaks');
    if(select.value == '') return;
    var option = select.options[select.selectedIndex];
    var ADK_PEAK_ID = select.value;
    var ADK_PEAK_NAME = option.innerHTML;
    select.selectedIndex = -1;

    var div_peaks_container = document.getElementById('div_peaks_container');

    var span = document.createElement('span');
    span.innerHTML = ADK_PEAK_NAME;
    span.classList.add('redhover');
    span.setAttribute('onclick', 'removePeak(this);');
    span.setAttribute('data-peakid', ADK_PEAK_ID);
	span.setAttribute('title', 'Remove Peak');
	span.setAttribute('data-toggle', 'tooltip');
	span.setAttribute('data-container', 'body');

    div_peaks_container.appendChild(span);
    option.disabled = true;
	tooltip();
}

function removePeak(span){
    var ADK_PEAK_ID = $(span).data('peakid');
    var select = document.getElementById('select_remainingpeaks');
    for(var i = 0; i < select.children.length; i++){
        if(select.children[i].value == ADK_PEAK_ID){
            select.children[i].disabled = false; break;
        }
    }

    var div_peaks_container = span.parentNode;
    div_peaks_container.removeChild(span);

    enable_disable_addPeak();
}

function enable_disable_addPeak(){
    document.getElementById('button_addUpdateHike').disabled = false;
    if($('#select_remainingpeaks').value == '' && $('#div_peaks_container')[0].innerHTML == '') document.getElementById('button_addUpdateHike').disabled = true;
    if($('#textbox_hikedate')[0].value == '') document.getElementById('button_addUpdateHike').disabled = true;
}
function enableDisableSelectOptions(usedPeakIDs){
    var select_remainingpeaks = document.getElementById('select_remainingpeaks');
    for(var i = 0; i < select_remainingpeaks.children.length; i++){
        select_remainingpeaks.children[i].disabled = false;
        if(usedPeakIDs.indexOf(parseInt(select_remainingpeaks.children[i].value)) !== -1) select_remainingpeaks.children[i].disabled = true;
    }
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