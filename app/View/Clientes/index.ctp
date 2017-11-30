

<div ng-controller="ClientesIndex">

<!-- //========================================================================= -->

<div class="row">
	<div class="col s12 valign-wrapper">
		<h4 class="left">Clientes</h4>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="btn-floating btn-peque waves-effect waves-light pulse modal-trigger" href="#modal_guardar_cliente">
			<i class="material-icons">add</i>
		</a>
	</div>
</div>

<table>
	<thead>
		<tr>
			<th>Logo</th>
			<th>Nombre</th>
			<th class="center">Activo</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		<tr ng-repeat="(key, cliente) in clientes">
			<td>{{ cliente.Cliente.media_id }}</td>
			<td>{{ cliente.Cliente.nombre }}</td>
			<td class="center">
				<div class="switch">
					<label>
						No
						<input type="checkbox" ng-model="cliente.Cliente.estatus" ng-checked="cliente.Cliente.estatus" ng-change="actualizarEstatus(cliente.Cliente.id_c, cliente.Cliente.estatus)">
						<span class="lever"></span>
						Si
					</label>
				</div>
			</td>
			<td>
				<a ng-click="editar(cliente.Cliente.id_c)" class="pointer">
					<i class="material-icons right">edit</i>
				</a>
			</td>
		</tr>
	</tbody>
</table>

<?php include $guardar_cliente; ?>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
	variables_php = <?php echo $variables_php ?>;
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->script('index_clientes', array('inline' => false)); ?>
<?php $this->Html->script('guardar_cliente', array('inline' => false)); ?>