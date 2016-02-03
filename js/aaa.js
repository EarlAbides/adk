function cancelHike(){
    var h4span_addUpdateHike = document.getElementById('h4span_addUpdateHike');
    var select_remainingpeaks = document.getElementById('select_remainingpeaks');

    if(h4span_addUpdateHike.innerHTML !== 'Add Hike'){//Cancel Edit hike
        h4span_addUpdateHike.innerHTML = 'Add Hike';
        document.getElementById('button_addUpdateHike').innerHTML = 'Add Hike';
    }
    
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
    for(var i = 0; i < ADK_HIKE.ADK_PEAKS.length; i++){
		var $li = $('<li>');
		////////////////////////////
		//////////////////////////COPY FROM NEW addPeak() FUNC AND THEN MOVE THIS OUT INTO IT'S OWN FUNC, addPeakLi()////////////////////////////
		////////////////////////////
		////////////////////////////
		////////////////////////////
		
		
		
        //var span = document.createElement('span');
        //span.innerHTML = ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_NAME;
        //span.className = 'redhover';
        //span.setAttribute('onclick', 'removePeak(this);');
        //span.setAttribute('data-peakid', ADK_HIKE.ADK_PEAKS[i].ADK_PEAK_ID);
        //div_peaks_container.appendChild(span);
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
	var wysiIframeBody = getWysiIframeBody();
	if(wysiIframeBody) wysiIframeBody.innerHTML = ADK_HIKE.ADK_HIKE_NOTES;
    else document.getElementById('textbox_notes').value = ADK_HIKE.ADK_HIKE_NOTES;

    //Attachments
	
	
	enableDisable_addHike();
	
    //Scroll
    $('html, body').animate({scrollTo: $(span_maxminAddUpdateHike).offset().top}, 600);
}

function getHikeInfo(td){
    var ADK_HIKE_ID = td.children[0].value;
    var ADK_HIKE_NOTES = td.children[2].innerHTML;
    var ADK_HIKE_DTE = td.children[3].value !== 'N/A'? td.children[3].value: '';
    
	var ADK_PEAKS = td.children[4].children.map(function(x){
		return {
			ADK_PEAK_ID: $(peaks[i]).data('id')
			,ADK_PEAK_NAME: $(peaks[i]).data('name')
			,ADK_PEAK_HEIGHT: $(peaks[i]).data('height')
			,ADK_PEAK_DTE: $(peaks[i]).data('date')
		};
	});
	
    var ADK_FILES = td.children[5].children.map(function(x){
		return {
			ADK_FILE_ID: $(peaks[i]).data('id')
			,ADK_FILE_NAME: $(peaks[i]).data('name')
			,ADK_FILE_DESC: $(peaks[i]).data('desc')
			,ADK_FILE_SIZE: $(peaks[i]).data('size')
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



///////////php
//in Hike.php renderTable()
//// $html .= "		<input type=\"hidden\" data-id=\"".$ADK_PEAK->id."\" data-name=\"".$ADK_PEAK->name."\" data-date=\"".$ADK_PEAK->datetime."\" data-height=\"".$ADK_PEAK->height."\" />";