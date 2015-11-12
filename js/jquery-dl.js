(function($){
	$.fn.downloader = function(_options){
		
		//Exit on empty
		if(!this.length) return;

		//Functions
		$.fn.downloader.makeFileInput = function(){
			var fileId = $.fn.downloader.getFileIndex();
			var newFileInput = document.createElement('input');
			newFileInput.setAttribute('type', 'file');
			newFileInput.setAttribute('id', fileId);
			newFileInput.setAttribute('name', fileId + '[]');
			newFileInput.setAttribute('multiple', 'multiple');
			newFileInput.classList.add('fileInput');
			newFileInput.style.cssText = 'display:block;position:absolute;top:0;left:-9999px;';
			
			$.fn.downloader.fileIndex_increment();
			$(newFileInput).on('change', $.fn.downloader.filesAdded);
			return newFileInput;
		};
		$.fn.downloader.updateFileList = function(){
			var table_fileList = document.getElementById('table_fileList');

            if(options.desc){
                //Get descriptions
                var nameDescs = [];
                for(var i = 0; i < table_fileList.children[1].children.length; i++)
                    nameDescs.push({
                        name: table_fileList.children[1].children[i].children[0].children[0].innerHTML,
                        desc: table_fileList.children[1].children[i].children[1].children[0].value
                    });
            }

            table_fileList.children[1].innerHTML = '';
			
			var fileInputs = document.querySelectorAll('.fileInput');
			$.fn.downloader.clearEmpty(fileInputs);
            var fileIndex = 0;
			for(var i = 0; i < fileInputs.length; i++){
				for(var j = 0; j < fileInputs[i].files.length; j++){
					var span_fileName = document.createElement('span');
                    span_fileName.className = 'redhover';
					span_fileName.innerHTML = fileInputs[i].files[j].name;
                    span_fileName.setAttribute('data-inputid', 'file' + i);
                    $(span_fileName).on('click', function(){$.fn.downloader.removeFile(this);});
					
					var td1 = document.createElement('td');
                    td1.appendChild(span_fileName);
                    td1.setAttribute('title', 'Size: ' + $.fn.downloader.bytesToSize(fileInputs[i].files[j].size) + '\nType: ' + fileInputs[i].files[j].type + '\n\nClick to Remove');
					td1.setAttribute('data-toggle', 'tooltip');
					td1.setAttribute('data-container', 'body');
					var tr = document.createElement('tr');
                    tr.appendChild(td1);
                    
                    if(options.desc){
                        var desc = '';
                        for(var k = 0; k < nameDescs.length; k++){
                            if(fileInputs[i].files[j].name == nameDescs[k].name){desc = nameDescs[k].desc; break;} 
                        }

                        var td2 = document.createElement('td');

                        td2.innerHTML = '<input type="text" name="file_' + fileIndex + '_desc" class="' + options.classes.input + '" value="' + desc + '" maxlength="1024" />';
                        tr.appendChild(td2);
                    }
					
					table_fileList.children[1].appendChild(tr);
                    fileIndex++;
				}
			}

            if(table_fileList.children[1].children.length === 0) $('#table_fileList th').css('visibility', 'hidden');
            else $('#table_fileList th').css('visibility', '');

			tooltip();			
		};
		$.fn.downloader.getFileIndex = function(){return 'file' + document.getElementById('hidden_fileIndex').value;};
		$.fn.downloader.fileIndex_increment = function(){
			var hidden_fileIndex = document.getElementById('hidden_fileIndex');
			hidden_fileIndex.value = parseInt(hidden_fileIndex.value) + 1;
		};
		$.fn.downloader.rebind = function(){$('.fileInput').unbind().on('change', function(){$.fn.downloader.filesAdded();});};
		$.fn.downloader.clearEmpty = function(fileInputs){
			if(fileInputs.length){
				for(var i = fileInputs.length - 1; i >= 0; i--){
					if(!fileInputs[i].files.length) $.remove(fileInputs[i]);
				}
				document.getElementById('hidden_fileIndex').value = fileInputs.length;
			}
		};
		$.fn.downloader.addFile = function(){
			$.fn.downloader.clearEmpty(document.querySelectorAll('.fileInput'));
			var input = $.fn.downloader.makeFileInput();
			document.getElementById('div_inputFileWrapper').appendChild(input);
			$.fn.downloader.rebind();
			$(input).click();
		};
		$.fn.downloader.removeFile = function(span){
			function renameFileInputs(){
				var fileInputs = document.getElementsByClassName('fileInput');
				for(var i = 0; i < fileInputs.length; i++){
					fileInputs[i].setAttribute('id', 'file' + i);
					fileInputs[i].setAttribute('name', 'file' + i);
				}
				document.getElementById('hidden_fileIndex').value = i;
			}
			
            var fileInputId = $(span).data('inputid');
			$('#' + fileInputId).remove();
			renameFileInputs();
			var hidden_fileIndex = document.getElementById('hidden_fileIndex');
			$.fn.downloader.updateFileList();
			$.fn.downloader.rebind();

			tooltip();
			if($.fn.downloader.validateTotalFileSize()) document.getElementById('span_fileerror').innerHTML = '';
			if(typeof enableDisable_addHike == 'function') enableDisable_addHike();
		};
		$.fn.downloader.removeAll = function(){
			$('input[id^="file"]').remove();
			document.getElementById('hidden_fileIndex').value = 0;
			$.fn.downloader.updateFileList();
			$.fn.downloader.rebind();

			tooltip();
			if($.fn.downloader.validateTotalFileSize()) document.getElementById('span_fileerror').innerHTML = '';
			if(typeof enableDisable_addHike == 'function') enableDisable_addHike();
		};
		$.fn.downloader.filesAdded = function(){
			if($.fn.downloader.preExists()){
				$.fn.downloader.removeLastAdd();//maybe return filename, show in error
				$.fn.downloader.showError();
			}
			else{
				$.fn.downloader.updateFileList();
				$.fn.downloader.rebind();
			}
			
			if($.fn.downloader.validateTotalFileSize()) document.getElementById('span_fileerror').innerHTML = '';
			if(typeof enableDisable_addHike == 'function') enableDisable_addHike();
		};
		$.fn.downloader.preExists = function(){
			function getNewFileNames(){
				var newFileList = fileInputs[fileInputs.length - 1].files;
				var newFileNames = [];
				for(var i = 0; i < newFileList.length; i++){
					newFileNames[i] = newFileList[i].name;
				}
				return newFileNames;
			}
			
			var fileInputs = document.getElementsByClassName('fileInput');
			var newFileNames = getNewFileNames();
			for(var i = 0; i < fileInputs.length - 1; i++){
				for(var j = 0; j < fileInputs[i].files.length; j++){
					var filename = fileInputs[i].files[j].name;
					if(newFileNames.indexOf(filename) !== -1) return true;
				}
			}
			
			return false;
		};
		$.fn.downloader.validateTotalFileSize = function(){
			var total = 0;
			$('.fileInput').each(function(){
				for(var i = 0; i < this.files.length; i++) total += this.files[i].size;
			});

			if(total >= 98000000){
				$('.jqdl-attachments').each(function(){
					this.classList.add('has-error');
					this.classList.add('has_error');

					var a = document.createElement('a');
					a.innerHTML = '&#8226;';
					var bullet = a.innerHTML;

					var span_fileerror = document.getElementById('span_fileerror');
					if(span_fileerror.innerHTML == '') span_fileerror.innerHTML = '<ul class=\"list-unstyled\"><li>' + bullet + 'Max file size exceeded</li></ul>';
					else span_fileerror.children[0].innerHTML += '<li>' + bullet + 'Max file size exceeded</li>';
					
					$('#downloader button, #downloader .redhover').one('click', function(){
						span_fileerror.innerHTML = '';
						$('.jqdl-attachments').each(function(){this.classList.remove('has-error');});
					});

					$('form, .fileInput').off('change');
				});
				return false;
			}
			return true;
		};
		$.fn.downloader.removeLastAdd = function(){
			var fileInputs = document.getElementsByClassName('fileInput');
			fileInputs[fileInputs.length - 1].value = '';
		};
		$.fn.downloader.showError = function(){alert('File already added');};

		//Globals
		var options = $.extend({
			text: 'Add File',
			clearText: 'Remove All',
            classes: {
                button: 'btn btn-sm btn-default',
                input: 'form-control form-control-sm',
                a: '',
                container: 'container-fluid'
            },
            desc: false
		}, _options );
		
		var _container = this[0];
		var id = _container.id;
		
		//Controls
        _container.className = _container.className + ' ' + options.classes.container;

		var div_btnGroup = document.createElement('div');
        div_btnGroup.className = 'btn-group';
		div_btnGroup.style.display = 'inline-block';
		div_btnGroup.style.width = '100%';
		
		var div_listWrapper = document.createElement('div');
		div_listWrapper.className = 'scroll scroll300';
        div_listWrapper.style['margin-top'] = '4px';
		
		var div_inputFileWrapper = document.createElement('div');
		div_inputFileWrapper.setAttribute('id', 'div_inputFileWrapper');
		div_inputFileWrapper.style.cssText = 'position:relative;overflow:hidden;width:0;';
		
		var table_fileList = document.createElement('table');
		table_fileList.setAttribute('id', 'table_fileList');
        table_fileList.style['font-size'] = '0.8em';
        table_fileList.style['width'] = '100%';
        table_fileList.innerHTML = '<thead><tr><th style="width:50%;visibility:hidden;">File</th><th style="width:50%;visibility:hidden;">Description/Credited to</th></tr></thead><tbody></tbody>';
		
		var hidden_fileIndex = document.createElement('input');
		hidden_fileIndex.setAttribute('type', 'hidden');
		hidden_fileIndex.setAttribute('id', 'hidden_fileIndex');
		hidden_fileIndex.setAttribute('name', 'hidden_fileIndex');
		hidden_fileIndex.value = '0';
		
		var button_addFile = document.createElement('button');
		button_addFile.setAttribute('type', 'button');
		button_addFile.innerHTML = options.text;
		button_addFile.className = options.classes.button;
		$(button_addFile).on('click', function(){$.fn.downloader.addFile();});
		
		var button_removeAll = document.createElement('button');
		button_removeAll.setAttribute('type', 'button');
		button_removeAll.innerHTML = options.clearText;
		button_removeAll.className = options.classes.button;
		$(button_removeAll).on('click', function(){$.fn.downloader.removeAll();});

		var span_fileerror = document.createElement ('span');
		span_fileerror.setAttribute('id', 'span_fileerror');
		span_fileerror.className = 'help-block with-errors';
		
		//Dom changes
        _container.appendChild(hidden_fileIndex);
        _container.appendChild(div_btnGroup);
		_container.appendChild(div_listWrapper);
		_container.appendChild(span_fileerror);
		_container.appendChild(div_inputFileWrapper);
		div_btnGroup.appendChild(button_addFile);
		div_btnGroup.appendChild(button_removeAll);
		div_listWrapper.appendChild(table_fileList);

		return this;
	};
}($));

$.fn.downloader.bytesToSize = function(bytes){
    var sizes = ['bytes', 'KB', 'MB', 'GB', 'TB'];
    if(bytes == 0) return '0 bytes';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + sizes[i];
};