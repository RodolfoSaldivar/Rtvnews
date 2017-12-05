


app.controller("SintesisIndex", function($scope, $rootScope, $http)
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

		$scope.sintesis = {
			seccione_id: 'nada',
			tipo: 'nada'
		};
		$scope.media = { 2:0, 3:0, 4:0, 5:0 };
		$scope.$apply();
	});


//----> Cunado escoja una fecha se regresa el valor en el formato deseado
	var $input = $('#fecha').pickadate();
	var picker = $input.pickadate('picker');
	picker.on({close: function()
	{
		$scope.sintesis.fecha = this.get('select', 'yyyymmdd');
		$scope.filtrarNotas();
	}});


//----> Para agregar medias
	$scope.appendMedia = function(tipo, id_c = 0)
	{
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


//----> Cuando selecciona un cliente del autocompletar
	$scope.clienteObtener = function(nombre)
	{
		$http.post("/clientes/obtener", { 'Cliente.nombre': nombre })
		.then(function(response)
		{
			var data = response.data;
			$scope.sintesis.cliente_id = data.Cliente.id_c;
			$scope.filtrarNotas();
		});
	}


//----> Filtra las notas cuando todos los filtros esten llenos
	$scope.filtrarNotas = function()
	{
		if ($scope.sintesis.seccione_id == 'nada') return;
		if ($scope.sintesis.tipo == 'nada') return;
		if (!$scope.sintesis.cliente_id) return;
		if (!$scope.sintesis.fecha) return;

		$("#cargando_notas").find("#cargando").removeClass('hide');

		$http.post("/notas/obtener",
		{
			'Nota.seccione_id': $scope.sintesis.seccione_id,
			'Nota.tipo': $scope.sintesis.tipo,
			'Nota.cliente_id': $scope.sintesis.cliente_id,
			'Nota.fecha': $scope.sintesis.fecha
		})
		.then(function(response)
		{
			var data = response.data;
			console.log(data);
			$("#cargando_notas").find("#cargando").addClass('hide');
		});
	}
});


//----> Para remover medias
function removerMedia(html_id)
{
	$("#"+html_id).remove();
}