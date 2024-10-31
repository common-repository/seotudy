<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.webtures.com.tr
 * @since      1.0.0
 *
 * @package    Seotudy
 * @subpackage Seotudy/admin/partials
 */
	
	//SECURTY
	$post = $this->seotudy_postSecurty($_POST); 
	extract($post);
	//SECURTY
	
	//DB INFO
	$googleAnalyticCode = !get_option( 'seotudy_googleAnalyticCode' )?'':get_option( 'seotudy_googleAnalyticCode' );
    $googleSCCode = !get_option( 'seotudy_googleSCCode' )?'':get_option( 'seotudy_googleSCCode' );
    $yandexMetrica = !get_option( 'seotudy_yandexMetrica' )?'':get_option( 'seotudy_yandexMetrica' );
    $autoAlt = !get_option( 'seotudy_autoAlt' )?'':get_option( 'seotudy_autoAlt' );
    $autoSefName = !get_option( 'seotudy_autoSefName' )?'':get_option( 'seotudy_autoSefName' );
    $autoHtag = !get_option( 'seotudy_autoHtag' )?'':get_option( 'seotudy_autoHtag' );
    $ogTag = !get_option( 'seotudy_ogTag' )?'':get_option( 'seotudy_ogTag' );
    $wordpressSsl = !get_option( 'seotudy_wordpressSsl' )?'':get_option( 'seotudy_wordpressSsl' );
    $wpjson = !get_option( 'seotudy_wpjson' )?'':get_option( 'seotudy_wpjson' );
    $generateSitemap = !get_option( 'seotudy_generateSitemap')?'':get_option( 'seotudy_generateSitemap' );
    $titleAndDescActive = !get_option( 'seotudy_titleAndDescActive')?'':get_option( 'seotudy_titleAndDescActive' );
	//DB INFO
	
	require "seotudy-header.php";
	
?>
<section class="seotudy-content">
	<div class="container-fluid">
		<div class="row row-no-padding">
			
			<div class="col-lg-2 col-md-3">
				
				<div class="seotudy-tabs pageHeader">
					<div class="tab active">
						<i class="fas fa-cog"></i>
						<?=__('General','seotudy')?>
						<div class="new-notice"></div>
					</div>
					<div class="tab">
						<i class="fas fa-file-code"></i>
						<?=__('File Manager','seotudy')?>
					</div>
					<div class="tab">
						<i class="fas fa-link"></i>
						<?=__('Permalink Manager','seotudy')?>
					</div>
					<div class="tab">
						<i class="fas fa-external-link-alt"></i>
						<?=__('Keyword Linking','seotudy')?>
					</div>
					<!--
					<div class="tab">
						<i class="fas fa-font"></i>
						<?=__('Titles','seotudy')?>
					</div>
					<div class="tab">
						<i class="far fa-image"></i>
						<?=__('Image','seotudy')?>
					</div>
					-->
				</div>
				
			</div>
			<div class="col-lg-10 col-md-9">
				<div class="seotudy-tabsContent">
					
					<!-- GENERAL SETTINGS -->
					<div class="tabContent">
						<form action="" method="post" class="general-settings-frm" data-type="seotudy-general-settings-save">
							<input type="hidden" name="step" value="general" />
							<div class="tabContentCol col-lg-12">
								
								<div class="tabContentHead">
									<?=__('Seotudy Settings','seotudy')?>
								</div>
								
								<div class="seotudy-formElement">
									<div class="checkbox">
                                    <input type="checkbox" id="titleAndDescActive" name="titleAndDescActive" value="1" <?=$titleAndDescActive=='1'?'checked':''?>/>
										<label for="titleAndDescActive"><?=__('Title And Description Active','seotudy')?></label>
									</div>
									<div class="checkbox">
										<input type="checkbox" id="autoAlt" name="autoAlt" value="1" <?=$autoAlt=='1'?'checked':''?>/>
										<label for="autoAlt"><?=__('Image Alt Add Enable','seotudy')?></label>
									</div>
									<div class="checkbox">
                                    <input type="checkbox" id="wpjson" name="wpjson" value="1" <?=$wpjson=='1'?'checked':''?>/>
										<label for="wpjson"><?=__('Wp-Json Securty Enable','seotudy')?></label>
									</div>
									<div class="checkbox">
										<input type="checkbox" id="wordpressSsl" name="wordpressSsl" value="1" <?=$wordpressSsl=='1'?'checked':''?>/>
										<label for="wordpressSsl"><?=__('SSL Redirect Enable','seotudy')?></label>
									</div>
									<div class="checkbox">
										<input type="checkbox" id="autoSefName" name="autoSefName" value="1" <?=$autoSefName=='1'?'checked':''?>/>
										<label for="autoSefName"><?=__('Uploaded File Rename Enable','seotudy')?></label>
									</div>
									<div class="checkbox new">
										<input type="checkbox" id="autoHtag" name="autoHtag" value="1" <?=$autoHtag=='1'?'checked':''?>/>
										<label for="autoHtag"><?=__('H tag proposal Enable','seotudy')?></label>
									</div>
									<div class="checkbox new">
										<input type="checkbox" id="ogTag" name="ogTag" value="1" <?=$ogTag=='1'?'checked':''?>/>
										<label for="ogTag"><?=__('Open Graph Meta Enable','seotudy')?></label>
									</div>
									<div class="checkbox">
										<input type="checkbox" id="generateSitemap" name="generateSitemap" value="1" <?=$generateSitemap=='1'?'checked':''?> disabled />
										<label for="generateSitemap"><?=__('Generate Sitemap.xml Enable','seotudy')?></label>
									</div>
								</div>
								
							</div>
							
							<div class="tabContentCol col-lg-12">
								
								<div class="tabContentHead">
									<?=__('Google Settings','seotudy')?>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=__('Google Analytic Code','seotudy')?></label>
											<input type="text" name="googleAnalyticCode" placeholder="UA-XXXXXXXX-X" value="<?=$googleAnalyticCode?>"/>
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
											<label for=""><?=__('Google Search Console Code','seotudy')?></label>
											<input type="text" name="googleSCCode" class="googleSCCode" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXX" value="<?=$googleSCCode?>"/>
										</div>
									</div>
								</div>
								
							</div>
							
							<div class="tabContentCol col-lg-12">
								
								<div class="tabContentHead">
									<?=__('Yandex Settings','seotudy')?>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="seotudy-formElement labelUp">
                                        <label for=""><?=__('Yandex Metrica Code','seotudy')?></label>
                                        <input type="text" name="yandexMetrica" class="yandexMetrica" placeholder="XXXXXXXXXXXXXX" value="<?=$yandexMetrica?>"/>
                                    </div>
									</div>
								</div>
								
							</div>
							
							<div class="tabContentCol col-lg-12">
								<div class="seotudy-buttons">
									<button class="general-settings-btn saving-btn"><?=__('Save','seotudy')?></button>
									<div class="ajax-result"></div>
								</div>
							</div>
							
						</form>
					</div>
					<!-- GENERAL SETTINGS -->
					
					<!-- FILES MANAGER -->
					<div class="tabContent"> 
						
						<form action="" method="post" data-type="seotudy-general-settings-save">
							<input type="hidden" name="step" value="filemanagers" />
							<div class="tabContentCol col-lg-12">
								
								<div class="col-lg-6">
									<div class="tabContentHead">
										<?=__('HTACCESS EDITOR','seotudy')?>
									</div>
									
									<div class="textarea">
										<div class="seotudy-formElement">
											<?php
												if(file_exists(ABSPATH.'.htaccess')){
													$htaccess = file_get_contents(ABSPATH.'.htaccess');
												}else{
													$htaccess = '';
												}
											?>
											<textarea cols="70" rows="50" name="htaccess" id="htaccess-code"><?=$htaccess?></textarea>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="tabContentHead">
										<?=__('ROBOTS.TXT EDITOR','seotudy')?>
									</div>
									
									<div class="textarea">
										<div class="seotudy-formElement">
											<?php 
												if(!file_exists(ABSPATH.'robots.txt')){
													file_put_contents(ABSPATH.'robots.txt',"User-agent: * \nAllow: / \nSitemap: ".get_home_url()."/sitemap.xml");
												}
												$robotstxt = file_get_contents(ABSPATH.'robots.txt');
											?>
											<textarea cols="70" rows="50" name="robotstxt" id="robots-code"><?=$robotstxt?></textarea>
										</div>
									</div>
								</div>
							</div>	
							
							<div class="tabContentCol col-lg-12">
								<div class="seotudy-buttons">
									<button class="file-manager-btn saving-btn"><?=__('Save','seotudy')?></button>
									<div class="ajax-result"></div>
								</div>
							</div>
							
						</form>
						
					</div>
					<!-- FILES MANAGER -->
					
					<!-- PERMALINK MANAGER -->
					<div class="tabContent">
						<div class="seotudy-coming-soon"><?=__('Coming Soon','seotudy')?> :)</div>
					</div>
					<!-- PERMALINK MANAGER -->
					
					<!-- KEYWORD LINKING -->
					<div class="tabContent">
						<div class="seotudy-coming-soon"><?=__('Coming Soon','seotudy')?> :)</div>
					</div>
					<!-- KEYWORD LINKING -->
					
				</div>
				
			</div>
		
		</div>
	</div>
</section>