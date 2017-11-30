

<div ng-controller="UsersLogin">

<!-- //========================================================================= -->

<?php echo $this->Form->create() ?>

<br><br><br><br>
<div class="row">
	<div class="input-field col s8 m6 l4 offset-s2 offset-m3 offset-l4">
		<input type="text" id="username" name="data[User][username]" ng-model="username">
		<label for="username">
			Correo
			<label id="username-error" class="error validation_label" for="username"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s8 m6 l4 offset-s2 offset-m3 offset-l4">
		<input type="password" id="password" name="data[User][password]" ng-model="password">
		<label for="password">
			Contraseña
			<label id="password-error" class="error validation_label" for="password"></label>
		</label>
	</div>
</div>

<div class="row center">
	<button class="btn waves-effect waves-light" type="submit" name="action">
		Entrar
	</button>
</div>


<?php echo $this->Form->end(); ?>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>


app.controller("UsersLogin", function($scope, $rootScope, $http)
{
	$scope.forma = 'UserLoginForm';

	$('#'+$scope.forma).validate({
		rules: {
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
});


<?php $this->Html->scriptEnd(); ?>