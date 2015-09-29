<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php require_once 'includes/session.php';?>
<?php require_once 'includes/loginredir.php';?>
<?php include 'includes/variables_site.php'; ?>

<?php include 'includes/head.php'; ?>
</head>

<body>
	<?php include 'includes/navbar.php';?>
	<?php include 'includes/logo.php';?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php';?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max">
					
				<h4 class="content-header">
					Hiker Guidelines
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
				
				<div class="container-fluid">
					<div class="col-xs-12 text-center">
						<img src="img/adk_logo2.png" class="img-responsive" style="opacity:0.7;display:inline;" />
					</div>
				</div>
					
				<div class="container-fluid">
					
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">
						<p>
							&emsp;The ADK 46ers have developed site for reporting, recording personal climbs and keeping alive the tradition
                            that Grace Hudowalski established many years ago. She personally corresponded to this author, it meant much to
                            me and kept me driven to complete the high 46.  By creating this account, you can log your hikes and climbs, add
                            information about the hike, and include digital memorabilia. All information posted is can be viewed by the ADK46ers
                            and we may even select a story or picture for&nbsp;publication!
						</p>
                        <p>
							&emsp;Through your correspondent, you can discuss your hikes, tell of your stories and endeavors and tell us of
                            who you may have met on the hike... we encourage writing in so we can get to know you. Writing to the ADK 46ers
                            and building relationships sets us apart from other mountain climbing&nbsp;groups.
						</p>
						<p>
							&emsp;Grace had her rules for reporting climbs, however these spoke to an older, non-digital age. We embrace
							her legacy by asking that the letters adhere to some&nbsp;guidelines. In order to guarantee a reply, please
                            abide by the&nbsp;following:
                        </p>
					</div>
					
				</div>
				
				<div class="hr hr75"></div>
				
				<div class="container-fluid">
					
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">
						
						<h3 class="font-underline">General</h3>
						
						<ul>
							<li>
                                Use full legible sentences and proper grammar. Use no profanity nor abusive language.
                                Please keep the messages to a reasonable length and on the topic of the hikes! Any indication of
                                misuse or bad conduct and we reserve the right to ban any user at our discretion.
                            </li>
							<li>Each person must send their own correspondence. Parents may write for small children.</li>
							<li>Please include digital memories photos. It is not necessary to include sign posts or mountain pictures. Send pictures of yourself.</li>
							<li>
                                Use the website message board for 46er correspondence, not email. Your personal correspondent will
                                return a message and you will get an email when it is posted. You can only message with your assigned
                                correspondent.
                            </li>
                            <li>
                                Any problems with response time, assistance or questions with the website please use the Help button at
                                the bottom of the page or email to <a href="mailto:adk46ertrailswm@gmail.com">adk46ertrailswm@gmail.com</a>.
                            </li>
						</ul>
					</div>
					
				</div>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php';?>
	</div>
	
</body>
</html>