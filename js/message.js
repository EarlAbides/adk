$(document).ready(function(){

    //Send message from hiker profile screen
    if(document.getElementById('hidden_newMessage')){
        var template_newMessageHTML = document.getElementById('template_newMessage').innerHTML;
        document.getElementById('div_messages_main').innerHTML = template_newMessageHTML;
        $('#downloader').downloader({desc: true});

        populateNewMessage();
		initEditor();
    }

    //Message table links
    bind_messagesClick();

    //Sort
    $('.messageSort').click(function(){sortMessages(this);});

	//filter
	$('#div_table_messages').on('click', '.message-filter a', function(){
		if(this.className.indexOf('active') !== -1) return;

		$('.message-filter a.active').removeClass('active');
		this.classList.add('active');

		var filterBy;
		if(this.className.indexOf('unread') !== -1) filterBy = 1;
		else if(this.className.indexOf('read') !== -1) filterBy = 2;

		if(!filterBy) $('#table_messages tr').css('display', 'table-row');
		else{
			$('#table_messages tr').each(function(){
				if(filterBy === 1) this.style.display = this.getAttribute('data-isread') === 'true'? 'none': 'table-row';
				else this.style.display = this.getAttribute('data-isread') === 'true'? 'table-row': 'none';
			});
		}
		$('#table_messages tr:visible').each(function(i){
			if(i % 2 === 0) this.style['background-color'] = '#ededed';
			else this.style['background-color'] = '#dce1f9';
		});
	});

    //select_to_username bind
    $('#select_to_username').change(function(){
        document.getElementById('hidden_touserid').value = this.value;
    });

	//template dd click
	bindTemplates();
	$(document).on('click', '.saveTemplate', function(){
		saveTemplate(this.className.indexOf('private') > -1);
	});

	//template update
	$(document).on('click', '#button_updateTemplate', function(){
		if(editor.composer.element.innerHTML !== '' && editor.composer.element.innerHTML !== 'Message' && document.getElementById('textbox_subject').value !== ''){
			if($.fn.downloader.getFileIndex().indexOf('0') > -1){
				var ADK_MSG_TMPL_ID = $(this).data('id')
				$.post('includes/templateUpdate.php', {
					ADK_MSG_TMPL_ID: ADK_MSG_TMPL_ID
					,ADK_MSG_TMPL_NAME: document.getElementById('textbox_subject').value
					,ADK_MSG_TMPL_CONTENT: editor.composer.element.innerHTML
				})
				.done(function(ret){
					var ADK_MSG_TMPLS = JSON.parse(ret);
					populateTemplateList(ADK_MSG_TMPLS);
					bindTemplates();
					cancelMessage();
					if(lsTest()) localStorage.removeItem('msg' + ADK_MSG_TMPL_ID);
				})
				.fail(function(ret){
					alert('There was an error updating the template: ' + ret);
				});
			}
		}
	});

	//template delete
	$(document).on('click', '#button_deleteTemplate', function(){
		$.post('includes/templateDelete.php', {id: $(this).data('id')})
		.done(function(ret){
			refreshTemplateList(ret);
		})
		.fail(function(ret){
			alert('There was an error deleting the template: ' + ret);
		});
	});

	function refreshTemplateList(ret){
		var ADK_MSG_TMPLS = JSON.parse(ret);
		populateTemplateList(ADK_MSG_TMPLS);
		bindTemplates();
		document.getElementById('textbox_subject').value = '';
		$(editor.composer.element).empty();
		document.getElementById('button_updateTemplate').style.display = 'none';
		document.getElementById('button_deleteTemplate').style.display = 'none';
	}

	//message sent notice
	if($_GET('m')){
		var $notify;
		switch($_GET('m')){
			case 's':
				$notify = $('<span class="font-italic error message-notify message-notify-sent">Message sent successfully</span>');
				break;
		}
		$('.content-wrapper').prepend($notify);
		$('#table_messages, .messages-menu a, .messages-menu input, .messages-menu button').one('click', function(){$notify.remove();});
	}

});

function populateNewMessage(){
    var ADK_USERGROUP_CDE = document.getElementById('hidden_usergroupcde').value;
    switch(ADK_USERGROUP_CDE){
        case 'ADM':
            var toID = document.getElementById('hidden_touserid').value;
            document.getElementById('select_to_username').value = toID;
            break;
        case 'COR':
            var toID = document.getElementById('hidden_touserid').value;
            document.getElementById('select_to_username').value = toID;
            break;
        case 'HIK':
            var toName = document.getElementById('hidden_tousername').value;
            var toUsername = document.getElementById('hidden_touserusername').value;
            document.getElementById('textbox_to_username').value = toName + ' (' + toUsername + ')';
            break;
    }
}

function newMessage(){
	destroyEditor();
	var template_newMessageHTML = document.getElementById('template_newMessage').innerHTML;
    document.getElementById('div_messages_main').innerHTML = template_newMessageHTML;
    $('#downloader').downloader({desc: true});

    if(document.getElementById('hidden_usergroupcde').value === 'HIK'){
        var toID = document.getElementById('hidden_coruserid').value;
        var toName = document.getElementById('hidden_corusername').value;
        var toUsername = document.getElementById('hidden_coruserusername').value;
        var toEmail = document.getElementById('hidden_coruseremail').value;
        document.getElementById('hidden_touserid').value = toID;
        document.getElementById('hidden_touseremail').value = toEmail;
        document.getElementById('textbox_to_username').value = toName + ' (' + toUsername + ')';
    }
    else{
        var select_to_username = document.getElementById('select_to_username');
        select_to_username.disabled = false;
        document.getElementById('hidden_touserid').value = document.getElementById('select_to_username').children[0].value;
        $(select_to_username).change(function(){document.getElementById('hidden_touserid').value = this.value;});
    }

	initEditor();
}

function reply(){
	var fromID = document.getElementById('hidden_viewfromid').value;
    var fromName = document.getElementById('span_messagefromusername').innerHTML;
    var toID = document.getElementById('hidden_viewfromid').value;
    var toName = document.getElementById('span_messagetousername').innerHTML;
    var subject = document.getElementById('span_messagesubject').innerHTML;
    var dte = document.getElementById('span_messagedte').innerHTML;
    var message = document.getElementById('span_messagecontent').innerHTML;
    if(fromID == document.getElementById('hidden_userid').value){//Switch if sent
        var tmp = toID; toID = fromID; fromID = tmp;
    }
    
    //var replyFiles = [];
    //var ul_messageattachments = document.getElementById('ul_messageattachments');
    //if(ul_messageattachments.innerHTML !== '<li style="font-style:italic;">none</li>'){
    //    for(var i = 0; i < ul_messageattachments.children.length; i++){
    //        replyFiles.push({
    //            id: ul_messageattachments.children[i].children[0].getAttribute('data-id'),
    //            html: ul_messageattachments.children[i].outerHTML
    //        });
    //    }
    //}
	
    var replyText = '<br /><br /><br />---------------------<br />';
    replyText += 'From: ' + fromName + '<br />';
    replyText += 'To: ' + toName + '<br />';
    replyText += 'Date: ' + dte + '<br /><br />';
    replyText += message;

	var template_newMessageHTML = document.getElementById('template_newMessage').innerHTML;
    document.getElementById('div_messages_main').innerHTML = template_newMessageHTML;
    $('#downloader').downloader({desc: true});
    
    if(document.getElementById('hidden_usergroupcde').value == 'HIK')
        document.getElementById('textbox_to_username').value = toName;
    else{
        var select_to_username = document.getElementById('select_to_username');
        select_to_username.disabled = true;
        select_to_username.value = toID;
        $(select_to_username).change(function(){document.getElementById('hidden_touserid').value = this.value;});
    }

    document.getElementById('legend_newMessageReply').innerHTML = 'Reply';
    document.getElementById('textbox_subject').value = 'RE: ' + subject;
    document.getElementById('textbox_message').value = replyText;
    //if(replyFiles.length !== 0){
    //    var ul_messageattachments = document.getElementById('ul_messageattachments');
    //    var replyfileids = [];
    //    for(var i = 0; i < replyFiles.length; i ++){
    //        replyfileids.push(replyFiles[i].id);
    //        ul_messageattachments.innerHTML += replyFiles[i].html;
    //    }
    //    document.getElementById('hidden_replyfileids').value = replyfileids.join(',');
    //}
    
    document.getElementById('hidden_touserid').value = toID;

	initEditor();
}

function cancelMessage(){document.getElementById('div_messages_main').innerHTML = '';destroyEditor();}

function message_markRead(ADK_MESSAGE_ID, span, tr){
    if(document.getElementById('h4_folderName').innerHTML.indexOf('Inbox') !== -1){
        $.post('includes/messageMarkRead', {ADK_MESSAGE_ID: ADK_MESSAGE_ID},function(){
			if(span) span.classList.remove('font-bold');
			if(tr) tr.setAttribute('data-isread', 'true');
		});
        var badge = document.getElementById('span_messages').children[0];
        if(badge){
            badge.innerHTML = parseInt(badge.innerHTML) - 1;
            if(badge.innerHTML == 0) badge.outerHTML = '';
        }
    }
}

function viewMessage(ADK_MESSAGE_ID){
    if(typeof editor !== 'undefined') editor.destroy();
	var div_messages_main = document.getElementById('div_messages_main');
    $.post('includes/messageGet.php', {ADK_MESSAGE_ID: ADK_MESSAGE_ID},
        function(ret){
            div_messages_main.innerHTML = '';

            div_messages_main.innerHTML = document.getElementById('template_viewMessage').innerHTML;

            var ADK_MESSAGE = JSON.parse(ret);
            
            //Message
            document.getElementById('span_messagefromusername').innerHTML = ADK_MESSAGE.fromname + ' (' + ADK_MESSAGE.fromusername + ')';
            document.getElementById('span_messagetousername').innerHTML = ADK_MESSAGE.toname + ' (' + ADK_MESSAGE.tousername + ')';
            document.getElementById('span_messagesubject').innerHTML = ADK_MESSAGE.title;
            document.getElementById('span_messagedte').innerHTML = ADK_MESSAGE.date + '&nbsp;' + ADK_MESSAGE.time;
            document.getElementById('span_messagecontent').innerHTML = ADK_MESSAGE.content;
            document.getElementById('hidden_viewmessageid').value = ADK_MESSAGE.id;
            document.getElementById('hidden_viewfromid').value = ADK_MESSAGE.fromid;
            document.getElementById('hidden_viewtoid').value = ADK_MESSAGE.toid;

            //Reply button
            if(ADK_MESSAGE.fromid === 1) document.getElementById('button_reply').style.display = 'none';
			else document.getElementById('button_reply').style.display = '';

            //Attachments
            var ul_messageattachments = document.getElementById('ul_messageattachments');
            if(ADK_MESSAGE.files !== ''){
                var html = '', files = ADK_MESSAGE.files;
                for(var i = 0; i < files.length; i++){
                    html += '<li><a class="pointer hoverbtn" data-id="' + files[i].id + '" data-desc="' + files[i].desc + 
                        '" data-size="' + files[i].size + '" onclick="getFile(' + files[i].id + ');">' + 
                        files[i].name + '</a></li>';
                }
                ul_messageattachments.innerHTML = html;
            }
            else ul_messageattachments.innerHTML = '<li style="font-style:italic;">none</li>';

            //Correspondent Log Hike
            var a_loghike = document.getElementById('a_loghike');
            if(a_loghike){
                if(!ADK_MESSAGE.isfromhiker) a_loghike.style.display = 'none';
                else a_loghike.setAttribute('href', './hiker?_=' + ADK_MESSAGE.fromid + '&m=' + ADK_MESSAGE.id);
            }
        }
    );
}

function sortMessages(button){
    //Class changes
    if(button.nextElementSibling){button.classList.add('active'); button.nextElementSibling.classList.remove('active');}
    else{button.classList.add('active'); button.previousElementSibling.classList.remove('active');}

    //Get sortBy, sortDir
    var buttons = document.querySelectorAll('.messageSort');
    if(buttons[0].classList.contains('active')) var sortBy = 'n';
    else var sortBy = 'd';
    if(buttons[2].classList.contains('active')) var sortDir = 'u';
    else var sortDir = 'd';

    //Get messages
    var messages = [];
    var table_messages = document.getElementById('table_messages').children[1];
    for(var i = 0; i < table_messages.children.length; i++)
        messages.push({i: i, n: table_messages.children[i].getAttribute('data-name'), d: table_messages.children[i].getAttribute('data-date')});

    //Sort
    function name_comparer(a, b){
        if(a.n < b.n) return -1;
        if(a.n > b.n) return 1;
        return 0;
    }
    function date_comparer(a, b){
        function sanitize_date(d){
            var date_arr = [];
            var date = d.split(' ')[0].split('/');
            var time = d.split(' ')[1].split(':');

            date_arr.push(parseInt(date[2]));
            date_arr.push(parseInt(date[0]));
            date_arr.push(parseInt(date[1]));

            var h = parseInt(time[0]);
            var m = parseInt(time[1].substring(0, 2));
            var ampm = time[1].substring(2, 1); if(ampm == 'p') h += 12;
            date_arr.push(h);
            date_arr.push(m);

            return date_arr;
        }
        var date_a_arr = sanitize_date(a.d), date_b_arr = sanitize_date(b.d);
        var date_a = new Date(date_a_arr[0], date_a_arr[1], date_a_arr[2], date_a_arr[3], date_a_arr[4]),
            date_b = new Date(date_b_arr[0], date_b_arr[1], date_b_arr[2], date_b_arr[3], date_b_arr[4]);
        if(date_a < date_b) return -1;
        if(date_a > date_b) return 1;
        return 0;
    }
    
    if(sortBy == 'n') messages.sort(name_comparer);
    else messages.sort(date_comparer);
    if(sortDir == 'd') messages.reverse();

    if(sortBy == 'n') var attr = 'data-name';
    else var attr = 'data-date';
    var sortedMessages = '';
    for(var i = 0; i < messages.length; i++){
        if(sortBy == 'n') var z = messages[i].n; else var z = messages[i].d;
        for(var j = 0; j < table_messages.children.length; j++){
            if(z == table_messages.children[j].getAttribute(attr)){
                sortedMessages += table_messages.children[j].outerHTML;
                table_messages.children[j].outerHTML = '';
                j--;
                break;
            }
        }
    }

    table_messages.innerHTML = sortedMessages;
    bind_messagesClick();
}

function getFolder(id){
    $.post('includes/messageGetFolder', {id: id},
        function(ret){
            document.getElementById('div_table_messages').innerHTML = ret;
            bind_messagesClick();

            var buttons = document.querySelectorAll('.messageSort');
            buttons[0].classList.remove('active'); buttons[1].classList.add('active');
            buttons[2].classList.remove('active'); buttons[3].classList.add('active');

            switch(id){
                case 0: document.getElementById('button_sortFromTo').innerHTML = 'From'; break;
                case 1: case 2: document.getElementById('button_sortFromTo').innerHTML = 'To'; break;
            }

			$('.folder').removeClass('active').eq(id).addClass('active');
        }
    );
}

function bind_messagesClick(){
    $('a.messagebtn').click(function(){
		if(document.getElementById('h4_folderName').innerHTML.indexOf('Drafts') !== -1) openDraft(this.getAttribute('data-id'));
        else{
			message_markRead(this.getAttribute('data-id'), this.children[1].children[0].children[0].children[0], this.parentNode.parentNode);
			viewMessage(this.getAttribute('data-id'));
		}
		
    });
}

function openDraft(ADK_MESSAGE_ID){
    newMessage();
	$.post('includes/messageGet', {ADK_MESSAGE_ID: ADK_MESSAGE_ID},
        function(ret){
            var ADK_MESSAGE = JSON.parse(ret);

			if(document.getElementById('hidden_usergroupcde').value !== 'HIK') document.getElementById('select_to_username').value = ADK_MESSAGE.toid;
			document.getElementById('textbox_subject').value = ADK_MESSAGE.title;
			
			var wysiIframeBody = getWysiIframeBody();
			if(wysiIframeBody) wysiIframeBody.innerHTML = ADK_MESSAGE.content;
			else document.getElementById('textbox_message').value = ADK_MESSAGE.content;
            
            //Attachments
            var ul_messageattachments = document.getElementById('ul_messageattachments');
            if(ADK_MESSAGE.files.length){
                var html = '', files = ADK_MESSAGE.files;
                for(var i = 0; i < files.length; i++){
                    html += '<li><a class="pointer hoverbtn" data-id="' + files[i].id + '" data-desc="' + files[i].desc + 
                        '" data-size="' + files[i].size + '" onclick="getFile(' + files[i].id + ');">' + 
                        files[i].name + '</a></li>';//TODO: fix this
                }
                ul_messageattachments.innerHTML = html;
            }

			//Mark as draft
			var hidden_wasDraft = document.createElement('input')
				,form = document.getElementById('form_newMessage')
				,hidden_messageid = document.createElement('input');

			hidden_wasDraft.setAttribute('type', 'hidden');
			hidden_wasDraft.setAttribute('name', 'wasdraft');
			hidden_wasDraft.value = 'true';
			hidden_messageid.setAttribute('type', 'hidden');
			hidden_messageid.setAttribute('name', 'messageid');
			hidden_messageid.value = ADK_MESSAGE_ID;
			form.appendChild(hidden_wasDraft);
			form.appendChild(hidden_messageid);
        }
    );
}

function loadModal_viewMessage(){
    document.getElementById('h4_modal_viewMessage').innerHTML = document.getElementById('span_messagesubject').innerHTML;
    document.getElementById('span_modal_viewMessage_dte').innerHTML = document.getElementById('span_messagedte').innerHTML;
    document.getElementById('span_modal_viewMessage_message').innerHTML = document.getElementById('span_messagecontent').innerHTML;
}

function deleteMessage(){
    if(!confirm('Are you sure you want to delete this message?')) return false;

    var h4_folderName = document.getElementById('h4_folderName');

    $.post('includes/messageDelete.php',
        {
            id: document.getElementById('hidden_viewmessageid').value,
            tofrom: h4_folderName.innerHTML === 'Sent'? 's': 'i'
        },
        function(){
            if(document.getElementById('h4_folderName').innerHTML.indexOf('Sent') !== -1) getFolder(1);
            else getFolder(0);
            newMessage();
        }
    );
}

function printView(){
	var fromusername = document.getElementById('span_messagefromusername').innerHTML
		,tousername = document.getElementById('span_messagetousername').innerHTML
		,subject = document.getElementById('span_messagesubject').innerHTML
		,dte = document.getElementById('span_messagedte').innerHTML
		,content = document.getElementById('span_messagecontent').innerHTML;

	var newWindow = window.open();

	var fontSizeScript = "<script>function a(d){var b=document.body.style.fontSize? parseInt(document.body.style.fontSize.replace(/\D/g,'')):100;if(b>=50&&b<=150){if(d)b+=10;else b-=10;}if(b<50)b=50;if(b>150)b=150;document.body.style.fontSize=b+'%';}</script>";

	var html = '<h3 style="margin-bottom:8px;text-align:center;">The Adirondack Forty-Sixers';
	html += '<div class="noprint" style="font-size:16px;float:right;"><a href="#" style="text-decoration:none;" onclick="a(0)" title="Zoom out">-</a>&nbsp;|&nbsp;<a href="#" style="text-decoration:none;" onclick="a(1)" title="Zoom in">+</a><br /></div>';
	html += '</h3>';

	html += '<img src="img/letterhead.png" style="height:70px;float:right;margin-right:10%;" onload="window.print()" />';

	html += '';
	html += '<span>From: ' + fromusername + '</span><br />';
	html += '<span>To: ' + tousername + '</span><br />';
	html += '<span>Subject: ' + subject + '</span><br />';
	html += '<span>Date: ' + dte + '</span><br />';
	html += '----------------------------------------<br /><br />';
	html += '<pre style="word-break:break-word;">' + content + '</pre>';

	newWindow.document.write(fontSizeScript + html);
}

function saveDraft(){
	var hidden_draft = document.createElement('input'), form = document.getElementById('form_newMessage');
	hidden_draft.setAttribute('type', 'hidden');
	hidden_draft.setAttribute('name', 'draft');
	hidden_draft.value = 'true';
	form.appendChild(hidden_draft);
	form.submit();
}

function saveTemplate(isPrivate){
	if(editor.composer.element.innerHTML !== '' && editor.composer.element.innerHTML !== 'Message' && document.getElementById('textbox_subject').value !== ''){
		if($.fn.downloader.getFileIndex().indexOf('0') > -1){
			$.post('includes/templateSave.php', {
				ADK_MSG_TMPL_NAME: document.getElementById('textbox_subject').value
				,ADK_MSG_TMPL_CONTENT: editor.composer.element.innerHTML
				,isPrivate: isPrivate
			})
			.done(function(ret){
				var ADK_MSG_TMPLS = JSON.parse(ret);
				populateTemplateList(ADK_MSG_TMPLS);
				bindTemplates();
				document.getElementById('textbox_subject').value = '';
				$(editor.composer.element).empty();
				document.getElementById('button_deleteTemplate').style.display = 'none';
			})
			.fail(function(ret){
				alert('Error saving template: ' + ret);
			});
		}
	}
}

function showTemplate(template){
	destroyEditor();
	var template_newMessageHTML = document.getElementById('template_newMessage').innerHTML;
	document.getElementById('div_messages_main').innerHTML = template_newMessageHTML;
	$('#downloader').downloader({desc: true});
	document.getElementById('textbox_subject').value = template.name;
	document.getElementById('textbox_message').value = template.content;
	$('#button_updateTemplate, #button_deleteTemplate').each(function(){
		this.style.display = 'inline-block';
		this.setAttribute('data-id', template.id);
	});
	initEditor();
}

function pasteTemplate(template){
	var textbox_subject = document.getElementById('textbox_subject');
	if(!textbox_subject){
		newMessage();
		textbox_subject = document.getElementById('textbox_subject');
	}
	if(textbox_subject.value === '') textbox_subject.value = template.name;
	var element = editor.composer.element;
	if(element.innerHTML === 'Message') element.innerHTML = '';
	element.innerHTML += template.content;
}

function bindTemplates(){
	$('.template-edit').on('click', function(){
		var template = getTemplate($(this).data('id'), showTemplate);
	});
	$('.template-paste').on('click', function(){
		var template = getTemplate($(this).data('id'), function(template){
			pasteTemplate(template);
		});
	});
}

function getTemplate(id, callback){
	$('#templates_dropdown').parent().removeClass('open');
	var hasLs = lsTest();
	if(hasLs && localStorage.getItem('msg' + id)) callback(JSON.parse(localStorage.getItem('msg' + id)));
	else{
		$.get('includes/templateGet.php?_=' + id)
		.done(function(ret){
			var template = JSON.parse(ret);
			if(hasLs) localStorage.setItem('msg' + template.id, ret);
			callback(template);
		})
		.fail(function(ret){
			alert('Error getting folder: ' + ret);
		});
	}
}

function populateTemplateList(ADK_MSG_TMPLS){
	function makeLi(template){
		var $li = $('<li>'), $a = $('<a>');
		var $open = $('<span class="pointer hoverbtn template template-edit" data-id="' + template.id + '" title="Open" data-toggle="tooltip" data-container="body">');
		var $openIcon = $('<span class="glyphicon glyphicon-pencil"></span>');
		var $paste = $('<span class="pointer hoverbtn template template-paste" data-id="' + template.id + '" title="Paste into Message" data-toggle="tooltip" data-container="body">');
		var $pasteIcon = $('<span class="glyphicon glyphicon-paste"></span>');
		var $name = $('<span>' + template.name + '</span>');
		$open.append($openIcon);
		$paste.append($pasteIcon);
		$a.append($open, $paste, $name);
		$li.append($a);
		return $li;
	}

	$('#ul_templates li').each(function(){
		if(this.children.length && this.children[0].children.length){
			if(this.children[0].children[0].className.indexOf('template') !== -1) this.parentNode.removeChild(this);
		}
	});

	var $last = $('.dropdown-header-public');
	ADK_MSG_TMPLS.public.forEach(function(ADK_MSG_TMPL){
		var $li = makeLi(ADK_MSG_TMPL);
		$last.after($li);
		$last = $li;
	});
	$last = $('.dropdown-header-private');
	ADK_MSG_TMPLS.private.forEach(function(ADK_MSG_TMPL){
		var $li = makeLi(ADK_MSG_TMPL);
		$last.after($li);
		$last = $li;
	});
}

function destroyEditor(){
	if(typeof editor !== 'undefined'){
		try{editor.destroy();} catch(e){}
	}
}

var editor;
function initEditor(){
	editor = new wysihtml5.Editor('textbox_message', {
		toolbar: 'wysihtml-toolbar'
		,parserRules: wysihtml5ParserRules
		,stylesheets: 'css/wysihtml.css'
	});
}