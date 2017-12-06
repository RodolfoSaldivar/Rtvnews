

<div ng-controller="SintesisIndex">

<!-- //========================================================================= -->

<?php echo $this->Form->create('Sintesis', array(
	'type' => 'file',
	'autocomplete' => 'off'
)); ?>

<input class="hide" name="data[Nota][fecha]" ng-model="sintesis.fecha">
<input class="hide" name="data[Nota][cliente_id]" ng-model="sintesis.cliente_id">

<div class="row">
	<div class="input-field col s3">
		<input type="text" id="cliente" ng-model="sintesis.cliente" class="autocomplete">
		<label for="cliente">
			Cliente
			<label id="cliente_no_existe" class="validation_label" for="cliente">*Seleccionar existente o agregar nuevo</label>
			<label id="cliente-error" class="error validation_label" for="cliente"></label>
		</label>
	</div>
	<div class="input-field col s3">
		<select id="seccion" name="data[Nota][seccione_id]" ng-model="sintesis.seccione_id" ng-change="traerSintesis()">
			<option value="nada" disabled>Seleccione</option>
			<option value="todo">Todas</option>
			<option ng-repeat="(key, seccion) in variables_php.secciones" value="{{ seccion.Seccione.id_c }}">{{ seccion.Seccione.nombre }}</option>
		</select>
		<label>Sección <label id="seccion-error" class="validation_label">*Requerido</label></label>
	</div>
	<div class="input-field col s3">
		<select id="tipo" name="data[Nota][tipo]" ng-model="sintesis.tipo" ng-change="traerSintesis()">
			<option value="nada" disabled>Seleccione</option>
			<option value="todo">Todos</option>
			<option value="1">Prensa</option>
			<option value="2">Radio</option>
			<option value="3">TV</option>
			<option value="4">Internet</option>
		</select>
		<label>Tipo <label id="tipo-error" class="validation_label">*Requerido</label></label>
	</div>
	<div class="input-field col s3">
		<input type="text" class="datepicker" id="fecha" ng-model="fecha_bonita">
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
<div id="contenido_sintesis" class="hide">
	<hr><br>

	<div class="row valign-wrapper">
		<div class="col input-field col s3">
			<img width="200" id="cliente_img" src="">
		</div>
		<div class="input-field col s4">
			<h3>
				{{ sintesis.cliente }}
			</h3>
		</div>
		<div class="col s5 right-align">
			<h4>
				Síntesis Informativa
			</h4>
			<h6>
				{{ fecha_bonita }}
			</h6>
		</div>
	</div>

	<br><br>

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

	<br><br>

	<div class="row margin_nada" ng-repeat="(seccion_nombre, seccion) in secciones">
		<h4 style="color: {{ seccion.Seccione.color  }}">
			{{ seccion_nombre }}
		</h4>
		<ul class="collapsible" data-collapsible="expandable">
			<li ng-repeat="(nota_id_c, nota) in seccion.Notas">
				<div class="collapsible-header">
					<b>{{ nota.Nota.titulo }}</b>
					<div ng-repeat="(key, media) in nota.Medias">
						&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<span ng-if="media.Media.tipo == 5">
							<a href="{{ media.Media.nombre }}" target="_blank">
								{{ media.Media.desplegar }}
							</a>
						</span>
						<span ng-if="media.Media.tipo != 5">
							<a href="/medias/ver/{{ media.Media.id_c }}" target="_blank">
								{{ media.Media.desplegar }}
							</a>
						</span>
					</div>
				</div>
				<div class="collapsible-body">
					<div class="row">
						{{ nota.Nota.medio }}
						&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						{{ nota.Nota.genero }}
						&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						{{ nota.Nota.declarante }}
						&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						{{ nota.Nota.dependiente }}
						<a href="/notas/guardar/{{ nota_id_c }}" class="right pointer naranja">
							<i class="material-icons right">edit</i>
						</a>
					</div>
					<div class="row">
						{{ nota.Nota.tema }}
					</div>
					<div class="row margin_nada">
						{{ nota.Nota.resumen }}
					</div>
				</div>
			</li>
		</ul>
	</div>

	<br><br>

	<!-- Modal Trigger -->
	<a class="waves-effect waves-light btn modal-trigger right" href="#modal_enviar_correo">
		Enviar
		<i class="material-icons right">mail</i>
	</a>
	
	<!-- Modal Structure -->
	<div id="modal_enviar_correo" class="modal modal-fixed-footer">
		<div class="modal-content">
		
			<div class="titulo-modal">
				<h5>Enviar Correo</h5>
			</div>
			<br>

			<div class="chips chips-placeholder"></div>

			<div id="correos_mandar" class="hide"></div>
		</div>

		<div class="modal-footer">
			<div class="valign-wrapper right">

				<?php include $preloader; ?>

				&nbsp;&nbsp;&nbsp;

				<button id="btn_guardar" class="btn waves-effect waves-light" type="submit" name="action">
					Enviar
					<i class="material-icons right">mail</i>
				</button>

				&nbsp;&nbsp;&nbsp;

				<a id="btn_cancelar" class="modal-action modal-close waves-effect waves-light btn">
					Cancelar
					<i class="material-icons right">cancel</i>
				</a>

			</div>
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