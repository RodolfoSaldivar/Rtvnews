


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
		$scope.nota = {
			seccion: 'nada',
			tipo: 'nada',
			calificacion: 'nada'
		}
		$scope.media = { 2:0, 3:0, 4:0, 5:0 };
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
			$("#cliente_no_existe").css("display", "none");
			$('#cliente_img').attr('src', '/img/logos/'+response.data.Media.nombre);
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
	$scope.appendMedia = function(tipo)
	{
		$http.post("/notas/agregar_media", { 'tipo': tipo, acum: $scope.media[tipo] })
		.then(function(response)
		{
			$("#append_"+tipo).append(response.data);
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