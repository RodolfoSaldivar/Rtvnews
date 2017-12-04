


<div class="card" id="card_<?php echo $data["tipo"]."_".$data["acum"] ?>">
	<div class="card-image">
		<a class="btn-floating halfway-fab waves-effect waves-light" onclick="removerMedia('card_<?php echo $data["tipo"]."_".$data["acum"] ?>')"><i class="material-icons">close</i></a>
	</div>
	<div class="card-content">
		<div class="input-field">
			<input type="hidden" name="<?php echo $data["name"] ?>[id]" value="<?php echo $data["id_c"] ?>">
			<input type="text"
				id="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
				name="<?php echo $data["name"] ?>[desplegar]"
				value="<?php echo @$data["Media"]["desplegar"] ?>"
				<?php if ($data["disabled"]) echo 'disabled' ?>
			>
			<label
				for="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
			>
				Desplegar
			</label>
		</div>
		<?php if ($data["tipo"] != 5): ?>
			
			<div class="file-field input-field">
				<div class="btn <?php if ($data["disabled"]) echo 'disabled' ?>">
					<span>
						<?php echo $data["nombre"] ?>
					</span>
					<input type="file"
						name="<?php echo $data["name"] ?>[nombre]"
					>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" value="<?php echo @$data["Media"]["nombre"] ?>">
				</div>
			</div>

		<?php else: ?>

			<div class="input-field">
				<input type="text"
					id="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
					name="<?php echo $data["name"] ?>[nombre]"
				>
				<label
					for="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
				>
					Link
				</label>
			</div>

		<?php endif ?>
	</div>
</div>