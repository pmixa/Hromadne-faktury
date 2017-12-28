jQuery(document).ready(function($) {
 $('#ic').change( function() {
   var ico = $(this).val();
   
   var data = {
			'action': 'ares',
			'ic': ico
		};
    var url = "<?php echo plugin_dir_url( __FILE__ )."includes/user_extraprofiles.php"; ?>";
    jQuery.post(url, data, function(response) {
			 $('input[name=dic]').val(response.dic);
      $('input[name=firma]').val(response.firma);
      $('input[name=ulice]').val(response.ulice);
      $('input[name=mesto]').val(response.mesto);
      $('input[name=psc]').val(response.psc);
      alert(response);
		});

});
});