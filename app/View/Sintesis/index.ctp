

<div ng-controller="SintesisIndex">

<!-- //========================================================================= -->

<?php echo $this->Form->create('Sintesis', array(
	'type' => 'file',
	'autocomplete' => 'off'
)); ?>

<div class="row">
	<div class="input-field col s3">
		<input type="text" id="cliente" name="data[Nota][cliente]" ng-model="sintesis.cliente" class="autocomplete">
		<label for="cliente">
			Cliente
			<label id="cliente_no_existe" class="validation_label" for="cliente">*Seleccionar existente o agregar nuevo</label>
			<label id="cliente-error" class="error validation_label" for="cliente"></label>
		</label>
	</div>
	<div class="input-field col s3">
		<select id="seccion" name="data[Nota][seccione_id]" ng-model="sintesis.seccione_id" ng-change="filtrarNotas()">
			<option value="nada" disabled>Seleccione</option>
			<option ng-repeat="(key, seccion) in variables_php.secciones" value="{{ seccion.Seccione.id_c }}">{{ seccion.Seccione.nombre }}</option>
		</select>
		<label>Sección <label id="seccion-error" class="validation_label">*Requerido</label></label>
	</div>
	<div class="input-field col s3">
		<select id="tipo" name="data[Nota][tipo]" ng-model="sintesis.tipo" ng-change="filtrarNotas()">
			<option value="nada" disabled>Seleccione</option>
			<option value="1">Prensa</option>
			<option value="2">Radio</option>
			<option value="3">TV</option>
			<option value="4">Internet</option>
		</select>
		<label>Tipo <label id="tipo-error" class="validation_label">*Requerido</label></label>
	</div>
	<div class="input-field col s3">
		<input type="text" class="datepicker" id="fecha">
		<label for="fecha">
			Fecha
			<label id="fecha-error" class="error validation_label" for="fecha"></label>
		</label>
	</div>
</div>

<div class="row">
	<div id="cargando_notas" class="col s12 center">
		<?php include $preloader; ?>
	</div>
</div>

<!-- Todo el contenido de la sintesis -->
<div id="contenido_sintesis">
	<hr><br>
	<div class="row" id="agregar_medias">
		<div class="col s3 center" id="append_2">
			<a class="waves-effect waves-light btn btn-flat" ng-click="appendMedia(2)">
				<i class="material-icons">picture_as_pdf</i>
				<i class="material-icons">add</i>
			</a>
		</div>
		<div class="col s3 center" id="append_3">
			<a class="waves-effect waves-light btn btn-flat" ng-click="appendMedia(3)">
				<i class="material-icons">videocam</i>
				<i class="material-icons">add</i>
			</a>
		</div>
		<div class="col s3 center" id="append_4">
			<a class="waves-effect waves-light btn btn-flat" ng-click="appendMedia(4)">
				<i class="material-icons">settings_voice</i>
				<i class="material-icons">add</i>
			</a>
		</div>
		<div class="col s3 center" id="append_5">
			<a class="waves-effect waves-light btn btn-flat" ng-click="appendMedia(5)">
				<i class="material-icons">link</i>
				<i class="material-icons">add</i>
			</a>
		</div>
	</div>

</div>

<br><br><br>

<?php echo $this->Form->end(); ?>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
	variables_php = <?php echo $variables_php ?>;
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->script('pickadate_default', array('inline' => false)); ?>
<?php $this->Html->script('index_sintesis', array('inline' => false)); ?>