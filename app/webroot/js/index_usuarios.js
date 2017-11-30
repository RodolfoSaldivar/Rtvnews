


app.controller("UsersIndex", function($scope, $rootScope, $http)
{
	$scope.variables_php = variables_php;
	$scope.users = $scope.variables_php.Users;

	$(document).ready(function() {
		$('.modal').modal();
	});

//----> Cambia el estatus del usuario
	$scope.actualizarEstatus = function(id_c, estatus)
	{
		$http.post("/users/actualizar_estatus",
		{
			id: id_c,
			estatus: estatus
		});
	}

//----> Abre el modal para guardar contactos
    $scope.editar = function(usuario_id)
	{
        $rootScope.$emit("AbrirModalGuardarUsuario", usuario_id);
    }
});