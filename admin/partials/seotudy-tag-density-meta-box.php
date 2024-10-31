<?php 
	global $post;

	$text = (str_replace(array("\n"),array(' '),strip_shortcodes($post->post_content))); //clean shortcode
	$text = (str_replace(array("\n"),array(' '),($post->post_content)));
	$unHtml = array(
		'|<style.*?style>|is',
		'|<script.*?script>|is',
		'|<noscript.*?noscript>|is',
	);
	$text = strip_tags(mb_strtolower(preg_replace($unHtml, '', $text),'utf8'));
	$text = str_replace(array('!',"’",'/','-','+',"","’","'",'&#039;','?','%',',','.'),' ',$text);
	
	$tagDensity = new Seotudy_tag_density();
	$oneWord = $tagDensity->oneWord($text,3,3);
	$twoWord = $tagDensity->twoWord($text,3,3);
	$threeWord = $tagDensity->threeWord($text,3,3);
	
?>
<section>
	<div class="col-10">
		<strong><?=__('One Words','seotudy');?></strong>
		<ul style="column-count: 8;">
			<?php 
				if($oneWord != null){
					foreach($oneWord as $t => $c){
			?>
			<li><?=$t;?> - <strong>(<?=$c?>)</strong></li>
			<?php		
					}
				}else{
					echo __('No Words','seotudy');
				}
			?>
		</ul>
	</div>
	<hr />
	<div class="col-10">
		<strong><?=__('Two Words','seotudy');?></strong>
		<ul style="column-count: 5;">
			<?php 
				if($twoWord != null){
					foreach($twoWord as $t => $c){
			?>
			<li><?=$t;?> - <strong>(<?=$c?>)</strong></li>
			<?php		
					}
				}else{
					echo __('No Words','seotudy');
				}
			?>
		</ul>
	</div>
	<hr />
	<div class="col-10">
		<strong><?=__('Three Words','seotudy');?></strong>
		<ul style="column-count: 5;">
			<?php 
				if($threeWord != null){
					foreach($threeWord as $t => $c){
			?>
			<li><?=$t;?> - <strong>(<?=$c?>)</strong></li>
			<?php		
					}
				}else{
					echo __('No Words','seotudy');
				}
			?>
		</ul>
	</div>
	<div class="clearfix"></div>
</section>
<div class="clearfix"></div>