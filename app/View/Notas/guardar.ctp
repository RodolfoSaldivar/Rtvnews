

<div ng-controller="NotasIndex">

<!-- //========================================================================= -->

<?php echo $this->Form->create('Nota', array(
	'type' => 'file',
	'autocomplete' => 'off'
)); ?>

<input class="hide" name="data[Nota][id]" ng-model="nota.id_c">
<input class="hide" name="data[Nota][cliente_id]" ng-model="nota.cliente_id_c">

<div class="row">
	<div class="input-field col s4">
		<input type="text" id="cliente" name="data[Nota][cliente]" ng-model="nota.cliente" class="autocomplete">
		<label for="cliente">
			Cliente
			<label id="cliente_no_existe" class="validation_label" for="cliente">*Seleccionar existente o agregar nuevo</label>
			<label id="cliente-error" class="error validation_label" for="cliente"></label>
		</label>
	</div>
	<div class="input-field col s1">
		<a class="btn-floating btn-peque waves-effect waves-light pulse modal-trigger" href="#modal_guardar_cliente">
			<i class="material-icons">add</i>
		</a>
	</div>
	<div class="col input-field col s4">
		<img width="200" id="cliente_img" src="">
	</div>
</div>

<div class="row">
	<div class="input-field col s8">
		<input type="text" id="autor" name="data[Nota][autor]" ng-model="nota.autor">
		<label for="autor">
			Autor
			<label id="autor-error" class="error validation_label" for="autor"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s4">
		<select id="seccion" name="data[Nota][seccione_id]" ng-model="nota.seccione_id_c">
			<option value="nada" disabled>Seleccione</option>
			<option ng-repeat="(key, seccion) in variables_php.secciones" value="{{ seccion.Seccione.id_c }}">{{ seccion.Seccione.nombre }}</option>
		</select>
		<label>Sección <label id="seccion-error" class="validation_label">*Requerido</label></label>
	</div>
	<div class="input-field col s4">
		<select id="tipo" name="data[Nota][tipo]" ng-model="nota.tipo" ng-change="cambioTipo()">
			<option value="nada" disabled>Seleccione</option>
			<option value="1">Prensa</option>
			<option value="2">Radio</option>
			<option value="3">TV</option>
			<option value="4">Internet</option>
		</select>
		<label>Tipo <label id="tipo-error" class="validation_label">*Requerido</label></label>
	</div>
	<div class="input-field col s4">
		<input type="text" id="tema" name="data[Nota][tema]" ng-model="nota.tema">
		<label for="tema">
			Tema
			<label id="tema-error" class="error validation_label" for="tema"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s4">
		<input type="text" id="titulo" name="data[Nota][titulo]" ng-model="nota.titulo">
		<label for="titulo">
			Título
			<label id="titulo-error" class="error validation_label" for="titulo"></label>
		</label>
	</div>
	<div class="input-field col s4">
		<input type="text" id="medio" name="data[Nota][medio]" ng-model="nota.medio">
		<label for="medio">
			Medio
			<label id="medio-error" class="error validation_label" for="medio"></label>
		</label>
	</div>
	<div class="input-field col s4">
		<input type="text" id="genero" name="data[Nota][genero]" ng-model="nota.genero">
		<label for="genero">
			Género
			<label id="genero-error" class="error validation_label" for="genero"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s4">
		<input type="text" id="declarante" name="data[Nota][declarante]" ng-model="nota.declarante">
		<label for="declarante">
			Declarante
			<label id="declarante-error" class="error validation_label" for="declarante"></label>
		</label>
	</div>
	<div class="input-field col s4">
		<input type="text" id="referente" name="data[Nota][referente]" ng-model="nota.referente">
		<label for="referente">
			Referente
			<label id="referente-error" class="error validation_label" for="referente"></label>
		</label>
	</div>
	<div class="input-field col s4">
		<input type="text" id="dependiente" name="data[Nota][dependiente]" ng-model="nota.dependiente">
		<label for="dependiente">
			Dependiente
			<label id="dependiente-error" class="error validation_label" for="dependiente"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12">
		<textarea id="resumen" class="materialize-textarea" name="data[Nota][resumen]" ng-model="nota.resumen"></textarea>
		<label for="resumen">
			Resumen
			<label id="resumen-error" class="error validation_label" for="resumen"></label>
		</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s4">
		<select id="calificacion" name="data[Nota][calificacion]" ng-model="nota.calificacion">
			<option value="nada" disabled>Seleccione</option>
			<option value="1">Positiva</option>
			<option value="2">Neutra</option>
			<option value="3">Negativa</option>
		</select>
		<label>Calificación <label id="calificacion-error" class="validation_label">*Requerido</label></label>
	</div>
	<div ng-show="nota.tipo != 'nada'">	
		<div class="input-field col s2 l1">
			<h5>Medida:</h5>
		</div>
		<div class="input-field col s2 l1">
			<input type="number" id="medida_1" name="data[Nota][medida_1]" ng-model="nota.medida_1">
			<label for="medida_1">
				{{ label_medida_1 }}
				<label id="medida_1-error" class="error validation_label" for="medida_1"></label>
			</label>
		</div>
		<div class="input-field col s2 l1">
			<input type="number" id="medida_2" name="data[Nota][medida_2]" ng-model="nota.medida_2">
			<label for="medida_2">
				{{ label_medida_2 }}
				<label id="medida_2-error" class="error validation_label" for="medida_2"></label>
			</label>
		</div>
		<div class="input-field col s2 l1" ng-show="nota.tipo == 2 || nota.tipo == 3">
			<input type="number" id="medida_3" name="data[Nota][medida_3]" ng-model="nota.medida_3">
			<label for="medida_3">
				{{ label_medida_3 }}
				<label id="medida_3-error" class="error validation_label" for="medida_3"></label>
			</label>
		</div>
	</div>
</div>

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



<div class="valign-wrapper right">

	<?php include $preloader; ?>

	&nbsp;&nbsp;&nbsp;

	<button id="btn_guardar" class="btn waves-effect waves-light" type="submit" name="action">
		Guardar
		<i class="material-icons right">save</i>
	</button>

</div>
<br><br><br>

<?php echo $this->Form->end(); ?>

<?php include $guardar_cliente; ?>

<!-- //========================================================================= -->

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
	variables_php = <?php echo $variables_php ?>;
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->script('guardar_nota', array('inline' => false)); ?>
<?php $this->Html->script('guardar_cliente', array('inline' => false)); ?>