


app.controller("ModalGuardarUsuario", function($scope, $rootScope, $http)
{
	$(document).ready(function()
	{
		$('#modal_guardar_usuario').modal({
			dismissible: false,
			ready: function() { $scope.inicializar(1); },
			complete: function() { $scope.inicializar(); }
		});
	});

	$rootScope.$on("AbrirModalGuardarUsuario", function(event,
		usuario_id = 0
	)
	{
		$scope.modal_abierto = 1;
		$('#modal_guardar_usuario').modal('open');

		$http.post("/users/obtener", { id: usuario_id })
		.then(function(response)
		{
			$scope.user = response.data.User;
			$("label[for=us_nombre]").addClass("active");
			$("label[for=us_username]").addClass("active");
			$("label[for=us_password]").addClass("active");
			resetSelect();
		});
    });

	$scope.forma = 'UsuarioGuardarForm';


//=========================================================================
//----> Puras validaciones

	$('#'+$scope.forma).validate({
		rules: {
			'data[User][nombre]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[User][username]': {
				required: true,
				alphanumeric: true,
				maxlength: 50
			},
			'data[User][password]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
				minlength: 8
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
		$scope.$apply(function()
		{
			if ($scope.modal_abierto && abriendo) return;
			$scope.modal_abierto = 1;
			$scope.user = {tipo:'nada'};
			resetSelect();
		});	
	} 


	$("#us_username").donetyping(function(){
		$scope.checarUsername();
	});
	$scope.checarUsername = function()
	{
		$http.post(
			"/users/checar_username",
			{
				nuevo_user: $scope.user.username,
				actual_user: $scope.actual_user
			}
		)
		.then(function(response)
		{
			var data = response.data;
			$scope.user.username = data.username;
			$scope.placeholder = data.placeholder;
			$("#us_username").prop('placeholder', $scope.placeholder);
		});
	}



//----> Cuando se hace submit; primero valida que todo este lleno y despues manda a guardar
	$('#'+$scope.forma).submit(function(event)
	{
		var selects = validarSelects($scope.forma, $scope.atributos);
		var inputs = $('#'+$scope.forma).valid();

		if (selects && inputs)
		{
			$(".modal-footer").find("#cargando").removeClass('hide');
			$("#"+$scope.forma).find("#btn_cancelar").addClass('disabled');
			$("#"+$scope.forma).find("#btn_guardar").prop('disabled', true);
			$scope.guardarUsuario();
		}

		event.preventDefault();
	});



//----> Ajax para guardar el usuario

	$scope.guardarUsuario = function()
	{
		if ($scope.user.id_c) $scope.user.id = $scope.user.id_c;

		$http.post("/users/guardar", { user: $scope.user })
		.then(function(response)
		{
			$(".modal-footer").find("#cargando").addClass('hide');
			$("#"+$scope.forma).find("#btn_cancelar").removeClass('disabled');
			$("#"+$scope.forma).find("#btn_guardar").removeAttr('disabled');

			$('#modal_guardar_usuario').modal('close');

			location.reload();
		});
	}

});
