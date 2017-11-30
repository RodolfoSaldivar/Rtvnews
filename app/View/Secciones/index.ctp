

<div ng-controller="SeccionesIndex">

<!-- //========================================================================= -->

<div class="row">
	<div class="col s12 valign-wrapper">
		<h4 class="left">Secciones</h4>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="btn-floating btn-peque waves-effect waves-light pulse modal-trigger" href="#modal_guardar_secciones">
			<i class="material-icons">add</i>
		</a>
	</div>
</div>

<table>
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Color</th>
			<th class="center">Activo</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		<tr ng-repeat="(key, seccion) in secciones">
			<td>{{ seccion.Seccione.nombre }}</td>
			<td><input disabled="" type="color" ng-model="seccion.Seccione.color"></td>
			<td class="center">
				<div class="switch">
					<label>
						No
						<input type="checkbox" ng-model="seccion.Seccione.estatus" ng-checked="seccion.Seccione.estatus" ng-change="actualizarEstatus(seccion.Seccione.id_c, seccion.Seccione.estatus)">
						<span class="lever"></span>
						Si
					</label>
				</div>
			</td>
			<td>
				<a ng-click="editar(seccion.Seccione.id_c)" class="pointer">
					<i class="material-icons right">edit</i>
				</a>
			</td>
		</tr>
	</tbody>
</table>

<?php include $guardar_seccion; ?>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
	variables_php = <?php echo $variables_php ?>;
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->script('index_secciones', array('inline' => false)); ?>
<?php $this->Html->script('guardar_seccion', array('inline' => false)); ?>