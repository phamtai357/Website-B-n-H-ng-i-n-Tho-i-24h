jQuery(function ($)
{
    $.fn.extend({
        _method: function(){
            $this = jQuery(this);
            $state = $this.attr('disable');
            if( $state != 'disable' ){
                $packet = $this.data( 'packet' );
                $method = $this.data( 'method' );
                var request_data = {
                    action: 'kt_ajax_demo_install',
                    kt_demo_action: $method,
                    kt_packet : $packet,
                };
                $this.attr('disable', 'disable');
                $this.closest( '.box-item' ).addClass( 'loading' );
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    cache:false,
                    data: request_data,
                    dataType: 'json',
                    success: function(data, textStatus, XMLHttpRequest){
                        if( $method == 'uninstall' ) {
                            $this.text("Install");
                            $this.data('method', 'install')
                        }else{
                            $this.text("Uninstall");
                            $this.data('method', 'uninstall');
                        }
                        $this.removeAttr('disable');
                        $this.closest( '.box-item' ).removeClass( 'loading' );
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown){
                        $this.removeAttr('disable');
                        $this.closest( '.box-item' ).removeClass( 'loading' );
                        alert( 'Please ! click again to be success import data' );
                    }
                });
            }else{
                return false;
            }
        }
    });
    jQuery( '.box-item .item-button button' ).click(function(){
        jQuery(this)._method();
    });
    jQuery(document).ready(function($){
 		var form = $('#kt_data_installer_page'),
		filters = form.find('.export-filters');
 		filters.hide();
        
 		form.find('input:radio').change(function() {
			filters.slideUp('fast');
			switch ( $(this).val() ) {
				case 'posts': $('#post-filters').slideDown(); break;
				case 'pages': $('#page-filters').slideDown(); break;
			}
 		});
	});
    
});