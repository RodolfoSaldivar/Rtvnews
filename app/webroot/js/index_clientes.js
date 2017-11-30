


app.controller("ClientesIndex", function($scope, $rootScope, $http)
{
	$scope.variables_php = variables_php;
	$scope.clientes = $scope.variables_php.Clientes;

	$(document).ready(function() {
		$('.modal').modal();
	});

//----> Cambia el estatus del usuario
	$scope.actualizarEstatus = function(id_c, estatus)
	{
		$http.post("/clientes/actualizar_estatus",
		{
			id: id_c,
			estatus: estatus
		});
	}

//----> Abre el modal para guardar contactos
    $scope.editar = function(cliente_id)
	{
        $rootScope.$emit("AbrirModalGuardarCliente", cliente_id);
    }
});