<? if (!$include_flag){exit();} ?>
<!-- CPA Tracker, http://www.cpatracker.ru -->
<!DOCTYPE html>
<html lang="en">
  <head>
	  	<meta name="robots" content="noindex,nofollow">
		<? include "header.php"; ?>
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
  </head>

  <body>
  <? include $page_top_menu; ?>
    <div class="container">
      <div class="row-fluid">
	      <?// include ($sidebar_inc); ?>
        <div class="col-lg-9 col-lg-offset-3">
          <div class="row">
            <? 
            	include ($page_content);
            ?>
           </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->
      <hr>
      
      <footer>
        <? include "footer.php"; ?>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
	<link href="lib/select2/select2.css" rel="stylesheet"/>
	<link href="lib/sortable/bootstrap-sortable.css" rel="stylesheet"/>

    <script src="lib/select2/select2.js"></script>    
    <script src="lib/country-select/jquery-ui-autocomplete.js"></script>
    <script src="lib/country-select/jquery.select-to-autocomplete.min.js"></script>
    <link href="lib/datepicker/css/datepicker.css" rel="stylesheet">
    <script src="lib/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="lib/sortable/bootstrap-sortable.js"></script>
    <script src="lib/sparkline/jquery.sparkline.min.js"></script>
    
    
	<link href="lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
	<link href="lib/datatables/css/dt_bootstrap.css" rel="stylesheet">
	<script src="lib/datatables/js/jquery.dataTables.min.js" charset="utf-8" type="text/javascript"></script>
	<script src="lib/datatables/js/dt_bootstrap.js" charset="utf-8" type="text/javascript"></script>    

	<script>
		jQuery.fn.dataTableExt.oSort['click-data-asc']  = function(a,b) {
			x=$('.clicks', $('<div>'+a+'</div>')).text().split(':',1);
			y=$('.clicks', $('<div>'+b+'</div>')).text().split(':',1);

			if (x==''){x=0;}
			if (y==''){y=0;}
		    x = parseFloat( x );
		    y = parseFloat( y );

		    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
		};
		 
		jQuery.fn.dataTableExt.oSort['click-data-desc'] = function(a,b) 
		{
			x=$('.clicks', $('<div>'+a+'</div>')).text().split(':', 1);
			y=$('.clicks', $('<div>'+b+'</div>')).text().split(':', 1);
			if (x==''){x=0;}
			if (y==''){y=0;}
		    x = parseFloat( x );
		    y = parseFloat( y );
		    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
		};	
		
		$(document).ready(function() 
		{
			$(".select2").select2();

			$(".rule_name").on("keypress", function(event){
				$(this).css('background-color', 'white');
				var key = event.which || event.keyCode; //use event.which if it's truthy, and default to keyCode otherwise
				
		        // Allow: backspace, delete, tab, and enter
		        var controlKeys = [8, 9, 13];
		        //for mozilla these are arrow keys
		        if ($.browser.mozilla) controlKeys = controlKeys.concat([37, 38, 39, 40]);
		
		        // Ctrl+ anything or one of the conttrolKeys is valid
		        var isControlKey = event.ctrlKey || controlKeys.join(",").match(new RegExp(key));
		
		        if (isControlKey) {return;}
		
		        // stop current key press if it's not a number
		        
		        if (!((48 <= key && key <= 57)|| (key>=65 && key<=90) || (key>=97 && key<=122) || (key==45) || (key==95))) {
		        	$(this).css('background-color', 'lightyellow');
		            event.preventDefault();
		            return;
		        }			
			});
    			
			$(".close").on("click", function(event){
				$(this).parent().remove();
			});
			
			$(".rule_group .rule_link_name input[type=text]").on("click", function(event){
				event.stopPropagation();
			});			
			
			$('.country-selector').selectToAutocomplete();

			$('.datepicker').datepicker({weekStart:1, minViewMode:0})
			  .on('changeDate', function(ev){
				  $('.datepicker.dropdown-menu').hide();
			  });
  			
			$('#rule_add_tooltip').tooltip({delay: { show: 300, hide: 100 }});
			$('#link_add_tooltip').tooltip({delay: { show: 300, hide: 100 }});
			$('#manual_import_tooltip').tooltip({delay: { show: 300, hide: 100 }});			
			$('#auto_import_tooltip').tooltip({delay: { show: 300, hide: 100 }});						
			
			$('input[name="link_url"]', $('#form_add_offer')).keypress (function (e) {
				$('input[name="link_url"]', $('#form_add_offer')).css('background-color', 'white'); 
			});
 
			$('input[name="costs_value"]', $('#add_costs')).keypress (function (e) {
				$('input[name="costs_value"]', $('#add_costs')).css('background-color', 'white'); 
			});

			$('input[name="date_start"]', $('#add_costs')).keypress (function (e) {
				$('input[name="date_start"]', $('#add_costs')).css('background-color', 'white'); 
			});

			$('input[name="date_end"]', $('#add_costs')).keypress (function (e) {
				$('input[name="date_end"]', $('#add_costs')).css('background-color', 'white'); 
			});

			$('input[name="email"]', $('#register_admin')).keypress (function (e) {
				$('input[name="email"]', $('#register_admin')).css('background-color', 'white'); 
			});
			$('input[name="password"]', $('#register_admin')).keypress (function (e) {
				$('input[name="password"]', $('#register_admin')).css('background-color', 'white'); 
			});			
			
		});	

		function htmlEncode(value){
		    if (value) {
		        return jQuery('<div />').text(value).html();
		    } else {
		        return '';
		    }
		}
	</script>
  </body>
</html>