<?php
	
	//SECURTY
	$post = $this->seotudy_postSecurty($_POST); 
	extract($post);
	//SECURTY
	
	require "seotudy-header.php";
?>
<section class="seotudy-content">
	<div class="container-fluid">
		<div class="row row-no-padding">
			
			<div class="col-lg-2 col-md-3">
				
				<div class="seotudy-tabs pageHeader">
					<div class="tab active">
						<i class="fas fa-home"></i>
					    <?=__('Home','seotudy')?>
					</div>
					<div class="tab">
						<i class="fas fa-file"></i>
					    <?=__('Post Types','seotudy')?>
					</div>
					<div class="tab">
						<i class="fas fa-copy"></i>
					    <?=__('Taxonomy','seotudy')?>
					</div>
					<div class="tab">
						<i class="fas fa-file-image"></i>
					    <?=__('Media','seotudy')?>
					</div>
				</div>
				
			</div>
			
			<div class="col-lg-10 col-md-9">
				
				<div class="parameters">
					<div class="title"><?=__('All Seotudy\'s Parameters','seotudy')?></div>
					<ul>
						<li><strong><?=__('Site Name')?></strong> <strong>%sitename%</strong></li>
						<li><strong><?=__('Site Slogan')?></strong> <strong>%siteslogan%</strong></li>
						<li><strong><?=__('Page Title')?></strong> <strong>%title%</strong></li>
						<li><strong><?=__('Page Description')?></strong> <strong>%desc%</strong></li>
						<li><strong><?=__('Pagination')?></strong> <strong>%page%</strong></li>
						<li><strong><?=__('Seperator')?></strong> <strong>%sep%</strong></li>
					</ul>
				</div>
				
				<div class="seotudy-tabsContent">
				
					<!--HOME-->
					<div class="tabContent">
						<form action="" method="post" data-type="seotudy-title-desc-save">
							<input type="hidden" name="step" value="home" />
							<div class="tabContentCol col-lg-12">
								
								<div class="tabContentHead">
									<?=__('Home','seotudy');?>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=__('Home Title','seotudy');?></label>
											<input type="text" name="seotudy_home_title" placeholder="%postTitle% %sep% %sitename%" value="<?=get_option( 'seotudy_home_title' )?get_option( 'seotudy_home_title' ):'%postTitle% %sep% %sitename%'?>"/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=__('Home Description','seotudy');?></label>
											<input type="text" name="seotudy_home_desc" placeholder="%postDesc%" value="<?=get_option( 'seotudy_home_desc' )?get_option( 'seotudy_home_desc' ):'%postDesc%'?>"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tabContentCol col-lg-12">	
								<div class="seotudy-buttons">
									<button class="home-seo-btn saving-btn"><?=__('Save','seotudy')?></button>
									<div class="ajax-result"></div>
								</div>
								
							</div>
						</form>
					</div>
					<!--HOME-->
					
					<!-- TITLE DESC -->
					<div class="tabContent">
						<form action="" method="post" data-type="seotudy-title-desc-save">
							<input type="hidden" name="step" value="titles" />
							<div class="tabContentCol col-lg-12">
							
								<div class="col-12">
									<?php 
										$post_types = get_post_types('','names');
										unset($post_types['attachment']);
										unset($post_types['revision']);
										unset($post_types['nav_menu_item']);
										unset($post_types['custom_css']);
										unset($post_types['customize_changeset']);
										unset($post_types['oembed_cache']);
										foreach ( $post_types as $post_type ) {
											$a = get_post_type_object($post_type);
									?>
									<div class="tabContentHead">
										<?=$a->label?>
									</div>
									
									<div class="row">
										<div class="col-lg-6">
											<div class="seotudy-formElement labelUp">
												<label for=""><?=$a->label?> <?=__('Title','seotudy');?></label>
												<input type="text" name="seotudy_<?=$post_type?>_title" placeholder="%postTitle% %sep% %sitename%" value="<?=get_option( 'seotudy_'.$a->name.'_title' )?get_option( 'seotudy_'.$a->name.'_title' ):'%postTitle% %sep% %sitename%'?>"/>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="seotudy-formElement labelUp">
												<label for=""><?=$a->label?> <?=__('Description','seotudy');?></label>
												<input type="text" name="seotudy_<?=$post_type?>_desc" placeholder="%postDesc%" value="<?=get_option( 'seotudy_'.$a->name.'_desc' )?get_option( 'seotudy_'.$a->name.'_desc' ):'%postDesc%'?>"/>
											</div>
										</div>
									</div>
									<?php
										}
									?>
								</div>
							</div>
							<div class="tabContentCol col-lg-12">
								<div class="seotudy-buttons">
									<button class="home-seo-btn saving-btn"><?=__('Save','seotudy')?></button>
									<div class="ajax-result"></div>
								</div>
							</div>
						</form>
					</div>
					<!-- TITLE DESC -->
					
					<!-- TAXONOMY -->
					<div class="tabContent">
						<form action="" method="post" data-type="seotudy-title-desc-save">
							<input type="hidden" name="step" value="taxonomy" />
							<div class="tabContentCol col-lg-12">
								<?php 
									$post_types = get_post_types('','names');
									$taxonomy = get_object_taxonomies($post_types,'objects');
									foreach ($taxonomy as $t) {
									   //print_r($t);
									   if($t->rewrite != null){
								?>
								<div class="tabContentHead">
									<?=$t->label?>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=$t->label?> <?=__('Title','seotudy');?></label>
											<input type="text" name="seotudy_<?=$t->name?>_title" placeholder="%postTitle% %sep% %sitename%" value="<?=get_option( 'seotudy_'.$t->name.'_title' )?get_option( 'seotudy_'.$t->name.'_title' ):'%postTitle% %sep% %sitename%'?>"/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=$t->label?> <?=__('Description','seotudy');?></label>
											<input type="text" name="seotudy_<?=$t->name?>_desc" placeholder="%postDesc%" value="<?=get_option( 'seotudy_'.$t->name.'_desc' )?get_option( 'seotudy_'.$t->name.'_desc' ):'%postDesc%'?>"/>
										</div>
									</div>
								</div>
								<?php
										}
									}
								?>
							</div>
							<div class="tabContentCol col-lg-12">
								<div class="seotudy-buttons">
									<button class="home-seo-btn saving-btn"><?=__('Save','seotudy')?></button>
									<div class="ajax-result"></div>
								</div>
							</div>
						</form>
					</div>
					<!-- TAXONOMY -->
					
					<!--MEDIA-->
					<div class="tabContent">
						<form action="" method="post" data-type="seotudy-title-desc-save">
							<input type="hidden" name="step" value="media" />
							<div class="tabContentCol col-lg-12">
								
								<div class="tabContentHead">
									<?=__('Media','seotudy')?>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=__('Media Title','seotudy');?></label>
											<input type="text" name="seotudy_attachment_title" placeholder="%postTitle% %sep% %sitename%" value="<?=get_option( 'seotudy_attachment_title' )?get_option( 'seotudy_attachment_title' ):'%postTitle% %sep% %sitename%'?>"/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=__('Media Description','seotudy');?></label>
											<input type="text" name="seotudy_attachment_desc" placeholder="%postDesc%" value="<?=get_option( 'seotudy_attachment_desc' )?get_option( 'seotudy_attachment_desc' ):'%postDesc%'?>"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tabContentCol col-lg-12">	
								<div class="seotudy-buttons">
									<button class="home-seo-btn saving-btn"><?=__('Save','seotudy')?></button>
									<div class="ajax-result"></div>
								</div>
							</div>
						</form>
					</div>
					<!--MEDIA-->
					
				</div>
			</div>
			
		</div>
	</div>
</div>