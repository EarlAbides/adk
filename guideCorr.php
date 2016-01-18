<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php include 'includes/variables_site.php'; ?>

<?php include 'includes/head.php'; ?>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max">
					
				<h4 class="content-header">
					Correspondent Guidelines
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
							&emsp;The purpose of this document is to serve as a guide to the new correspondent and a reference to
							the experienced correspondent.
						</p>
						<p>
							&emsp;The history of this office goes back to the 46ers in Troy in late thirties and the 46ers that formed
							in the forties. Grace Hudowalski initiated the procedures outlined here. She had a very efficient system
							of recording and corresponding to the climbers. She did this without the aid of a computer. She could be
							critical at times. As when she felt a climber was improper in reporting their climbs. In time the number
							of climbers increased and Grace was getting older. It became difficult for her to keep up. A staff of helpers
							organized the Office of the Historian. Under her watchful eye a team of correspondents filled in for what
							Grace was doing by herself. Even though this is done by paper and snail mail it still worked for many years
							keeping the traditional format set up by&nbsp;Grace.
						</p>
						<p>
							&emsp;It is our wish keep the correspondence program alive and while honoring the old format we need to
							use digital technology as for what it can do for us. Although Grace has left us let's always remember and honor
							this unique tradition of the 46ers. We will accommodate paper and pen 'snail mail' and archive via a scan, but
							push for email or message board electronic records as it is so much&nbsp;easier.
						</p>						
					</div>
					
				</div>
				
				<div class="hr hr75"></div>
				
				<div class="container-fluid">
					
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">

						<h4 class="text-center"><a href="http://ppl.ug/cx87VzXrA_8/" target="_blank">ADK 46er Walk Softly Brochure</a></h4>
						
						<h3 class="font-underline">Basic Tenets</h3>
						
						<p>Everyone will receive personal correspondence and that everyone should write their own letters, especially children.</p>
						<p>
							Correspondents should use the editorial 'we' when answering even when sharing personal experience.<br />
							For instance:
						</p>		
						<ul>
							<li>Yesterday we received your personal climbing file.</li>
							<li>
								We're delighted to hear that you were climbing the Adirondack high peaks.
								Your letter brought back happy memories of when we climbed.
							</li>
							<li>We look forward to hearing about your next climb.</li>
						</ul>
						<p>People in the mountains are on a first name basis. There is no Doctor, Mrs., Mr. or misses, etc.</p>
						<p>Do not give out trail information. No matter how knowledgeable and wanting to to help a correspondent may be, please refrain. This puts the 46ers in a liability situation.</p>
					</div>
					
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">
						<h3 class="font-underline">The First Response</h3>
						<p>
							You will receive an email from the site administrator indicating you have a hiker. 
							That means that an account has been set up in their name with you as their correspondent.
							Please take it upon yourself to reach out to the hiker and introduce yourself.
						</p>
					</div>
					
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">
						<h3 class="font-underline">Tracking Climbs</h3>
						<p>
							Both you and the hiker are able to log hikes, record the peak and the date, and post descriptive
                            info in the textbox. If they can not remember the date, best guess on month and use the first day
                            of that month. A response for each message is a goal. You will need to develop your own style and
                            your own relationship with each hiker. The object is to build a nice trusting relationship, make
                            a friend, and inspire them to the next adventure.
						</p>
					</div>
					
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">
						<h3 class="font-underline">Finishers</h3>
						<p>
							When all 46 climbs have been posted to the site, an email is sent to the hiker pointing them to: <a href="http://adk46er.org/how-to-join.html" target="_blank">http://adk46er.org/how-to-join.html</a>
						</p>
					</div>
					
				</div>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
</body>
</html>