


app.controller("ModalGuardarCliente", function($scope, $rootScope, $http)
{
	$(document).ready(function()
	{
		$('#modal_guardar_cliente').modal({
			dismissible: false,
			ready: function() { $scope.inicializar(1); },
			complete: function() { $scope.inicializar(); }
		});
	});

	$rootScope.$on("AbrirModalGuardarCliente", function(event,
		cliente_id = 0
	)
	{
		$scope.modal_abierto = 1;
		$('#modal_guardar_cliente').modal('open');

		$http.post("/clientes/obtener", { id: cliente_id })
		.then(function(response)
		{
			$scope.user = response.data.Cliente;
			$("label[for=cl_nombre]").addClass("active");
			resetSelect();
		});
    });

	$scope.forma = 'ClienteGuardarForm';


//=========================================================================
//----> Puras validaciones

	$('#'+$scope.forma).validate({
		rules: {
			'data[Cliente][nombre]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
			},
			'data[Cliente][logo]': {
				required: true,
				alphanumeric: true
			}
		}
	});



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
			$scope.cliente = {};
			resetSelect();
		});	
	}


//----> Para desplegar la imagen cuando la selecciona
	$scope.desplegarImg = function()
	{
		var input = $("#cl_logo")[0];
		if (input.files && input.files[0]) {
		    var reader = new FileReader();

		    reader.onload = function (e) {
		        $('#cl_imagen').attr('src', e.target.result);
		        console.log('e.target: ', e.target);
		    }

		    reader.readAsDataURL(input.files[0]);
		    $scope.cliente.logo = input.files[0];
		}
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
			$scope.guardarCliente();
		}

		event.preventDefault();
	});



//----> Ajax para guardar el usuario

	$scope.guardarCliente = function()
	{
		if ($scope.cliente.id_c) $scope.cliente.id = $scope.cliente.id_c;

		$http.post("/clientes/guardar", { cliente: $scope.cliente })
		.then(function(response)
		{
			// $(".modal-footer").find("#cargando").addClass('hide');
			// $("#"+$scope.forma).find("#btn_cancelar").removeClass('disabled');
			// $("#"+$scope.forma).find("#btn_guardar").removeAttr('disabled');

			// $('#modal_guardar_cliente').modal('close');

			// location.reload();
		});
	}

});
