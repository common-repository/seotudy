<?php 
    global $wpdb;
    
    $errorPage = $wpdb->get_results("SELECT * FROM seotudy_links WHERE status = '404' ORDER BY new_link ASC");
    
    $links = [];
    foreach($errorPage as $l){
        $links[] = [
            'id' => '<input type="hidden" class="seotudy-error-ID" value="'.$l->id.'" />'.$l->id,
            'domain' => '<input type="hidden" class="seotudy-error-domain" value="'.str_replace('/','\/',get_bloginfo('url')).'" />'.get_bloginfo('url'),
            'link' => $l->link,
            'new_link' => '<input type="text" class="seotudy-error-new-link" value="'.$l->new_link.'"/>',
            'edit' => '<input type="submit" class="btn button seotudy-error-save-btn button-primary" value="'.__('Save','seotudy').'"/><button class="btn button seotudy-error-delete-btn button-link-delete" onclick="return confirm(`'.__('Are You SURE?','seotudy').'`);">'.__('DELETE','seotudy').'</button>',
        ];
    }
    
    $table = new seotudy_table_generator();
    $table->table_thead = [
        'id'        => 'ID',
        'domain'     => 'Domain',
        'link'     => 'Link',
        'new_link'     => 'New Link',
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

?>
<div class="wrap">
    
    <div id="icon-users" class="icon32"><br/></div>
    <h2><?=__('All 404 Page','seotudy');?></h2>
    
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="error-filter" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
        <?php $table->display() ?>
    </form>
    
</div>
