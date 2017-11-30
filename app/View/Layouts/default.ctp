

<!DOCTYPE html>
<html ng-app="App">
<head>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<?php echo $this->Html->css('materialize.min.css'); ?>
	<?php echo $this->Html->css('rodo_style.css'); ?>

	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body class="fondo-de-imagen-en-home">


	<nav>
		<div class="nav-wrapper">
			<a class="brand-logo">Logo</a>
			<ul class="right">
				<li>
					<a href="/users">Usuarios</a>
				</li>
				<li>
					<a href="/clientes">Clientes</a>
				</li>
				<li>
					<a href="/secciones">Secciones</a>
				</li>
				<li>
					<a href="/notas">Notas</a>
				</li>
				<li>
					<a href="/sintesis">Síntesis</a>
				</li>
				<li>
					<a class="waves-effect waves-light btn" href="/users/logout">Cerrar Sesión</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<?php echo $this->fetch('content'); ?>
	</div>


	<?php echo $this->Html->script('jquery-2.1.1.min.js'); ?>
	<?php echo $this->Html->script('angular.min.js'); ?>
	<?php echo $this->Html->script('materialize.min.js'); ?>
	<?php echo $this->Html->script('jquery.validate.min.js'); ?>
	<?php echo $this->Html->script('equalTo.js'); ?>
	<?php echo $this->Html->script('alphanumeric.js'); ?>
	<?php echo $this->Html->script('lettersonly.js'); ?>
	<?php echo $this->Html->script('donetyping.js'); ?>
	<?php echo $this->Html->script('dropdown.min.js'); ?>
	<?php echo $this->Html->script('number_format.min.js'); ?>
	<?php echo $this->Html->script('app.js'); ?>
	<?php echo $this->fetch('script'); ?>

	<script type="text/javascript">

		<?php echo $this->Session->flash('flash', array(
		    'element' => 'toast'
		)); ?>

	</script>
</body>
</html>
