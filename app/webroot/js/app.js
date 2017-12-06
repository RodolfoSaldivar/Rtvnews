


//=========================================================================
// Angular


var app = angular.module("App", []);

app.filter('length', function() {
	return function(object) {
		return Object.keys(object).length;
	}
});



//=========================================================================
// Jquery


$.validator.messages.required = '*Requerido';
$.validator.messages.number = '*Número inválido';
$.validator.messages.equalTo = '*Mismo valor';
$.validator.messages.alphanumeric = '*Omitir [, ] y enters';
$.validator.messages.lettersonly = '*Solo letras y números';
$.validator.messages.email = '*Correo electrónico invalido';
$.validator.messages.min = '*Igual o mayor a {0}';
$.validator.messages.max = '*Igual o menor a {0}';
$.validator.messages.digits = '*Solo números enteros';
$.validator.messages.minlength = "*Mínimo {0} caracteres";
$.validator.messages.maxlength = "*Máximo {0} caracteres";


$(document).ready(function(){
	resetSelect();
	resetDrop();
});

//Función para regresar el parse Float
function regresarFloat(numero){
	return parseFloat(String(numero).replace(/[^\d\.]/g,''));
}

//Flecha de hasta arriba
$(window).scroll(function() {
	if ( $(window).scrollTop() > $(window).height() ) {
		$('a.hasta_arriba').fadeIn('slow');
	} else {
		$('a.hasta_arriba').fadeOut('slow');
	}
});

$('a.hasta_arriba').click(function() {
	$('html, body').animate({
		scrollTop: 0
	}, 700);
	return false;
});

// Resetear los componentes de materialize
function resetSelect()
{
	setTimeout(function() {
		$('select').material_select();
	}, 200);
}

function resetDrop()
{
	setTimeout(function() {
		$('.dropdown-button').dropdown({
			belowOrigin: true,
			stopPropagation: true
		});
	}, 200);
}

// Validar selects para que sean requeridos
function validarSelects(forma, atributos)
{
	var correcto = true;

	atributos.forEach(function(atributo)
	{
		if(!$('#'+atributo).val()) {
			$("#"+atributo+"-error").css("display", "initial");
			correcto = false
		}
	});

	atributos.forEach(function(atributo)
	{
		$(document).on("change", "#"+atributo, function() {
			$("#"+atributo+"-error").css("display", "none");
		});
	});

	return correcto;
}

// Llamar al toast
function toast(mensaje, segundos = 7) {
	Materialize.toast(mensaje, segundos * 1000)
}