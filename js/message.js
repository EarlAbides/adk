$(document).ready(function(){

    //Send message
    if(document.getElementById('hidden_newMessage')){
        //Show New Message
        var template_newMessageHTML = document.getElementById('template_newMessage').innerHTML;
        document.getElementById('div_messages_main').innerHTML = template_newMessageHTML;
        $('#downloader').downloader({desc: true});

        populateNewMessage();
    }

    //Message table links
    bind_messagesClick();

    //Sort
    $('.messageSort').click(function(){sortMessages(this);});

    //select_to_username bind
    $('#select_to_username').change(function(){
        document.getElementById('hidden_touserid').value = this.value;
    });

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
	
    var replyText = '\r\n\r\n\r\n---------------------\r\n';
    replyText += 'From: ' + fromName + '\r\n';
    replyText += 'To: ' + toName + '\r\n';
    replyText += 'Date: ' + dte + '\r\n\r\n';
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
}

function cancelMessage(){document.getElementById('div_messages_main').innerHTML = '';}

function message_markRead(ADK_MESSAGE_ID, span){
    if(document.getElementById('h4_folderName').innerHTML == 'Inbox'){
        $.post('includes/ajax_messageMarkRead', {ADK_MESSAGE_ID: ADK_MESSAGE_ID},
            function(){if(span) span.classList.remove('font-bold');}
        );
        var badge = document.getElementById('span_messages').children[0];
        if(badge){
            badge.innerHTML = parseInt(badge.innerHTML) - 1;
            if(badge.innerHTML == 0) badge.outerHTML = '';
        }
    }
}

function viewMessage(ADK_MESSAGE_ID){
    var div_messages_main = document.getElementById('div_messages_main');
    $.post('includes/ajax_getMessage', {ADK_MESSAGE_ID: ADK_MESSAGE_ID},
        function(ret){
            div_messages_main.innerHTML = '';

            div_messages_main.innerHTML = document.getElementById('template_viewMessage').innerHTML;

            var ADK_MESSAGE = JSON.parse(ret);
            
            //Message
            document.getElementById('span_messagefromusername').innerHTML = ADK_MESSAGE.ADK_MESSAGE_FROM_NAME + ' (' + ADK_MESSAGE.ADK_MESSAGE_FROM_USERNAME + ')';
            document.getElementById('span_messagetousername').innerHTML = ADK_MESSAGE.ADK_MESSAGE_TO_NAME + ' (' + ADK_MESSAGE.ADK_MESSAGE_TO_USERNAME + ')';
            document.getElementById('span_messagesubject').innerHTML = ADK_MESSAGE.ADK_MESSAGE_TITLE;
            document.getElementById('span_messagedte').innerHTML = ADK_MESSAGE.ADK_MESSAGE_DTE + '&nbsp;' + ADK_MESSAGE.ADK_MESSAGE_TME;
            document.getElementById('span_messagecontent').innerHTML = ADK_MESSAGE.ADK_MESSAGE_CONTENT;
            document.getElementById('hidden_viewmessageid').value = ADK_MESSAGE.ADK_MESSAGE_ID;
            document.getElementById('hidden_viewfromid').value = ADK_MESSAGE.ADK_MESSAGE_FROM_USER_ID;
            document.getElementById('hidden_viewtoid').value = ADK_MESSAGE.ADK_MESSAGE_TO_USER_ID;

            //Reply button
            if(ADK_MESSAGE.ADK_MESSAGE_FROM_USER_ID === 1) document.getElementById('button_reply').style.display = 'none';
			else document.getElementById('button_reply').style.display = '';

            //Attachments
            var ul_messageattachments = document.getElementById('ul_messageattachments');
            if(ADK_MESSAGE.ADK_FILES !== ''){
                var html = '', files = ADK_MESSAGE.ADK_FILES;
                for(var i = 0; i < files.length; i++){
                    html += '<li><a class="pointer hoverbtn" data-id="' + files[i].ADK_FILE_ID + '" data-desc="' + files[i].ADK_FILE_DESC + 
                        '" data-size="' + files[i].ADK_FILE_SIZE + '" onclick="getFile(' + files[i].ADK_FILE_ID + ');">' + 
                        files[i].ADK_FILE_NAME + '</a></li>';
                }
                ul_messageattachments.innerHTML = html;
            }
            else ul_messageattachments.innerHTML = '<li style="font-style:italic;">none</li>';

            //Correspondent Log Hike
            var a_loghike = document.getElementById('a_loghike');
            if(a_loghike){
                if(!ADK_MESSAGE.isFromHiker) a_loghike.style.display = 'none';
                else a_loghike.setAttribute('href', './hiker?_=' + ADK_MESSAGE.ADK_MESSAGE_FROM_USER_ID + '&m=' + ADK_MESSAGE.ADK_MESSAGE_ID);
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
    $.post('includes/ajax_messageGetFolder', {ADK_USER_ID: document.getElementById('hidden_userid').value, id: id},
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
        }
    );
}

function bind_messagesClick(){
    $('a.messagebtn').click(
        function(){
			if(document.getElementById('h4_folderName').innerHTML === 'Drafts') openDraft(this.getAttribute('data-id'));
            else{
				message_markRead(this.getAttribute('data-id'), this.children[1].children[0].children[0].children[0]);
				viewMessage(this.getAttribute('data-id'));
			}
        }
    );
}

function openDraft(ADK_MESSAGE_ID){
    newMessage();
	$.post('includes/ajax_getMessage', {ADK_MESSAGE_ID: ADK_MESSAGE_ID},
        function(ret){
            var ADK_MESSAGE = JSON.parse(ret);

			if(document.getElementById('hidden_usergroupcde').value !== 'HIK') document.getElementById('select_to_username').value = ADK_MESSAGE.ADK_MESSAGE_TO_USER_ID;
			document.getElementById('textbox_subject').value = ADK_MESSAGE.ADK_MESSAGE_TITLE;
			document.getElementById('textbox_message').value = ADK_MESSAGE.ADK_MESSAGE_CONTENT;
            
            //Attachments
            var ul_messageattachments = document.getElementById('ul_messageattachments');
            if(ADK_MESSAGE.ADK_FILES !== ''){
                var html = '', files = ADK_MESSAGE.ADK_FILES;
                for(var i = 0; i < files.length; i++){
                    html += '<li><a class="pointer hoverbtn" data-id="' + files[i].ADK_FILE_ID + '" data-desc="' + files[i].ADK_FILE_DESC + 
                        '" data-size="' + files[i].ADK_FILE_SIZE + '" onclick="getFile(' + files[i].ADK_FILE_ID + ');">' + 
                        files[i].ADK_FILE_NAME + '</a></li>';
                }
                ul_messageattachments.innerHTML = html;
            }

			//Mark as draft
			var hidden_wasDraft = document.createElement('input'), form = document.getElementById('form_newMessage')
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

    $.post('includes/ajax_messageDelete.php',
        {
            id: document.getElementById('hidden_viewmessageid').value,
            tofrom: h4_folderName.innerHTML === 'Sent'? 's': 'i'
        },
        function(){
            if(document.getElementById('h4_folderName').innerHTML === 'Sent') getFolder(1);
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
	html += '<div style="font-size:16px;float:right;"><a href="#" style="text-decoration:none;" onclick="a(0)" title="Zoom out">-</a>&nbsp;|&nbsp;<a href="#" style="text-decoration:none;" onclick="a(1)" title="Zoom in">+</a><br /></div>';
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