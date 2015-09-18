$(document).ready(function(){
    
    //Anti-Bootstrap
    $('.dropdown-menu').click(function(e){//This will prevent the event from bubbling up and close the dropdown when you type/click on text boxes.
        e.stopPropagation();
    });
    var img_adklogo = document.getElementById('img_adklogo');
    var img_adklogo_top = $(img_adklogo).position().top;

    //Parallax scrolling effect
    $('.parallax').each(function(){
        $div = $(this);
        $(window).scroll(function(){
            var yPos = -($(window).scrollTop() / 4) - 35;
            $div.css({ backgroundPosition: '0 '+ yPos + 'px'});
        });
    });
    
    //Apply active class on subnavbar
    (function(){
        var page = window.location.href.split('/').pop();
        $('.navbar-sub li').each(function(){
            switch(page){
                case '': case '#':
                    if(this.getAttribute('data-name') == 'home'){
                        this.classList.add('active');
                        this.innerHTML += '<span class="sr-only">(current)</span>';
                    }
                    break;
                case 'signup':
                    if(this.getAttribute('data-name') == 'signup'){
                        this.classList.add('active');
                        this.innerHTML += '<span class="sr-only">(current)</span>';
                    }
                    break;
                //default: alert('adk.js, Neil. Fix it');
            }
        });
    })();

	//Tooltips
	tooltip();

	//Carousel header images
	setInterval(function(){
		var div_logo = document.getElementById('div_logo')
			,files = div_logo.getAttribute('data-ids').split(',');
		var file = files[Math.floor(Math.random() * files.length)];
		$(div_logo).fadeOut(1000, function(){
			$(this).css('background-image','url(img/bg/' + file + ')').fadeIn(2500);
		});
	}, 30000);

});

function tooltip(){$('[data-toggle="tooltip"]').tooltip();}

function showHide_content(span, div){
    if(div.classList.contains('content-max')){
        div.className = div.className.replace('content-max', 'content-min');
        span.className = span.className.replace('glyphicon-chevron-down', 'glyphicon-chevron-up');
    }
    else{
        div.className = div.className.replace('content-min', 'content-max');
        span.className = span.className.replace('glyphicon-chevron-up', 'glyphicon-chevron-down');
    }
}

function getXhr(){
    var xhr;
    if(window.XMLHttpRequest) xhr = new XMLHttpRequest();
    else xhr = new ActiveXObject("Microsoft.XMLHTTP");//Old IE
    return xhr;
}

function getFile(id){
    document.getElementById('hidden_fileid').value = id;
    document.getElementById('button_download').click();
}

//Shim for Element.classList for IE<10
"document"in self&&("classList"in document.createElement("_")?!function(){"use strict";var t=document.createElement("_");if(t.classList.add("c1","c2"),!t.classList.contains("c2")){var e=function(t){var e=DOMTokenList.prototype[t];DOMTokenList.prototype[t]=function(t){var n,i=arguments.length;for(n=0;i>n;n++)t=arguments[n],e.call(this,t)}};e("add"),e("remove")}if(t.classList.toggle("c3",!1),t.classList.contains("c3")){var n=DOMTokenList.prototype.toggle;DOMTokenList.prototype.toggle=function(t,e){return 1 in arguments&&!this.contains(t)==!e?e:n.call(this,t)}}t=null}():!function(t){"use strict";if("Element"in t){var e="classList",n="prototype",i=t.Element[n],s=Object,r=String[n].trim||function(){return this.replace(/^\s+|\s+$/g,"")},o=Array[n].indexOf||function(t){for(var e=0,n=this.length;n>e;e++)if(e in this&&this[e]===t)return e;return-1},a=function(t,e){this.name=t,this.code=DOMException[t],this.message=e},c=function(t,e){if(""===e)throw new a("SYNTAX_ERR","An invalid or illegal string was specified");if(/\s/.test(e))throw new a("INVALID_CHARACTER_ERR","String contains an invalid character");return o.call(t,e)},l=function(t){for(var e=r.call(t.getAttribute("class")||""),n=e?e.split(/\s+/):[],i=0,s=n.length;s>i;i++)this.push(n[i]);this._updateClassName=function(){t.setAttribute("class",this.toString())}},u=l[n]=[],f=function(){return new l(this)};if(a[n]=Error[n],u.item=function(t){return this[t]||null},u.contains=function(t){return t+="",-1!==c(this,t)},u.add=function(){var t,e=arguments,n=0,i=e.length,s=!1;do t=e[n]+"",-1===c(this,t)&&(this.push(t),s=!0);while(++n<i);s&&this._updateClassName()},u.remove=function(){var t,e,n=arguments,i=0,s=n.length,r=!1;do for(t=n[i]+"",e=c(this,t);-1!==e;)this.splice(e,1),r=!0,e=c(this,t);while(++i<s);r&&this._updateClassName()},u.toggle=function(t,e){t+="";var n=this.contains(t),i=n?e!==!0&&"remove":e!==!1&&"add";return i&&this[i](t),e===!0||e===!1?e:!n},u.toString=function(){return this.join(" ")},s.defineProperty){var h={get:f,enumerable:!0,configurable:!0};try{s.defineProperty(i,e,h)}catch(g){-2146823252===g.number&&(h.enumerable=!1,s.defineProperty(i,e,h))}}else s[n].__defineGetter__&&i.__defineGetter__(e,f)}}(self));