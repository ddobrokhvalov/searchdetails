<?		
	if($_FILES["csv_file"]){
		require_once $_SERVER["DOCUMENT_ROOT"]."/common/spares_parts.controller.php";
		$controller = new sparesPartsController();
		$controller->loadCsvFile($_FILES["csv_file"], $_POST["select_act"]);
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Загрузка CSV</title>
	<link type="text/css" rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
	<form method="POST" enctype="multipart/form-data">
		<div class="form_inner">
			<div class="row">
				<div class="col_label"><label for="csv_file">Файл csv</label></div>
				<div class="col_field"><input type="file" accept="text/csv" name="csv_file" id="csv_file" class="form_field"></div>
			</div>
			<div class="row">
				<div class="col_label"><label for="select_act">Что делать с записями, отсутствующими в файле</label></div>
				<div class="col_field">
					<select name="select_act" id="select_act" class="form_field">
						<option value="no_action">Ничего</option>
						<option value="delete">Удалить</option>
						<option value="deactivate">Деактивировать</option>
					</select>
				</div>
			</div>
			<div class="row">
				<input type="submit" id="submit" value="Применить">
			</div>
		</div>
	</form>
</body>
</html>