

<div ng-controller="UsersIndex">

<!-- //========================================================================= -->

<div class="row">
	<div class="col s12 valign-wrapper">
		<h4 class="left">Usuarios</h4>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="btn-floating btn-peque waves-effect waves-light pulse" href="/users/guardar">
			<i class="material-icons">add</i>
		</a>
	</div>
</div>

<table>
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Correo</th>
			<th>Tipo</th>
			<th class="center">Activo</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		<tr ng-repeat="(key, user) in users">
			<td>{{ user.User.nombre }}</td>
			<td>{{ user.User.username }}</td>
			<td>{{ user.User.tipo }}</td>
			<td class="center">
				<div class="switch">
					<label>
						No
						<input type="checkbox" ng-model="user.User.estatus" ng-checked="user.User.estatus" ng-change="actualizarEstatus(user.User.id_c, user.User.estatus)">
						<span class="lever"></span>
						Si
					</label>
				</div>
			</td>
			<td>
				<a href="/users/guardar/{{ user.User.id_c }}">
					<i class="material-icons right">edit</i>
				</a>
			</td>
		</tr>
	</tbody>
</table>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>


app.controller("UsersIndex", function($scope, $rootScope, $http)
{
	$scope.variables_php = <?php echo $variables_php ?>;
	$scope.users = $scope.variables_php.Users;

	$scope.actualizarEstatus = function(id_c, estatus)
	{
		$http.post("/users/actualizar_estatus",
		{
			id: id_c,
			estatus: estatus
		});
	}
});


<?php $this->Html->scriptEnd(); ?>