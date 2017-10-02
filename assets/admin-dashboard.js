
$("#submit_add_user").click(function(){
	$('#add_user').validate({
	rules: {
		username: {
		    required: true,
            minlength: 5
		},
		password:{
			required: true,
            minlength: 5
		},
		rePassword:{
			required: true,
            minlength: 5,
			equalTo: "#password"
		},
		email:{
			required: true,
			email: true
		}
	},		
	highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
		$(element).closest('.controls').removeClass('success').addClass('error');
		$(element).closest('.text-add').removeClass('success').addClass('error').addClass('error-text');
	},
	success: function(element) {
		element.addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
	}
	});
	$('#add_user').submit();
	
});
$("#submit_add_category").click(function(){
	var category_name = $('#category_name').val();
	var category = category_name.trim()
	if(category == ''){
		$(".alert_category").show();
		return false;
	}else{
		$(".alert_category").hide();
		$("#add_category").submit();
	}
});

$("#submit_edit_category").click(function(){
	var category_name = $('#category_name_edit').val();
	var category = category_name.trim()
	if(category == ''){
		$(".alert_category_edit").show();
		return false;
	}else{
		$(".alert_category_edit").hide();
		$("#edit_category").submit();
	}
});
function delete_category(id){
    var confirm_delete_category=confirm("Are you sure?");
    if (confirm_delete_category==true){
        location.href=base_url+'form/delete_category?id='+id;
    }
}
function delete_user(id){
	var confirm_delete_user=confirm("Are you sure?");
	if (confirm_delete_user==true){
		location.href=base_url+'form/delete_user?id='+id;
	}
}