


<div>
	<div class="input-field">
		<input type="text"
			id="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
			name="data[Media][<?php echo $data["tipo"] ?>][<?php echo $data["acum"] ?>][desplegar]"
		>
		<label
			for="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
		>
			Desplegar
		</label>
	</div>
	<?php if ($data["tipo"] != 5): ?>
		
		<div class="file-field input-field">
			<div class="btn">
				<span>
					<?php echo $data["nombre"] ?>
				</span>
				<input type="file"
					name="data[Media][<?php echo $data["tipo"] ?>][<?php echo $data["acum"] ?>][media]"
				>
			</div>
			<div class="file-path-wrapper">
				<input class="file-path validate" type="text">
			</div>
		</div>

	<?php else: ?>

		<div class="input-field">
			<input type="text"
				id="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
				name="data[Media][<?php echo $data["tipo"] ?>][<?php echo $data["acum"] ?>][nombre]"
			>
			<label
				for="media_<?php echo $data["tipo"]."_".$data["acum"] ?>"
			>
				Link
			</label>
		</div>

	<?php endif ?>
	<br>
</div>