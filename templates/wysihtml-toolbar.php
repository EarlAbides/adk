<?php
//<div id="wysihtml-toolbar" style="display:none;">
	
//    <a data-wysihtml5-command="bold">
//        <span class="glyphicon glyphicon-bold" title="Bold" data-toggle="tooltip"></span>
//    </a>
//    <a data-wysihtml5-command="italic">
//        <span class="glyphicon glyphicon-italic" title="Italic" data-toggle="tooltip"></span>
//    </a>
//    <a data-wysihtml5-command="underline">
//        <span class="glyphicon font-bold" style="font-size:21px;text-decoration:underline;" title="Underline" data-toggle="tooltip">U</span>
//    </a>

//    &nbsp;

//    <a data-wysihtml5-command="justifyLeft">
//        <span class="glyphicon glyphicon-align-left" title="Left" data-toggle="tooltip"></span>
//    </a>
//    <a data-wysihtml5-command="justifyCenter">
//        <span class="glyphicon glyphicon-align-center" title="Center" data-toggle="tooltip"></span>
//    </a>
//    <a data-wysihtml5-command="justifyRight">
//        <span class="glyphicon glyphicon-align-right" title="Right" data-toggle="tooltip"></span>
//    </a>

//    &nbsp;

//    <a data-wysihtml5-command="insertUnorderedList">
//        <span class="glyphicon glyphicon-list" title="Bullet List" data-toggle="tooltip"></span>
//    </a>
//    <a data-wysihtml5-command="insertOrderedList">
//        <span class="glyphicon glyphicon-sort-by-order" title="Ordered List" data-toggle="tooltip"></span>
//    </a>

//    &nbsp;

//    <a class="red" data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red">
//        <span title="Red" data-toggle="tooltip"></span>
//    </a>
//    <a class="green" data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green">
//        <span title="Green" data-toggle="tooltip"></span>
//    </a>
//    <a class="blue" data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue">
//        <span title="Blue" data-toggle="tooltip"></span>
//    </a>

//</div> 
?>

<div id="wysihtml-toolbar" class="input-group" style="display:none;" role="group">

    <button type="button" class="btn btn-sm btn-default" title="Bold" data-wysihtml-command="bold" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(0 2)" fill="#1b2124">
                <path d="M15.232 10.346c-.181-.535-.437-1.005-.767-1.41-.331-.406-.731-.727-1.201-.962-.472-.235-1.002-.355-1.589-.355-.597 0-1.102.118-1.514.354-.412.236-.732.497-.959.777h-.034v-5.25h-2.668v12.764h2.458v-1.099h.032c.26.428.632.757 1.114.987.484.232.996.348 1.541.348.605 0 1.147-.123 1.625-.37.479-.248.883-.578 1.215-.987.328-.412.582-.888.757-1.429.172-.54.26-1.103.26-1.688-.002-.585-.092-1.144-.27-1.68zm-2.425 2.481c-.08.265-.203.499-.365.7-.162.203-.363.367-.602.49-.24.125-.518.187-.832.187-.303 0-.574-.062-.813-.187s-.442-.287-.61-.49c-.168-.201-.298-.434-.39-.69-.093-.26-.139-.524-.139-.795s.045-.533.137-.792c.093-.26.223-.492.39-.693.169-.201.372-.365.61-.488.24-.125.51-.187.813-.187.314 0 .594.062.832.187.237.123.439.283.604.48.162.196.283.426.365.686.08.258.121.521.121.791.002.272-.039.536-.121.801z" fill="#1B2124"></path>
            </g>
        </svg>
    </button>
    <button type="button" class="btn btn-sm btn-default" title="Italic" data-wysihtml-command="italic" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(7 4)" fill="#1b2124">
                <path d="M2.926 14l1.765-8.912h-2.448l-1.743 8.912h2.426z" id="Shape"></path>
                <path d="M5.096.863c-.27-.242-.604-.363-1.007-.363-.401 0-.752.134-1.058.402-.306.268-.456.61-.456 1.029 0 .432.141.765.425 1 .284.237.625.353 1.025.353.418 0 .764-.143 1.049-.431.283-.288.426-.622.426-1 0-.418-.135-.749-.404-.99z"></path>
            </g>
        </svg>
    </button>
    <button type="button" class="btn btn-sm btn-default" title="Underline" data-wysihtml-command="underline" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(6 7)" fill="#1b2124">
                <path d="M9.141-.5h-2.271v4.791c0 .291-.042.578-.132.862-.09.284-.217.535-.387.752-.17.219-.391.397-.662.536-.27.14-.581.209-.934.209-.365 0-.659-.072-.878-.217-.221-.146-.394-.33-.52-.554-.127-.223-.209-.475-.247-.754-.038-.278-.057-.544-.057-.798v-4.827h-2.268v5.444c0 .447.062.882.189 1.306.126.424.324.799.595 1.125.272.327.618.591 1.041.791.422.199.929.299 1.521.299.68 0 1.27-.168 1.768-.499.498-.333.849-.718 1.051-1.153h.037v1.397h2.154v-8.71z"></path>
                <rect y="11" width="11" height=".908"></rect>
            </g>
        </svg>
    </button>

    <button type="button" class="btn btn-sm btn-default" title="Align left" data-wysihtml-command="justifyLeft" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(0 2)" fill="none" stroke="currentColor">
                <path d="M4 5.5h11"></path>
                <path d="M4 7.5h9"></path>
                <path d="M4 9.5h12"></path>
                <path d="M4 11.5h8"></path>
                <path d="M4 13.5h11"></path>
                <path d="M4 15.5h5"></path>
            </g>
        </svg>
    </button>
    <button type="button" class="btn btn-sm btn-default" title="Align center" data-wysihtml-command="justifyCenter" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(0 2)" fill="none" stroke="currentColor">
                <path d="M5 5.5h11"></path>
                <path d="M6 7.5h9"></path>
                <path d="M4 9.5h13"></path>
                <path d="M7 11.5h7"></path>
                <path d="M5 13.5h11"></path>
                <path d="M8 15.5h5"></path>
            </g>
        </svg>
    </button>
    <button type="button" class="btn btn-sm btn-default" title="Align right" data-wysihtml-command="justifyRight" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(0 2)" fill="none" stroke="currentColor">
                <path d="M5 5.5h11"></path>
                <path d="M7 7.5h9"></path>
                <path d="M4 9.5h12"></path>
                <path d="M8 11.5h8"></path>
                <path d="M5 13.5h11"></path>
                <path d="M11 15.5h5"></path>
            </g>
        </svg>
    </button>

    <button type="button" class="btn btn-sm btn-default" title="Bulleted list" data-wysihtml-command="insertUnorderedList" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(2 5)" fill="#1B2124">
                <circle id="Oval" cx="1.5" cy="12.5" r="1.5"></circle>
                <circle id="Oval" cx="1.5" cy="2.5" r="1.5"></circle>
                <circle cx="1.5" cy="7.5" r="1.5"></circle>
                <path d="M6.5 2.5h9" id="Line" stroke="#1B2124"></path>
                <path d="M6.5 12.5h9" stroke="#1B2124"></path>
                <path d="M6.5 7.5h9" stroke="#1B2124"></path>
            </g>
        </svg>
    </button>
    <button type="button" class="btn btn-sm btn-default" title="Numbered list" data-wysihtml-command="insertOrderedList" data-toggle="tooltip" unselectable="on">
        <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(2 5)" fill="none">
                <path d="M2.933 4.437v-4.437h-.96l-1.459 1.071.545.746.827-.639v3.259h1.047z" id="Shape" fill="#1B2124"></path>
                <path d="M3.747 9.659v-.915h-1.811l1.028-.914.292-.28c.094-.094.177-.194.25-.304.073-.108.13-.227.172-.354.042-.127.063-.27.063-.429 0-.229-.044-.43-.134-.602-.09-.171-.21-.313-.361-.426-.15-.113-.321-.197-.514-.251-.192-.053-.391-.081-.595-.081-.218 0-.423.033-.617.098s-.367.16-.518.283c-.15.125-.274.274-.373.451-.098.177-.159.377-.184.603l1.008.138c.021-.2.087-.362.198-.485.111-.124.254-.185.429-.185.167 0 .301.049.401.146.1.098.15.227.15.385 0 .134-.033.255-.101.363-.066.109-.154.214-.262.32l-1.729 1.563v.876h3.208z" id="Shape" fill="#1B2124"></path>
                <path d="M3.703 13.238c-.042-.109-.1-.211-.176-.301-.075-.09-.165-.166-.269-.23-.104-.064-.219-.111-.345-.141v-.021c.217-.06.396-.172.536-.342.14-.169.209-.377.209-.624 0-.213-.045-.398-.135-.557-.09-.157-.208-.287-.354-.392-.146-.105-.313-.183-.499-.233-.186-.049-.377-.074-.573-.074-.184 0-.364.023-.539.072-.175.047-.337.117-.486.213-.148.095-.276.211-.385.352-.109.141-.19.305-.244.491l.977.226c.034-.148.105-.271.216-.359.111-.09.242-.135.392-.135.146 0 .276.043.389.125.113.086.169.207.169.366 0 .109-.022.198-.066.267-.044.066-.103.119-.175.16l-.248.082-.289.021h-.305v.767h.282l.326.026c.108.021.206.051.292.095.085.044.154.104.206.18.052.074.079.168.079.28 0 .105-.021.193-.06.265-.039.07-.089.127-.15.172l-.207.097-.229.032c-.201 0-.366-.057-.495-.167-.129-.11-.215-.238-.257-.384l-.977.256c.058.209.146.388.263.535.117.147.254.271.41.363.157.094.331.164.521.211.19.045.385.068.586.068.205 0 .406-.027.604-.084.198-.057.377-.143.536-.257.159-.114.287-.261.385-.438.099-.177.147-.388.147-.629.001-.125-.02-.242-.062-.354z" fill="#1B2124"></path>
                <path d="M6.5 2.5h9" id="Line" stroke="#1B2124"></path>
                <path d="M6.5 12.5h9" id="Line" stroke="#1B2124"></path>
                <path d="M6.5 7.5h9" stroke="#1B2124"></path>
            </g>
        </svg>
    </button>

    <div class="dropdown" title="Font size" style="display:inline-block;" data-toggle="tooltip">
        <button type="button" class="btn btn-sm btn-default dropdown-toggle fontSizeBtn" data-toggle="dropdown" unselectable="on" aria-haspopup="true" aria-expanded="false">
            <span>↕</span>
        </button>
        <ul class="dropdown-menu fontSizeDD">
            <li><button type="button" class="btn btn-sm btn-default" data-wysihtml-command="fontSize" data-wysihtml-command-value="small" unselectable="on">Small</button></li>
            <li><button type="button" class="btn btn-sm btn-default" data-wysihtml-command="fontSize" data-wysihtml-command-value="medium" unselectable="on">Default</button></li>
            <li><button type="button" class="btn btn-sm btn-default" data-wysihtml-command="fontSize" data-wysihtml-command-value="large" unselectable="on">Large</button></li>
            <li><button type="button" class="btn btn-sm btn-default" data-wysihtml-command="fontSize" data-wysihtml-command-value="x-large" unselectable="on">X-Large</button></li>
        </ul>
    </div>

    <button type="button" class="btn btn-sm btn-default foreColor" title="Red" data-wysihtml-command="foreColor" data-wysihtml-command-value="red" data-toggle="tooltip" unselectable="on">
        <span style="background-color:#b10000;">&nbsp;</span>
    </button>
    <button type="button" class="btn btn-sm btn-default foreColor" title="Green" data-wysihtml-command="foreColor" data-wysihtml-command-value="green" data-toggle="tooltip" unselectable="on">
        <span style="background-color:#018913;">&nbsp;</span>
    </button>
    <button type="button" class="btn btn-sm btn-default foreColor" title="Blue" data-wysihtml-command="foreColor" data-wysihtml-command-value="blue" data-toggle="tooltip" unselectable="on">
        <span style="background-color:#0026ff;">&nbsp;</span>
    </button>

    <div class="input-group" title="Create link" style="display:inline-block;" data-toggle="tooltip">
        <button class="btn btn-sm btn-default" data-wysihtml-command="createLink" unselectable="on" aria-haspopup="true" aria-expanded="false">
            <svg width="21" height="21" xmlns="http://www.w3.org/2000/svg">
                <g transform="translate(0 4)" fill="none">
                    <g fill="#1C67B2">
                        <path d="M7.946 8.197c-.14-.037-.252-.081-.34-.133-.129-.086-.229-.172-.3-.264-.074-.088-.138-.206-.195-.35l-2.685-6.841h-.453l-1.306 3.315c-.488 1.24-.934 2.358-1.34 3.354-.08.194-.16.346-.244.455-.083.11-.201.214-.352.315-.094.057-.215.106-.361.141l-.37.068v.396h3.032v-.397c-.297-.015-.568-.067-.804-.147-.239-.082-.358-.197-.358-.345l.027-.247.103-.391.18-.536c.066-.194.152-.422.258-.681h2.828l.666 1.776.035.129.011.124c0 .082-.097.15-.292.207-.196.054-.441.091-.737.111v.396h3.349v-.396c-.094-.005-.213-.024-.352-.059zm-5.312-2.787l1.203-3.078 1.221 3.078h-2.424z" id="Shape"></path>
                        <path d="M13.559 3.795c-.463-.536-1.037-.805-1.727-.805-.27 0-.543.062-.818.184-.279.123-.537.308-.771.553l-.04-.011v-3.631l-.079-.085-2.055.124v.358l.405.047c.169.024.288.061.36.109.091.057.167.146.225.274.059.126.088.252.088.379v5.459c0 .361-.002.736-.011 1.124-.008.388-.021.722-.04.997l.353.077.419-.644c.262.154.541.279.837.375.295.092.6.139.904.139.699 0 1.314-.28 1.844-.844.529-.562.797-1.258.797-2.085.001-.859-.232-1.557-.691-2.094zm-.92 3.941c-.285.439-.654.659-1.119.659-.207 0-.385-.03-.523-.098-.145-.066-.271-.15-.389-.255-.112-.108-.205-.221-.27-.341-.067-.118-.112-.222-.134-.312v-3.208c.158-.174.337-.314.536-.417.199-.102.43-.153.695-.153.291 0 .541.066.75.201.205.134.375.31.504.525.127.212.223.462.285.75.059.286.09.567.09.843-.002.764-.145 1.366-.425 1.806z" id="Shape"></path>
                        <path d="M18.982 8.412c.41-.258.74-.605.99-1.045l-.363-.234c-.213.352-.442.616-.689.792-.247.177-.554.264-.92.264-.508 0-.916-.219-1.229-.658-.312-.438-.47-1.003-.47-1.696 0-.439.046-.817.13-1.134.088-.316.202-.568.342-.754.152-.205.312-.347.478-.423.163-.075.338-.114.521-.114.153 0 .297.02.433.059.134.039.233.116.303.231l-.079.387c-.046.177-.066.349-.066.515 0 .138.061.263.186.374.122.111.294.167.518.167.209 0 .358-.071.451-.214.094-.145.137-.309.137-.495 0-.447-.172-.8-.519-1.059-.343-.259-.79-.388-1.336-.388-.397 0-.765.081-1.103.243-.338.162-.617.375-.842.639-.235.276-.414.582-.535.919-.123.338-.186.699-.186 1.086 0 .891.229 1.601.688 2.13.459.528 1.093.792 1.902.792.428-.001.853-.127 1.258-.384z" id="Shape"></path>
                        <rect y="10" width="19.768" height=".562"></rect>
                    </g>
                    <path d="M15.672 10.839l-4.755-4.682v7.803l2.112-1.562 1.059 2.602 1.587-1.04-1.587-2.081 1.584-1.04zm-4.169 1.777v-5.117l3.119 3.071-3.119 2.046z" fill="#1B2124"></path>
                </g>
            </svg>
        </button>
        <div class="wysihtml-dropdown wysihtml-dropdown-createLink" data-wysihtml-dialog="createLink" style="display:none;">
            <input class="form-control" value="http://" data-wysihtml-dialog-field="href">
            <span class="input-group-btn" style="display:block;">
                <button type="button" class="btn btn-sm btn-default" data-wysihtml-dialog-action="save" unselectable="on">Insert</button>
                <button type="button" class="btn btn-sm btn-default" data-wysihtml-command="removeLink" unselectable="on">Remove</button>
            </span>
        </div>
    </div>

</div>