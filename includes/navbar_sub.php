<?php
	$class = ' class="active"';
	if(isset($page)){
		switch($page){
			case 'index': $home = $class; break;
			case 'signup': $signup = $class; break;
			case 'applicants': $applicants = $class; break;
			case 'correspondents': $correspondents = $class; break;
			case 'hikerportal': $hikerportal = $class; break;
			case 'hikers': $hikers = $class; break;
			case 'changelog': $changelog = $class; break;
			case 'guideCorr': $guideCorr = $class; break;
			case 'guideHiker': $guideHiker = $class; break;
            case 'login': $login = $class; break;
            case 'messages': $messages = $class; break;
            case 'profile': $profile = $class; break;
			case 'gallery': $gallery = $class; break;
			case 'lnt': $lnt = $class; break;
		}
	}
?>

<nav id="navbar-sub" class="navbar navbar-default navbar-sub">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_sub">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div id="navbar_sub" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li<?php if(isset($home)) echo $home;?>><a href="./">Home</a></li>
				<?php if(!isset($_SESSION['ADK_USER_ID'])){?>
					<li<?php if(isset($signup)) echo $signup;?>><a href="./signup">Sign Up</a></li>
				<?php }?>
				<?php if((isset($_SESSION['ADK_USERGROUP_CDE']) && ($_SESSION['ADK_USERGROUP_CDE'] === 'COR'))){?>
					<li<?php if(isset($hikers)) echo $hikers;?>><a href="./hikers">Hikers</a></li>
					<li<?php if(isset($guideCorr)) echo $guideCorr;?>><a href="./guideCorr">Correspondent Guidelines</a></li>
					<li<?php if(isset($lnt)) echo $lnt;?>><a href="./lnt">Leave No Trace</a></li>
					<li<?php if(isset($changelog)) echo $changelog;?>><a href="./changelog">Change log</a></li>
				<?php }?>
				<?php if((isset($_SESSION['ADK_USERGROUP_CDE']) && ($_SESSION['ADK_USERGROUP_CDE'] === 'ADM'))){?>
					<li<?php if(isset($applicants)) echo $applicants;?>><a href="./applicants">Applicants</a></li>
					<li<?php if(isset($hikers)) echo $hikers;?>><a href="./hikers">Hikers</a></li>
					<li<?php if(isset($correspondents)) echo $correspondents;?>><a href="./correspondents">Correspondents</a></li>
					<li<?php if(isset($gallery)) echo $gallery;?>><a href="./gallery">Gallery</a></li>
					<li<?php if(isset($changelog)) echo $changelog;?>><a href="./changelog">Change log</a></li>
					<li<?php if(isset($lnt)) echo $lnt;?>><a href="./lnt">Leave No Trace</a></li>
				<?php }?>
				<?php if((isset($_SESSION['ADK_USERGROUP_CDE']) && ($_SESSION['ADK_USERGROUP_CDE'] === 'HIK'))){?>
					<li<?php if(isset($hikerportal)) echo $hikerportal;?>><a href="./hikerportal">Hiker Portal</a></li>
					<li<?php if(isset($guideHiker)) echo $guideHiker;?>><a href="./guideHiker">Hiker Guidelines</a></li>
					<li<?php if(isset($lnt)) echo $lnt;?>><a href="./lnt">Leave No Trace</a></li>
				<?php }?>
				<?php if((isset($_SESSION['ADK_USERGROUP_CDE']) && ($_SESSION['ADK_USERGROUP_CDE'] === 'EDT'))){?>
					<li<?php if(isset($hikers)) echo $hikers;?>><a href="./hikers">Hikers</a></li>
					<li<?php if(isset($gallery)) echo $gallery;?>><a href="./gallery">Gallery</a></li>
					<li<?php if(isset($lnt)) echo $lnt;?>><a href="./lnt">Leave No Trace</a></li>
				<?php }?>
			</ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(!isset($_SESSION['ADK_USER_ID'])){?>
				<li<?php if(isset($login)) echo $login;?>><a href="./login">Log In</a></li>
                <?php }else{?>
                    <?php if($_SESSION['ADK_USERGROUP_CDE'] !== 'EDT'){?>
						<li<?php if(isset($messages)) echo $messages;?>><a href="./messages">Messages</a></li>
					<?php }?>
                    <li<?php if(isset($profile)) echo $profile;?>><a href="./profile">Edit Profile</a></li>
                <?php }?>
			</ul>
		</div>
	</div>
</nav>