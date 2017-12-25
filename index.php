<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Поиск запчастей</title>
	<link type="text/css" rel="stylesheet" href="/assets/css/style.css">
	<script type="text/javascript" src="/assets/js/jquery.js"></script>
	<script type="text/javascript" src="/assets/js/script.js"></script>
</head>
<body>
	<form method="POST" class="ajax_form">
		<div class="form_inner">
			<div class="row">
				<div class="col_label"><label for="query">Наименование (по подстроке)</label></div>
				<div class="col_field"><input type="text" name="query" id="query" class="form_field"></div>
			</div>
			<div class="row">
				<div class="col_label"><label for="sku">Артикул (точное совпадение)</label></div>
				<div class="col_field"><input type="text" name="sku" id="sku" class="form_field"></div>
			</div>
			<div class="row">
				<input type="submit" id="submit" value="Искать">
			</div>
		</div>
	</form>
	<div class="search_result">
		
	</div>
</body>
</html>