<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= (isset($viewData['title']))?$viewData['title']:'SysPet'; ?></title>
	<?php if(isset($viewData['CSS'])){echo $viewData['CSS'];}; ?>	
</head>
<body>
	<div class="container">
		<?php $this->loadViewInTemplate($viewName, $viewData); ?>
	</div>
	<?php if(isset($viewData['JS'])){echo $viewData['JS'];}; ?>
</body>
</html>
