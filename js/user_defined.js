$(function(){
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
    
    $('.bank_name,.state_name,.dis_name,.city_name,.branch_name,.ifsc_code').chosen({
         width: "100%"
    });
    $('#bank_id').change(function(){
		var bank_id = $(this).val();	
		$.ajax({
			type:"POST",
			url: "get_data.php",
			data : {bankId:bank_id},
			success:function(r){
                             if(window.location.pathname == '/quick-search.html' || window.location.pathname == '/quick-search.php'){
                                    $('#branch_name').html(r);
                                    $("#branch_name").trigger("chosen:updated");
                                } else {
                                    $('#state_id').html(r);
                                    $("#state_id").trigger("chosen:updated");
                                }
                            
                            
                            
				
			}
		});
	});
	$('#state_id').change(function(){
		var state_id = $(this).val();
		var bank_id = $('#bank_id').val();	
		$.ajax({
			type:"POST",
			url: "get_data.php",
			data : {bankId:bank_id,stateId:state_id},
			success:function(r){
				$('#dis_name').html(r);
                                $("#dis_name").trigger("chosen:updated");
			}
		});
	});
	$('#dis_name').change(function(){
		var dis_name = $(this).val();
		var state_id = $('#state_id').val();
		var bank_id = $('#bank_id').val();		
		$.ajax({
			type:"POST",
			url: "get_data.php",
			data : {bankId:bank_id,stateId:state_id,disName : dis_name},
			success:function(r){
				$('#city_name').html(r);
                                $("#city_name").trigger("chosen:updated");
			}
		});
	});
	$('#city_name').change(function(){
		var city_name = $(this).val();	
		var dis_name = $('#dis_name').val();
		var state_id = $('#state_id').val();
		var bank_id = $('#bank_id').val();
		$.ajax({
			type:"POST",
			url: "get_data.php",
			data : {bankId:bank_id,stateId:state_id,disName : dis_name,cityName:city_name},
			success:function(r){
                                if(window.location.pathname == '/find-bank-address.html' || window.location.pathname == '/find-bank-address.php'){
                                    $('#ifsc_code').html(r);
                                    $("#ifsc_code").trigger("chosen:updated");
                                } else {
                                    $('#branch_name').html(r);
                                    $("#branch_name").trigger("chosen:updated");
                                }
				
			}
		});
	});
	
	$('#branch_name').change(function(){
		var branch_name = $(this).val();
		var city_name = $('#city_name').val();	
		var dis_name = $('#dis_name').val();
		var state_id = $('#state_id').val();
		var bank_id = $('#bank_id').val();	
		$.ajax({
			type:"POST",
			url: "get_data.php",
			data : {bankId:bank_id,stateId:state_id,disName : dis_name,cityName:city_name,branchName:branch_name},
			success:function(r){
				$('#info').html(r);
			}
		});
	});
        $('#ifsc_code').change(function(){
		var ifscCode = $(this).val();
		var city_name = $('#city_name').val();	
		var dis_name = $('#dis_name').val();
		var state_id = $('#state_id').val();
		var bank_id = $('#bank_id').val();	
		$.ajax({
			type:"POST",
			url: "get_data.php",
			data : {bankId:bank_id,stateId:state_id,disName : dis_name,cityName:city_name,ifscCode:ifscCode},
			success:function(r){
				$('#info').html(r);
			}
		});
	});
});