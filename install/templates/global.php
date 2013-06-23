<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="style.css" type="text/css">
	<title>Установщик KopoloCMS</title>
</head>
<body>
<h1>Установщик KopoloCMS</h1>
<?php
	if (isset($step_template) && is_file($step_template)) {
		require_once $step_template;
	} else {
		?>
			<p class="error">При работе установщика возникла ошибка: не передано имя шаблона или отсутствует файл шаблона</p>
			<p>Свяжитесь с разработчиком</p>
		<?php
	}
?>
</body>
</html>
