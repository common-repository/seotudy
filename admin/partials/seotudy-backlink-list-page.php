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
    $redirectsPage = $wpdb->get_results("SELECT * FROM seotudy_links WHERE status = 'backlink'");
    
    $links = [];
    foreach($redirectsPage as $l){
        $links[] = [
            'id' => '<input type="checkbox" name="r[]" value="'.$l->id.'" /><input type="hidden" class="seotudy-redirects-ID" value="'.$l->id.'" />'.$l->id,
            'domain' => '<a href="'.$l->link.'" target="_blank">'.$l->link.'</a>',
            'link' => '<a href="'.$l->new_link.'" target="_blank">'.$l->new_link.'</a>',
            'edit' => '<button class="btn button seotudy-redirects-delete-btn button-link-delete" onclick="return confirm(`'.__('Are You SURE?','seotudy').'`);">'.__('DELETE','seotudy').'</button>',
        ];
    }
    
    $table = new seotudy_table_generator();
    $table->table_thead = [
        'id'        => 'ID',
        'domain'     => 'Backlink Link',
        'link'     => 'Your Link',
        'edit'    => 'Edit',
    ];
    
    $table->table_data = $links;
    
    $table->prepare_items();
	
	require "seotudy-header.php";
?>
<section class="seotudy-content">
	<div class="container-fluid">

		<form id="redirects-filter" method="post">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $table->display() ?>
		</form>
    
	</div>
</section>
