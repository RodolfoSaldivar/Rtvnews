


<div id="modal_guardar_cliente" class="modal modal-fixed-footer" ng-controller="ModalGuardarCliente">
<form id="ClienteGuardarForm" accept-charset="utf-8">

	<div class="modal-content">
		
		<div class="titulo-modal">
			<h5>Guardar Cliente</h5>
		</div>
		<br>

		<input class="hide" name="data[Cliente][id]" ng-model="cliente.id_c">

		<div class="row">
			<div class="input-field col s12">
				<input type="text" id="cl_nombre" name="data[Cliente][nombre]" ng-model="cliente.nombre">
				<label for="cl_nombre">
					Nombre
					<label id="cl_nombre-error" class="error validation_label" for="cl_nombre"></label>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="file-field input-field col s12">
				<div class="btn">
					<span>Logo</span>
					<input id="cl_logo" type="file" name="data[Cliente][logo]" ng-model="cliente.logo">
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" ng-model="cliente.logo_nombre" ng-change="desplegarImg()">
					<label for="cl_logo">
						<label id="cl_logo-error" class="error validation_label" for="cl_logo"></label>
					</label>
				</div>
			</div>
			<img id="cl_imagen" src="" width="300">
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