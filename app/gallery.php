<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php include 'includes/variables_site.php'; ?>
<?php require_once 'gallery.inc.php'; ?>

<?php include 'templates/head.php'; ?>
    <script src="js/jquery.lazyload.min.js"></script>
    <script src="js/gallery.min.js"></script>
	<script>
		$(function(){
		    $('img.lazy').show().lazyload({
				container: $('#div_photos')
				, effect: 'fadeIn'
				, threshold: 10
			});
		});
		$(window).load(function(){
			$('html,body').trigger('scroll');
		});
	</script>
</head>

<body>
	<?php include 'templates/navbar.php'; ?>
	<?php include 'templates/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'templates/navbar_sub.php'; ?>
		<div class="content-wrapper">
            
            <div class="col-xs-12 content content-max" style="margin-bottom:15px;">
                   
                <div class="container-fluid">
                    <h4 class="content-header">
					    <?php
							if(isset($ADK_USER)) echo $ADK_USER->username.'\'s Gallery';
							else echo 'Gallery';
						?>
                        <a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode.parentNode);">
						    <span class="glyphicon glyphicon-chevron-down"></span>
					    </a>
				    </h4>

                    <br />

                    <div class="col-xs-12 col-sm-4 col-md-5">
                        <div class="form-group">
							<?php if($ADK_USERGROUP_CDE !== 'HIK'){ ?>
								<label for="select_ADK_HIKER" class="control-label control-label-sm text-right">Filter by user</label>
								<select id="select_ADK_HIKER" class="form-control form-control-sm">
									<option value="">Show All</option>
									<option disabled="disabled" role="separator" >-------------------------</option>
									<?php foreach($ADK_HIKERS->hikers as $ADK_HIKER) echo '<option value="'.$ADK_HIKER->id.'">'.$ADK_HIKER->username.' - '.$ADK_HIKER->name.'</option>'; ?>
								</select>
							<?php }else echo $ADK_USER->name.'</span><br />'; ?>
							<?php if(isset($ADK_USER)) echo '<span><a href="'.$ADK_USER->email.'">'.$ADK_USER->email.'</a></span><br />'; ?>
						</div>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-5 col-md-offset-2">
                        <div class="pull-right">
							<?php if($ADK_USER_ID !== '%'){ ?>
								<label for="select_filter" class="control-label control-label-sm text-right">Filter by hike</label>
								<select id="select_filter" class="form-control form-control-sm">
									<option value="">Show All</option>
									<option disabled="disabled" role="separator" >-------------------------</option>
									<?php foreach($ADK_HIKES->hikes as $ADK_HIKE) echo '<option value="'.$ADK_HIKE->label.'">'.$ADK_HIKE->label.'</option>'; ?>
								</select>
								<span class="help-block with-errors"></span>
							<?php  }else{ ?>
								<label for="select_filter" class="control-label control-label-sm text-right">Filter by peak</label>
								<select id="select_filter" class="form-control form-control-sm">
									<option value="">Show All</option>
									<option disabled="disabled" role="separator" >-------------------------</option>
									<?php foreach($ADK_PEAKS->peaks as $ADK_PEAK) echo '<option value="'.$ADK_PEAK->name.'">'.$ADK_PEAK->name.'</option>'; ?>
								</select>
								<span class="help-block with-errors"></span>
							<?php } ?>
                        </div>
                    </div>
                    
                </div>

			</div>
            
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
                
                <div class="container-fluid">
                    <h4 class="content-header">
					    Pictures
					    <a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode.parentNode);">
						    <span class="glyphicon glyphicon-chevron-down"></span>
					    </a>
				    </h4>

                    <br />

					<div id="div_photos" class="scroll" style="max-height:750px;">
						<?php if(count($ADK_GALLERY->photos) === 0){ ?>
							<div class="col-xs-12 text-center font-italic">No photos</div>
						<?php }else{ ?><ul class="row gallery-photo"><?php foreach($ADK_GALLERY->photos as $photo){ ?>
						<li class="gallery col-xs-6 col-sm-4 col-md-3 col-lg-2" data-peaks="<?php echo $photo->peaks; ?>">
							<a href="#" class="photo" data-toggle="modal" data-target="#modal_gallery" data-id="<?php echo $photo->id; ?>" data-desc="<?php echo $photo->desc; ?>" data-un="<?php echo $photo->username; ?>" data-peaks="<?php echo str_replace(',', ', ', $photo->peaks); ?>">
								<img src="img/loading.gif" data-original="includes/fileGetImage.php?_=<?php echo $photo->id; ?>&t=t" class="img-responsive imghover lazy" alt="<?php echo $photo->name; ?>" title="<?php echo getTitle($photo); ?>" data-toggle="tooltip" data-container="body" data-placement="bottom" />
							</a>
						</li>
						<?php } ?></ul><?php } ?>
					</div>

                </div>

            </div>
            
            <div class="col-xs-12 col-sm-5 content content-max" style="margin-bottom:15px;">
                   
                <div class="container-fluid">
                    <h4 class="content-header">
					    Videos
					    <a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode.parentNode);">
						    <span class="glyphicon glyphicon-chevron-down"></span>
					    </a>
				    </h4>

                    <br />

                    <?php if(count($ADK_GALLERY->videos) === 0){ ?>
                        <div class="col-xs-12 text-center font-italic">No videos</div>
                    <?php }else{ ?><ul class="row gallery-video"><?php foreach($ADK_GALLERY->videos as $video){ ?>
					<li class="gallery" data-peaks="<?php echo $video->peaks; ?>">
						<a href="#" class="video" data-toggle="modal" data-target="#modal_gallery" data-id="<?php echo $video->id; ?>" data-desc="<?php echo $video->desc; ?>" data-un="<?php echo $video->username; ?>" data-peaks="<?php echo str_replace(',', ', ', $video->peaks); ?>">
							<span title="<?php echo getTitle($video); ?>" data-toggle="tooltip" data-container="body" data-placement="right"><?php echo $video->name; ?></span>
						</a>
					</li>
					<?php } ?></ul><?php } ?>
                    
                </div>

			</div>

            <div class="col-xs-12 col-sm-5 pull-right content content-max">
                   
                <div class="container-fluid">
                    <h4 class="content-header">
					    Documents and Files
					    <a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode.parentNode);">
						    <span class="glyphicon glyphicon-chevron-down"></span>
					    </a>
				    </h4>

                    <br />

                    <?php if(count($ADK_GALLERY->docs) === 0){ ?>
                        <div class="col-xs-12 text-center font-italic">No files</div>
                    <?php }else{ ?><ul class="row gallery-files"><?php foreach($ADK_GALLERY->docs as $doc){ ?>
                        <li class="gallery" data-peaks="<?php echo $doc->peaks; ?>">
                            <a href="#" onclick="getFile(<?php echo $doc->id; ?>);">
                                <span title="<?php echo getTitle($doc); ?>" data-toggle="tooltip" data-container="body" data-placement="right"><?php echo $doc->name; ?></span>
                            </a>
                        </li>
                    <?php } ?></ul><?php } ?>

                </div>

			</div>

		</div>
		<?php include 'templates/footer.php'; ?>
	</div>

    <div style="display:none;">
		<form method="post" action="includes/fileGet.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
	</div>

    <?php include 'templates/modal/gallery.html'; ?>
	
</body>
</html>