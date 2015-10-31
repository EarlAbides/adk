<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php require_once 'includes/session.php';?>
<?php require_once 'includes/loginredir.php';?>
<?php include 'includes/variables_site.php';?>
<?php require_once 'gallery.inc.php';?>

<?php include 'includes/head.php';?>
    <script src="js/jquery.lazyload.min.js"></script>
    <script src="js/gallery.min.js"></script>
	<script>
		$(function(){
		    $('img.lazy').show().lazyload({
				container: $('#div_photos')
				,effect: 'fadeIn'
				,threshold: 10
			});
		});
		$(window).load(function(){
			$('html,body').trigger('scroll');
		});
	</script>
</head>

<body>
	<?php include 'includes/navbar.php';?>
	<?php include 'includes/logo.php';?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php';?>
		<div class="content-wrapper">
            
            <div class="col-xs-12 content content-max" style="margin-bottom:15px;">
                   
                <div class="container-fluid">
                    <h4 class="content-header">
					    <?php
							if(isset($ADK_USER)) echo $ADK_USER['ADK_USER_USERNAME'].'\'s Gallery';
							else echo 'Gallery';
						?>
                        <a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode.parentNode);">
						    <span class="glyphicon glyphicon-chevron-down"></span>
					    </a>
				    </h4>

                    <br />

                    <div class="col-xs-6">
                        <div class="form-group">
							<?php if($ADK_USERGROUP_CDE === 'ADM' || $ADK_USERGROUP_CDE === 'EDT'){?>
								<label for="select_ADK_HIKER" class="control-label control-label-sm text-right">Filter by user</label>
								<select id="select_ADK_HIKER" class="form-control form-control-sm">
									<option value="">Show All</option>
									<option disabled="disabled" role="separator" >-------------------------</option>
									<?php foreach($ADK_HIKERS as $ADK_HIKER) echo '<option value="'.$ADK_HIKER['ADK_USER_ID'].'">'.$ADK_HIKER['ADK_USER_USERNAME'].' - '.$ADK_HIKER['ADK_USER_NAME'].'</option>';?>
								</select>
							<?php }else echo $ADK_USER['ADK_USER_NAME'].'</span><br />';?>
							<?php if(isset($ADK_USER)) echo '<span><a href="'.$ADK_USER['ADK_USER_EMAIL'].'">'.$ADK_USER['ADK_USER_EMAIL'].'</a></span><br />';?>
						</div>
                    </div>

                    <div class="col-xs-6">
                        <div class="pull-right">
                            <label for="select_filter" class="control-label control-label-sm text-right">Filter by peak</label>
						    <select id="select_filter" class="form-control form-control-sm">
                                <option value="">Show All</option>
                                <option disabled="disabled" role="separator" >-------------------------</option>
                                <?php foreach($ADK_PEAKS as $ADK_PEAK) echo '<option value="'.$ADK_PEAK['ADK_PEAK_NAME'].'">'.$ADK_PEAK['ADK_PEAK_NAME'].'</option>';?>
                            </select>
						    <span class="help-block with-errors"></span>
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
						<?php if(!isset($photos) || count($photos) === 0){ ?>
							<div class="col-xs-12 text-center font-italic">No photos</div>
						<?php }else{ ?><ul class="row gallery-photo"><?php for($i = 0; $i < count($photos); $i++){?>
						<li class="gallery col-xs-6 col-sm-4 col-md-3 col-lg-2" data-peaks="<?php echo $photos[$i]->peaks;?>">
							<a href="#" class="photo" data-toggle="modal" data-target="#modal_gallery" data-id="<?php echo $photos[$i]->id;?>" data-desc="<?php echo $photos[$i]->desc;?>" data-un="<?php echo $photos[$i]->username;?>" data-peaks="<?php echo str_replace(',', ', ', $photos[$i]->peaks);?>">
								<img src="img/loading.gif" data-original="includes/getImage.php?_=<?php echo $photos[$i]->id;?>&t=t" class="img-responsive imghover lazy" alt="<?php echo $photos[$i]->name;?>" title="<?php echo getTitle($photos[$i]);?>" data-toggle="tooltip" data-container="body" data-placement="bottom" />
							</a>
						</li>
						<?php }?></ul><?php }?>
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

                    <?php if(!isset($videos) || count($videos) === 0){ ?>
                        <div class="col-xs-12 text-center font-italic">No videos</div>
                    <?php }else{?><ul class="row gallery-video"><?php for($i = 0; $i < count($videos); $i++){?>
					<li class="gallery" data-peaks="<?php echo $videos[$i]->peaks;?>">
						<a href="#" class="video" data-toggle="modal" data-target="#modal_gallery" data-id="<?php echo $videos[$i]->id;?>" data-desc="<?php echo $videos[$i]->desc;?>" data-un="<?php echo $videos[$i]->username;?>" data-peaks="<?php echo str_replace(',', ', ', $videos[$i]->peaks);?>">
							<span title="<?php echo getTitle($videos[$i]);?>" data-toggle="tooltip" data-container="body" data-placement="right"><?php echo $videos[$i]->name;?></span>
						</a>
					</li>
					<?php }?></ul><?php }?>
                    
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

                    <?php if(!isset($docsFiles) || count($docsFiles) === 0){ ?>
                        <div class="col-xs-12 text-center font-italic">No files</div>
                    <?php }else{?><ul class="row gallery-files"><?php for($i = 0; $i < count($docsFiles); $i++){?>
                        <li class="gallery" data-peaks="<?php echo $docsFiles[$i]->peaks;?>">
                            <a href="#" onclick="getFile(<?php echo $docsFiles[$i]->id;?>);">
                                <span title="<?php echo getTitle($docsFiles[$i]);?>" data-toggle="tooltip" data-container="body" data-placement="right"><?php echo $docsFiles[$i]->name;?></span>
                            </a>
                        </li>
                    <?php }?></ul><?php }?>

                </div>

			</div>

		</div>
		<?php include 'includes/footer.php';?>
	</div>

    <div style="display:none;">
		<form method="post" action="includes/dl.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
	</div>

    <div id="modal_gallery" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="modal_gallery_label">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="modal_gallery_label" class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="modal_gallery_container"></div>
                    <div id="modal_gallery_desc"></div>
                </div>
            </div>
        </div>
    </div>
	
</body>
</html>