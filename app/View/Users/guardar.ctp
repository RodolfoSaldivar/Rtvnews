

<div ng-controller="UsersGuardar">

<!-- //========================================================================= -->

<?php echo $this->Form->create() ?>

<h4>Guardar Usuario</h4>

<input class="hide" name="data[User][id]" ng-model="user.id_c">

<div class="row">
	<div class="input-field col s12 m6">
		<input type="text" id="nombre" name="data[User][nombre]" ng-model="user.nombre">
		<label for="nombre">
			Nombre Completo
			<label id="nombre-error" class="error validation_label" for="nombre"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 m6">
		<input type="text" id="username" name="data[User][username]" ng-model="user.username">
		<label for="username">
			Correo
			<label id="username-error" class="error validation_label" for="username"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 m6">
		<input type="text" id="password" name="data[User][password]" ng-model="user.password">
		<label for="password">
			Contraseña
			<label id="password-error" class="error validation_label" for="password"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 m6">
		<select id="tipo" name="data[User][tipo]" ng-model="user.tipo">
			<option value="nada" disabled>Seleccione</option>
			<option value="1">Administrador</option>
			<option value="2">Cliente</option>
		</select>
		<label>Tipo <label id="tipo-error" class="validation_label">*Requerido</label></label>
	</div>
</div>

<button class="btn waves-effect waves-light" type="submit" name="action">
	Guardar
	<i class="material-icons right">save</i>
</button>

<?php echo $this->Form->end(); ?>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>


app.controller("UsersGuardar", function($scope, $rootScope, $http)
{
	$scope.forma = 'UserGuardarForm';


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
				maxlength: 50,
				email: true
			},
			'data[User][password]': {
				required: true,
				alphanumeric: true,
				maxlength: 100,
				minlength: 8
			}
		}
	});

	$scope.atributos = ['tipo'];

	$scope.variables_php = <?php echo $variables_php ?>;
	$scope.user = $scope.variables_php.User;
	$scope.actual_user = $scope.variables_php.User.username;
	$scope.tipo = $scope.variables_php.User.tipo;
	$scope.placeholder = '';

	$("#username").donetyping(function(){
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
			$("#username").prop('placeholder', $scope.placeholder);
		});
	}

	$('#'+$scope.forma).submit(function(event)
	{
		var selects = validarSelects($scope.forma, $scope.atributos);
		var inputs = $('#'+$scope.forma).valid();

		if (!selects || !inputs)
			event.preventDefault();
	});

});


<?php $this->Html->scriptEnd(); ?>