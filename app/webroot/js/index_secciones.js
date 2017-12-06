


app.controller("SeccionesIndex", function($scope, $rootScope, $http)
{
	$scope.variables_php = variables_php;
	$scope.secciones = $scope.variables_php.Secciones;

	$(document).ready(function() {
		$('.modal').modal();
	});

//----> Cambia el estatus del usuario
	$scope.actualizarEstatus = function(id_c, estatus)
	{
		$http.post("/secciones/actualizar_estatus",
		{
			id: id_c,
			estatus: estatus
		});
	}

//----> Abre el modal para guardar contactos
    $scope.editar = function(seccion_id)
	{
        $rootScope.$emit("AbrirModalGuardarSeccion", seccion_id);
    }
});