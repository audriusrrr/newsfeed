jQuery(function(){

jQuery('#mc-list-populator').on('click', function(e){
  e.preventDefault();
jQuery.ajax({
        url: meta.ajaxurl+'?action=get_client',
        data: {mcID: jQuery('#acf-field-campaign_monitor_api_key').val()},
        type: 'GET',

        success:function(data){
        console.log(data);
        jQuery('#client-filler').html(data);
        },
        error: function(){
            // HD.jQuerycontainer.html('<h2>error</h2>');
            // $this.prop("disabled",false)
        }
});
})


jQuery('#cm-list-populator').on('click', function(e){
  e.preventDefault();
jQuery.ajax({
        url: meta.ajaxurl+'?action=get_lists',
        data: {mcID: jQuery('#acf-field-campaign_monitor_api_key').val(), cID: jQuery('#acf-field-campaign_monitor_client_id').val()},
        type: 'GET',

        success:function(data){
        console.log(data);
        jQuery('#list-filler').html(data);
        },
        error: function(){
            // HD.jQuerycontainer.html('<h2>error</h2>');
            // $this.prop("disabled",false)
        }
});
})





}(jQuery))
