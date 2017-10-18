function submit_form(){
	$('#form_input').validate({
	rules: {
		category_id: {
		    required: true
		},
		subject_form: {
			required: true
		},
		title_form: {
		    required: true
		},
		'user_to[]': {
		    required: true
		},
		'note_form': {
			required: true
		},
		'deadline[]':{
		    required: true
		},
		'user_assistant[]':{
		    required: true			
		},		
		'userfile[]':{
		    required: true			
		}
	},		
	highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
	},
	success: function(element) {
		element.addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
	}
	});
	//$("#form_input").submit(); 
}

$('#form_input').validate({
	rules: {
		category_id: {
		    required: true
		},
		subject_form: {
			required: true
		},
		title_form: {
		    required: true
		},
		'user_to_1[]': {
		    required: true
		},
		'note_form': {
			required: true
		},
		'deadline[]':{
		    required: true
		},
		'user_assistant[]':{
		    required: true			
		},		
		'userfile[]':{
		    required: true			
		}
	},
		
	highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
	},
	success: function(element) {
		element.addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
	},submitHandler: function() {  
            if($('#user_to_1').val() == null){
                alert('Isi Approval ke 1');
                return false;
            }else if($('#user_assistant').val() == null){ 
                alert('Isi user Assistant');
                return false;
            }else{
		$(".loading").show();
		$("#form_input").submit();
		return;
            }
	}
});