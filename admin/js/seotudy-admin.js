jQuery(document).ready(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
     
    //seotudy-tabs
    $('.seotudy-tabsContent .tabContent').hide();
    $('.seotudy-tabsContent .tabContent:eq(0)').show();
    $('.seotudy-tabs .tab').on('click',function(){
        
        var tabIndex = $(this).index();
        
        $('.seotudy-tabsContent .tabContent').hide();
        $('.seotudy-tabsContent .tabContent:eq('+tabIndex+')').show();
        
        $('.seotudy-tabs .tab').removeClass('active');
        $(this).addClass('active');
    });
    //seotudy-tabs
    
    //SC META
    $('.googleSCCode').on('keyup',function(){

        const regex = /<meta name="google-site-verification" content="(.*?)" \/>/g;
        const str = $(this).val();
        let m;

        while ((m = regex.exec(str)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (m.index === regex.lastIndex) {
                regex.lastIndex++;
            }
            
            // The result can be accessed through the `m`-variable.
            m.forEach((match, groupIndex) => {
                $(this).val(match);
            });
        }
        
    });
    //SC META
    
    //YANDEX METRİCA
    $('.yandexMetrica').on('keyup',function(){
        
        const regex = /id:(.*?),/g;
        const str = $(this).val();
        let m;

        while ((m = regex.exec(str)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (m.index === regex.lastIndex) {
                regex.lastIndex++;
            }
            
            // The result can be accessed through the `m`-variable.
            m.forEach((match, groupIndex) => {
                $(this).val(match);
            });
        }
        
    });
    //YANDEX METRİCA
    
	/*
    //AUTO PREVIEW
        // TITLE
        if($('.seotudy-searchEnginePreview').length > 0){
            var titlePar = $('.seotudy-searchEnginePreview #postTitle').attr('placeholder');
            var sep = $('.seotudy-searchEnginePreview .sep').val();
            var sitename = $('.seotudy-searchEnginePreview .sitename').val();
            var titleOrj = $('#titlewrap #title').val(); //Post title
            var titlePar = titlePar.replace('%postTitle%',titleOrj);
            var titlePar = titlePar.replace('%sep%',sep);
            var titlePar = titlePar.replace('%sitename%',sitename);
            $('.engines-preview .title').text(titlePar);
            if($('.seotudy-searchEnginePreview #postTitle').val() == ''){
                $('.seotudy-searchEnginePreview #postTitle').val(titlePar);
            }
            $('#titlewrap #title').on('keyup',function(){
                var titlePar = $('.seotudy-searchEnginePreview #postTitle').attr('placeholder');
                var title = $(this).val().substring(0, 120);
                var titlePar = titlePar.replace('%postTitle%',title);
                var titlePar = titlePar.replace('%sep%',sep);
                var titlePar = titlePar.replace('%sitename%',sitename);
                $('.engines-preview .title').text(titlePar);
                $('.seotudy-searchEnginePreview #postTitle').val(titlePar);
            });
            
            $('.seotudy-searchEnginePreview #postTitle').on('keyup',function(){
                var title = $(this).val();
                if(title.trim().length > 0){
                    var title = title.replace('%postTitle%',titleOrj);
                    var title = title.replace('%sep%',sep);
                    var title = title.replace('%sitename%',sitename);
                    $('.engines-preview .title').text(title);
                }
            });
        }
        // TITLE
        
        // DESC
        if($('.seotudy-searchEnginePreview').length > 0){
            var descPar = $('.seotudy-searchEnginePreview #postDesc').attr('placeholder');
            var sep = $('.seotudy-searchEnginePreview .sep').val();
            var sitename = $('.seotudy-searchEnginePreview .sitename').val();
            if(descPar == ''){
                var descOrj = $('#wp-content-editor-container .wp-editor-area').val(); //Post desc
            }else{
                descOrj = descPar;
            }
            var descPar = descPar.replace('%postDesc%',descOrj);
            var descPar = descPar.replace('%sep%',sep);
            var descPar = descPar.replace('%sitename%',sitename);
            var descPar = descPar.substring(0, 320);
            $('.engines-preview .desc').text(descPar);
            if($('.seotudy-searchEnginePreview #postDesc').val() == ''){
                $('.seotudy-searchEnginePreview #postDesc').val(descPar);
            }
            $('#wp-content-editor-container .wp-editor-area').on('keyup',function(){
                var descPar = $('.seotudy-searchEnginePreview #postDesc').attr('placeholder');
                var desc = $(this).val().substring(0, 320);
                var descPar = descPar.replace('%postDesc%',desc);
                var descPar = descPar.replace('%sep%',sep);
                var descPar = descPar.replace('%sitename%',sitename);
                var descPar = descPar.substring(0, 320);
                $('.engines-preview .desc').text(descPar);
                $('.seotudy-searchEnginePreview #postDesc').text(descPar);
            });
            
            $('.seotudy-searchEnginePreview #postDesc').on('keyup',function(){
                var desc = $(this).val().substring(0, 320);
                if(desc.trim().length > 0){
                    var desc = desc.replace('%postDesc%',descOrj);
                    var desc = desc.replace('%sep%',sep);
                    var desc = desc.replace('%sitename%',sitename);
                    $('.engines-preview .desc').text(desc);
                }
            });
        }
        // DESC
        
    //AUTO PREVIEW
    */
	
    //404 LINK SAVE
    $('.seotudy-error-save-btn').on('click',function(){
        var i = $(this).parent().parent();
        
        var ID = $(' .seotudy-error-ID',i).val();
        var newLink = $(' .seotudy-error-new-link',i).val();
        
        var data = {
			'action': 'seotudy_ajax_post',
			'type': 'seotudy-error-link-save',
			'errorID': ID,
			'errorNewLink': newLink,
		};
        
        jQuery.post(ajaxurl, data, function(response) {
			alert(response);
		});
        
        return false;
    });
    //404 LINK SAVE
    
	
    //404 LİNK DELETE
    $('.seotudy-error-delete-btn').on('click',function(){
        var i = $(this).parent().parent();
        
        var ID = $(' .seotudy-error-ID',i).val();
        var newLink = $(' .seotudy-error-new-link',i).val();
        
        var data = {
			'action': 'seotudy_ajax_post',
			'type': 'seotudy-error-link-delete',
			'errorID': ID,
			'errorNewLink': newLink,
		};
        
        jQuery.post(ajaxurl, data, function(response) {
			alert(response);
            location.reload();
		});
        
        return false;
    });
    //404 LİNK DELETE
    
	//REDIRECT  LINK SAVE
    $('.seotudy-redirects-save-btn').on('click',function(){
        var i = $(this).parent().parent();
        
        var ID = $(' .seotudy-redirects-ID',i).val();
        var newLink = $(' .seotudy-redirects-new-link',i).val();
        
        var data = {
			'action': 'seotudy_ajax_post',
			'type': 'seotudy-redirects-link-save',
			'redirectsID': ID,
			'redirectsNewLink': newLink,
		};
        
        jQuery.post(ajaxurl, data, function(response) {
			alert(response);
		});
        
        return false;
    });
    //REDIRECT  LINK SAVE
	
	//REDIRECT LİNK DELETE
    $('.seotudy-redirects-delete-btn').on('click',function(){
        var i = $(this).parent().parent();
        
        var ID = $(' .seotudy-redirects-ID',i).val();
        var newLink = $(' .seotudy-redirects-new-link',i).val();
        
        var data = {
			'action': 'seotudy_ajax_post',
			'type': 'seotudy-redirects-link-delete',
			'redirectsID': ID,
			'redirectsNewLink': newLink,
		};
        
        jQuery.post(ajaxurl, data, function(response) {
			alert(response);
            location.reload();
		});
        
        return false;
    });
    //REDIRECT LİNK DELETE
	
    //404 LINK PASTE CLEAN
    $('.error-new-link').on('keyup',function(){
        
        var domain = $('.seotudy-error-domain').val();
        var url = $(this).val();
        
        var replace = new RegExp(domain,"g");       
        var r = url.replace(replace,'');
        
        $(this).val(r);
        
    });
    //404 LINK PASTE CLEAN
    
	//AUTO REDIRECT
	$('.edit-slug-buttons .save').on('click',function(){
		
	});
	//AUTO REDIRECT
	
	//FILEMANAGER
	/*
	var htaccess = CodeMirror.fromTextArea(document.getElementById("htaccess-code"), {
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: true
	});
	htaccess.setOption("theme", 'blackboard');
	var robots = CodeMirror.fromTextArea(document.getElementById("robots-code"), {
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: true
	});
	robots.setOption("theme", 'blackboard');
	*/
	//FILEMANAGER
	
	//AUTO H GENERATOR
	var suggestCallBack;
	var GAPI = '//www.google.com/complete/search?output=firefox&q=';
	
	
	
	$('#titlewrap input').on('keyup',function(){
		var title = $(this).val();
		
		if(title.length >= 3){
			$.getJSON("//suggestqueries.google.com/complete/search?callback=?",
				{
				  "hl":"en", // Language
				  //"ds":"yt", // Restrict lookup to youtube
				  "jsonp":"gapi_results", // jsonp callback function name
				  "q":title, // query term
				  "client":"firefox" // force youtube style response, i.e. jsonp
				}
			);
			
		}else{
			$('.h2-tag-1').val("");
			$('.h3-tag-1').val("");
		}
		
	});
	//AUTO H GENERATOR
	
	//GENERAL SETTINGS SAVE
    $('.saving-btn').on('click',function(){
		
		var form = $(this).parent().parent().parent();
        var type = $(form).data('type');
		
        var data = {
			'action': 'seotudy_ajax_post',
			'type': type,
			'form': $("form.general-settings-frm").serialize(),
		};
		
		$('.ajax-result',form).html('<i class="fas fa-spinner"></i>');
		
        ////HATALI
		//var formData = new FormData(jQuery('.general-settings-frm')[0]);
		var fromElements = $(form).serialize();
		var formData = new FormData();
		formData.append('action','seotudy_ajax_post');
		formData.append('type',type);
		formData.append('form',fromElements);
		
		$.ajax({
			type           : 'POST',
			url            : ajaxurl,
			data           : formData,
			xhr            : function(){
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(evt){
					if(evt.lengthComputable){
						var percentComplete = (evt.loaded / evt.total) * 100;
						percentComplete = Math.round(percentComplete);
						$('.progress-bar').css('width', percentComplete + '%').text(percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			cache          : false,
			contentType    : false,
			processData    : false,
			success        : function(response){
				$('.ajax-result',form).text(response);
				
				setTimeout(function(){
					$('.ajax-result',form).text('');
				},1000);
				
			},
			error          : function(response){
				$('.ajax-result',form).text(response);
			}
		});
		////HATALI
        
        return false;
    });
	//GENERAL SETTINGS SAVE
	
});

gapi_results = function (data) {
	var suggestions = [];
	$.each(data[1], function(key, val) {
		$('.h2-tag-1').val(data[1][1]);
		$('.h3-tag-1').val(data[1][2]);
	});
};