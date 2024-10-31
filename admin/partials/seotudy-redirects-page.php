<?php 
    global $wpdb;
    
	//SECURTY
	$post = $this->seotudy_postSecurty($_POST); 
	extract($post);
	//SECURTY
	
	//MULTI DELETE
	if(isset($_POST['r'][0],$_POST['action']) and !empty($_POST['r'][0]) and is_numeric($_POST['r'][0]) and $_POST['action']=='delete'){
		
		if(count($_POST['r']) > 1){
			$sql = implode(',',$_POST['r']);
		}else{
			$sql = $_POST['r'][0];
		}
		$del = $wpdb->query("DELETE FROM seotudy_links WHERE id IN(".$sql.")");
		
	}
	//MULTI DELETE
	
	//SAVE
	$r = ['oldLink','newLink']; //REQUIRED POST
	if($this->seotudy_postControl($r) and $step == 'redirectSave'){
		
		$save = $wpdb->query("INSERT INTO seotudy_links SET link='".$oldLink."',new_link='".$newLink."',status='redirect'");
		
	}
	//SAVE
	
    $redirectsPage = $wpdb->get_results("SELECT * FROM seotudy_links WHERE status != 'backlink' ORDER BY new_link ASC");
    
    $links = [];
    foreach($redirectsPage as $l){
        $links[] = [
            'id' => '<input type="checkbox" name="r[]" value="'.$l->id.'" /><input type="hidden" class="seotudy-redirects-ID" value="'.$l->id.'" />'.$l->id,
            'domain' => '<input type="hidden" class="seotudy-redirects-domain" value="'.str_replace('/','\/',get_bloginfo('url')).'" />'.get_bloginfo('url'),
            'link' => $l->link,
            'new_link' => '<input type="text" class="seotudy-redirects-new-link" value="'.$l->new_link.'"/>',
            'status' => $l->status,
            'edit' => '<input type="submit" class="btn button seotudy-redirects-save-btn button-primary" value="'.__('Save','seotudy').'"/><button class="btn button seotudy-redirects-delete-btn button-link-delete" onclick="return confirm(`'.__('Are You SURE?','seotudy').'`);">'.__('DELETE','seotudy').'</button>',
        ];
    }
    
    $table = new seotudy_table_generator();
    $table->table_thead = [
        'id'        => 'ID',
        'domain'     => 'Domain',
        'link'     => 'Link',
        'new_link'     => 'New Link',
        'status'    => 'Status',
        'edit'    => 'Edit',
    ];
    
    $table->table_data = $links;
    
  //$table->table_data = [
  //    [
  //        'id'        => 'ID',
  //        'link'     => 'Link',
  //        'new_link'     => 'New Link',
  //        //'edit'    => 'Edit',
  //    ],
  //    [
  //        'id'        => 'ID',
  //        'link'     => 'Link',
  //        'new_link'     => 'New Link',
  //        //'edit'    => 'Edit',
  //    ]
  //];

    
    $table->prepare_items();
	
	require "seotudy-header.php";
?>
<section class="seotudy-content">
	<div class="container-fluid">
		
		<form action="" method="post">
			<input type="hidden" name="step" value="redirectSave" />
			<div class="row">
				<div class="col-lg-5">
					<div class="seotudy-formElement labelUp">
						<label for=""><?=__('Old Link','seotudy')?></label>
						<input type="text" name="oldLink" placeholder="/about-us/"/>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="seotudy-formElement labelUp">
						<label for=""><?=__('New Link','seotudy')?></label>
						<input type="text" name="newLink" placeholder="/new-about-us/"/>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="seotudy-buttons seotudy-formElement labelUp">
						<label for="">&nbsp;</label>
						<button><?=__('SAVE','seotudy')?></button>
					</div>
				</div>
			</div>
		</form>
		
		<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
		<form id="redirects-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<!-- Now we can render the completed list table -->
			<?php $table->display() ?>
		</form>
    
	</div>
</section>
