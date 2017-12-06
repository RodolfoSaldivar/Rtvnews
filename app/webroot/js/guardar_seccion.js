


app.controller("ModalGuardarSeccion", function($scope, $rootScope, $http)
{
	$(document).ready(function()
	{
		$('#modal_guardar_secciones').modal({
			dismissible: false,
			ready: function() { $scope.inicializar(1); },
			complete: function() { $scope.inicializar(); }
		});
	});

	$rootScope.$on("AbrirModalGuardarSeccion", function(event,
		seccion_id = 0
	)
	{
		$scope.modal_abierto = 1;
		$('#modal_guardar_secciones').modal('open');

		$http.post("/secciones/obtener", { id: seccion_id })
		.then(function(response)
		{
			$scope.seccion = response.data.Seccione;
			$("label[for=se_nombre]").addClass("active");
		});
    });

	$scope.forma = 'SeccionGuardarForm';


//=========================================================================
//----> Puras validaciones

	$('#'+$scope.forma).validate({
		rules: {
			'data[Seccione][nombre]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			}
		}
	});

	$scope.atributos = ['us_tipo'];



//=========================================================================
//----> Cada que se abre el modal hay que inicializar todos los campos
//----> Se inicializan las variables para simular "agregar producto", si se quiere editar alguno, mas adelante vendra como se sobreescriben

	$scope.modal_abierto = 0;
	$scope.inicializar = function(abriendo = 0)
	{
		if ($scope.modal_abierto && abriendo) return;
		$scope.modal_abierto = 1;
		$scope.seccion = {color:'#000000'};
		$scope.$apply();
	}



//----> Cuando se hace submit; primero valida que todo este lleno y despues manda a guardar
	$('#'+$scope.forma).submit(function(event)
	{
		var inputs = $('#'+$scope.forma).valid();

		if (inputs)
		{
			$(".modal-footer").find("#cargando").removeClass('hide');
			$("#"+$scope.forma).find("#btn_cancelar").addClass('disabled');
			$("#"+$scope.forma).find("#btn_guardar").prop('disabled', true);
			$scope.guardarSeccion();
		}

		event.preventDefault();
	});



//----> Ajax para guardar el usuario

	$scope.guardarSeccion = function()
	{
		if ($scope.seccion.id_c) $scope.seccion.id = $scope.seccion.id_c;

		$http.post("/secciones/guardar", { seccion: $scope.seccion })
		.then(function(response)
		{
			$(".modal-footer").find("#cargando").addClass('hide');
			$("#"+$scope.forma).find("#btn_cancelar").removeClass('disabled');
			$("#"+$scope.forma).find("#btn_guardar").removeAttr('disabled');

			$('#modal_guardar_secciones').modal('close');

			location.reload();
		});
	}

});
