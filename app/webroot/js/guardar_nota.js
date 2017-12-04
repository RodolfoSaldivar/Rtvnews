


app.controller("NotasIndex", function($scope, $rootScope, $http)
{
	$scope.variables_php = variables_php;

	$(document).ready(function()
	{
		$('#cliente').autocomplete({
			data: $scope.variables_php.clientes_autocompletar,
			onAutocomplete: function(val) {
				$scope.clienteObtener(val);
			}
		});

		$scope.nota = $scope.variables_php.nota.Nota;
		$scope.media = { 2:0, 3:0, 4:0, 5:0 };

		//----> Si viene a editar
		if ($scope.nota.id_c)
		{
			var cliente_nombre = $scope.variables_php.nota.Cliente.nombre;
			$scope.nota.cliente = cliente_nombre;
			$scope.clienteObtener(cliente_nombre);
			$scope.nota.medida_1 = regresarFloat($scope.nota.medida_1);
			$scope.nota.medida_2 = regresarFloat($scope.nota.medida_2);
			$scope.nota.medida_3 = regresarFloat($scope.nota.medida_3);
			var arr_m = Object.keys($scope.variables_php.nota.Medias);
			for (var i = 0; i < arr_m.length ; i++)
			{
				$scope.appendMedia($scope.variables_php.nota.Medias[arr_m[i]], arr_m[i]);
			}
		}

		$scope.$apply();
	});

	$scope.forma = 'NotaIndexForm';


//=========================================================================
//----> Puras validaciones

	$('#'+$scope.forma).validate({
		rules: {
			'data[Nota][cliente]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][autor]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][tema]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][titulo]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][medio]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][genero]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][declarante]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][referente]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][dependiente]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Nota][resumen]': {
				required: true
			},
		}
	});

	$scope.atributos = ['seccion', 'tipo', 'calificacion'];



//----> Cuando selecciona un cliente del autocompletar
	$scope.clienteObtener = function(nombre)
	{
		$http.post("/clientes/obtener", { 'Cliente.nombre': nombre })
		.then(function(response)
		{
			var data = response.data;
			$("#cliente_no_existe").css("display", "none");
			$('#cliente_img').attr('src', '/img/logos/'+data.Media.nombre);
			$scope.nota.cliente_id = data.Cliente.id_c;
		});
	}


//----> Cuando cambia el tipo
	$scope.cambioTipo = function()
	{
		if ($scope.nota.tipo == 2 || $scope.nota.tipo == 3)
		{
			$scope.label_medida_1 = 'HH';
			$scope.label_medida_2 = 'MM';
			$scope.label_medida_3 = 'SS';
		}
		else
		{
			$scope.label_medida_1 = 'Largo';
			$scope.label_medida_2 = 'Ancho';
		}
	}



//----> Para agregar medias
	$scope.appendMedia = function(tipo, id_c = 0)
	{console.log(id_c);
		var acum = $scope.media[tipo];
		$http.post("/notas/agregar_media",
		{
			tipo: tipo,
			acum: acum,
			id_c: id_c
		})
		.then(function(response)
		{
			$("#append_"+tipo).append(response.data);
			if (id_c) $("label[for=media_"+tipo+"_"+acum+"]").addClass("active");
			$scope.media[tipo]++;
		});
	}



//----> Cuando se hace submit; primero valida que todo este lleno y despues manda a guardar
	$('#'+$scope.forma).submit(function(event)
	{
		var selects = validarSelects($scope.forma, $scope.atributos);
		var inputs = $('#'+$scope.forma).valid();
		var cliente = $scope.nota.cliente in $scope.variables_php.clientes_autocompletar;
		if (!cliente) $("#cliente_no_existe").css("display", "inline");
		if (!selects || !inputs || !cliente)
			event.preventDefault();
		else
		{
			$("#cargando").removeClass('hide');
			$("#"+$scope.forma).find("#btn_guardar").prop('disabled', true);
		}
	});

});


//----> Para remover medias
function removerMedia(html_id)
{
	$("#"+html_id).remove();
}