
// var interval_capturaremail_floating='';
// interval_capturaremail_floating=setInterval(function(){
// 	if(document.querySelectorAll('#capturar_emails').length){
// 		clearInterval(interval_whatsapp_floats);
// 		ativar_scripts_floating();
// 	}
// }, 1);


	// $(document).on('keyup keydown blur', 'form.validate *[data-validate]', function() {
	// 	var object 	= $(this);
	// 	var rule 	= $(this).attr('data-validate').toLowerCase().trim();
	// 	validate_rule(object, rule);

	// 	if($(this).val() != '' && !$(this).hasClass('value_preenchido')) $(this).addClass('value_preenchido');
	// 	else if($(this).val() == '' && $(this).hasClass('value_preenchido')) $(this).removeClass('value_preenchido')
	// });

	var floating_telefone=document.querySelector('#email_popup_capturar_telefone');

	if(floating_telefone != null){
		
		function mask_phone_floating(object) {
			object.setAttribute('maxlength', '15');
			var value = object.value;

			value = value.replace(/\D/g,'');
			value = value.replace(/^(\d\d)(\d)/g,'($1) $2');
			value = value.replace(/(\d{4,})(\d{4})$/,'$1-$2');

			object.value=value;
		}

		floating_telefone.onkeyup = function(){
			mask_phone_floating(this);
		};

		floating_telefone.onkeydown = function(){
			mask_phone_floating(this);	
		};

		floating_telefone.onkeyblur = function(){
			mask_phone_floating(this);
		};

	}