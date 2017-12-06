


<div id="modal_guardar_secciones" class="modal modal-fixed-footer" ng-controller="ModalGuardarSeccion">
<form id="SeccionGuardarForm" accept-charset="utf-8">

	<div class="modal-content">
		
		<div class="titulo-modal">
			<h5>Guardar Seccion</h5>
		</div>
		<br>

		<input class="hide" name="data[Seccione][id]" ng-model="seccion.id_c">

		<div class="row">
			<div class="input-field col s12">
				<input type="text" id="se_nombre" name="data[Seccione][nombre]" ng-model="seccion.nombre">
				<label for="se_nombre">
					Nombre
					<label id="se_nombre-error" class="error validation_label" for="se_nombre"></label>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input type="color" id="se_color" ng-model="seccion.color">
			</div>
		</div>

	</div>

	<div class="modal-footer">
		<div class="valign-wrapper right">

			<?php include "preloader.php"; ?>

			&nbsp;&nbsp;&nbsp;

			<button id="btn_guardar" class="btn waves-effect waves-light" type="submit" name="action">
				Guardar
				<i class="material-icons right">save</i>
			</button>

			&nbsp;&nbsp;&nbsp;

			<a id="btn_cancelar" class="modal-action modal-close waves-effect waves-light btn">
				Cancelar
				<i class="material-icons right">cancel</i>
			</a>

		</div>
	</div>

</form>
</div>