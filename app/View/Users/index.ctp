

<div ng-controller="UsersIndex">

<!-- //========================================================================= -->

<div class="row">
	<div class="col s12 valign-wrapper">
		<h4 class="left">Usuarios</h4>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="btn-floating btn-peque waves-effect waves-light pulse modal-trigger" href="#modal_guardar_usuario">
			<i class="material-icons">add</i>
		</a>
	</div>
</div>

<table>
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Username</th>
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
				<a ng-click="editar(user.User.id_c)" class="pointer">
					<i class="material-icons right">edit</i>
				</a>
			</td>
		</tr>
	</tbody>
</table>
<br><br><br>

<?php include $guardar_usuario; ?>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
	variables_php = <?php echo $variables_php ?>;
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->script('index_usuarios', array('inline' => false)); ?>
<?php $this->Html->script('guardar_usuario', array('inline' => false)); ?>