


<div id="modal_guardar_usuario" class="modal modal-fixed-footer" ng-controller="ModalGuardarUsuario">
<form id="UsuarioGuardarForm" accept-charset="utf-8">

	<div class="modal-content">
		
		<div class="titulo-modal">
			<h5>Guardar Usuario</h5>
		</div>
		<br>

		<input class="hide" name="data[User][id]" ng-model="user.id_c">

		<div class="row">
			<div class="input-field col s12">
				<input type="text" id="us_nombre" name="data[User][nombre]" ng-model="user.nombre">
				<label for="us_nombre">
					Nombre Completo
					<label id="us_nombre-error" class="error validation_label" for="us_nombre"></label>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input type="text" id="us_username" name="data[User][username]" ng-model="user.username">
				<label for="us_username">
					Username
					<label id="us_username-error" class="error validation_label" for="us_username"></label>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input type="text" id="us_password" name="data[User][password]" ng-model="user.password">
				<label for="us_password">
					Contraseña
					<label id="us_password-error" class="error validation_label" for="us_password"></label>
				</label>
			</div>
		</div>
		
		<div class="row">
			<div class="input-field col s12">
				<select id="us_tipo" name="data[User][tipo]" ng-model="user.tipo">
					<option value="nada" disabled>Seleccione</option>
					<option value="1">Administrador</option>
					<option value="2">Usuario</option>
				</select>
				<label>Tipo <label id="us_tipo-error" class="validation_label">*Requerido</label></label>
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