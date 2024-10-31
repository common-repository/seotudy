<div class="seotudy-searchEnginePreview">

    <input type="hidden" class="sep" value="-"/>
    <input type="hidden" class="sitename" value="<?=get_bloginfo('name')?>"/>
    <?php 
        global $post;

		if(isset($post->ID)){
			$seotudy_title = get_post_meta($post->ID,'seotudy_title',true);
			$seotudy_desc = get_post_meta($post->ID,'seotudy_description',true);
		}else if(isset($_GET['tag_ID'])){
			$term_id = $_GET['tag_ID'];
			$seotudy_title = get_term_meta($term_id,'seotudy_title',true);
			$seotudy_desc = get_term_meta($term_id,'seotudy_description',true);
		}else{
			echo 4;
		}
		//$post_type = get_post_type($post->ID);
    ?>
    
    <div class="seotudy-formElement labelUp">
        <label for="postTitle"><?=__('Title','seotudy');?></label>
        <input type="text" id="postTitle" name="seotudy_title" value="<?=!empty($seotudy_title)?$seotudy_title:''?>"/>
    </div>
    
    <div class="seotudy-formElement labelUp">
        <label for="postDesc"><?=__('Description','seotudy');?></label>
        <textarea name="seotudy_description" id="postDesc" cols="30" rows="10" maxlength="320"><?=!empty($seotudy_desc)?$seotudy_desc:''?></textarea>
    </div>
	
	<!--
    <div class="col-10">
        <h2 class="preview-title"><?=__('Search Engines Preview')?></h2>
        <hr />
        <div class="seotudy-tabs">
            <div class="tab active"><?=__('Google')?></div>
            <div class="tab"><?=__('Yandex')?></div>
        </div>
        
        <div class="tabsContent seotudy-engines-preview">
            <div class="tabContent seotudy-google-preview">
                <div class="title"><?=$seotudy_title?></div>
                <div class="url"></div>
                <div class="desc"></div>
            </div>
            <div class="tabContent seotudy-yandex-preview">
                <div class="title"><div class="favicon"></div></div>
                <div class="url"></div>
                <div class="desc"></div>
            </div>
        </div>
    </div>
	-->
	<div class="clearfix"></div>
</div>
<div class="clearfix"></div>