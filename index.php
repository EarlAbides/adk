<?php require_once 'includes/session.php';?>
<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php include 'includes/head.php';?>
    <script>
        $(document).ready(function(){
            $('.hometab').click(function(){
                this.classList.add('hometab-disabled');

                var seperator = document.querySelector('.hometab-section-seperator');
                seperator.style.display = 'block';
                setTimeout(function(){seperator.style.display = 'none';}, 630);
                
                if(this.classList.contains('hometab-intro')){
                    document.querySelector('.hometab-about').classList.remove('hometab-disabled');
                    var toMax = document.querySelector('#home_intro'), toMin = document.querySelector('#home_about');
                }
                else{
                    document.querySelector('.hometab-intro').classList.remove('hometab-disabled');
                    var toMax = document.querySelector('#home_about'), toMin = document.querySelector('#home_intro');
                }

                $(toMin).animate({height: '0'}, 650);
                $(toMax).animate({height: '100%'}, 650);
            });
        });
    </script>
</head>

<body>
	<?php include 'includes/navbar.php';?>
	<?php include 'includes/logo.php';?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php';?>
		<div class="content-wrapper">
		
			<div class="col-xs-12 col-sm-8">
				<div class="container-fluid content content-max">
					
					<h4 class="content-header">
						ADK 46er Correspondent Program
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>

                    <span style="font-size:1.1em;">
                        <a href="#intro" class="hometab hometab-intro hometab-disabled">Intro</a>
                        <b>&nbsp;|&nbsp;</b>
                        <a href="#about" class="hometab hometab-about">About</a>
                    </span>
					
                    <div id="home_intro">

                        <br />
					    
                        <p>Welcome!</p>

					    <p>
						    I am excited to release this new electronic version of the 46er Correspondence Program. This
                            cherished communication is unique to the 46ers. Within you will be assigned a correspondent,
                            be able to log your hikes, post pictures, and use the messaging system to communicate to an
                            assigned and personal 46er correspondent. I hope you will utilize this program to help inspire you.
					    </p>

                        <br/>

                        <p>
                            Mark Simpson #6038<br />
                            Site Administrator
                        </p>

                    </div>

                    <div class="hometab-section-seperator"></div>

                    <div id="home_about">
                        
                        <br />

					    <p>
						    For years our "46er Correspondent Program" set the organization apart from all others.
						    Hikers could request a correspondent through the Historian's Office. The hiker and correspondent
						    could exchange stories of climbs and receive encouragement during their quest to finish the 46.
						    Unfortunately, due to an increase in hikers and finishers, the Historian's Office could no longer
						    keep up with managing the paperwork involved with coordinating hikers and correspondents and maintaining
						    the individual records.
					    </p>

					    <p>
						    The 46ers have decided to introduce this correspondent program to allow interested hikers
						    the opportunity to share their journey with experienced club members. If you wish to participate, click
						    the Sign Up tab and fill out the easy form and submit it...  A correspondent will
						    be in touch. Log in and check the Hiker Portal tab...<br />
                            Be safe and good climbing!
					    </p>
	
					    <div class="hr hr75"></div>
	
					    <p>
						    Climbing the 46 is more than just receiving a patch for the accomplishment. 
						    It is a personal challenge and journey that will reward you with memories and 
						    friendships that will last a lifetime. If you choose to take on the adventure, 
						    please climb safely, with concern for your fellow hikers and respect for the 
						    magnificent environment you have the privilege to explore.
						</p>

                        <br/>

                        <p>
                            Sally Hoy #2924W<br />
                            Past President
                        </p>

                    </div>

                    <p>Enjoy the journey!</p>
				
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-4">
				<div class="container-fluid content content-max" style="padding:0px 8px;">
					<h4 class="content-header">&nbsp;
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					<div style="padding:8px 0 5px 0;">
						<iframe src="http://player.vimeo.com/video/88462048?portrait=0" width="100%" height="240" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					</div>
				</div>
			</div>
			
		</div>
		<?php include 'includes/footer.php';?>
	</div>
	
</body>
</html>