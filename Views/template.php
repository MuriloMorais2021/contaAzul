<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Painel - <?= (isset($viewData['company_name'])) ? $viewData['company_name'] : ''; ?></title>
	<?php if (isset($viewData['CSS'])) {
		echo $viewData['CSS'];
	}; ?>
	<link rel="stylesheet" href="<?= BASE_URL . 'Assets/css/template.css'; ?>">
	<script type="text/javascript" src="<?= BASE_URL.'Assets/js/jquery-3.6.0.min.js';?>"></script>
</head>

<body>
	<div class="leftmenu">
		<div class="company_name">
			<?= isset($viewData['user_email']) ? $viewData['user_email'] : ''; ?>
		</div>
		<div class="menu_area">
			<ul>
				<li><a href="<?=BASE_URL.'';?>">Home</a></li>
				<li><a href="<?=BASE_URL.'Permissions';?>">Permissões</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="top">

			<div class="top_right">
				<a href="<?= BASE_URL.'Login/logout'; ?>">Sair</a>
			</div>
			<div class="top_right">
				<?= isset($viewData['user_email']) ? $viewData['user_email'] : ''; ?>
			</div>
		</div>
		<div class="area">
			<?php $this->loadViewInTemplate($viewName, $viewData); ?>
		</div>
	</div>
	<?= isset($viewData['JS']) ? $viewData['JS'] : ''; ?>
</body>

</html>