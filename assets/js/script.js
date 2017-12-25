$(document).ready(function(){
	$(".ajax_form").submit(function(){
		if($("#query").val() || $("#sku").val()){
			$.ajax({
				url: "/ajax.php",
				data: $(this).serialize(),
				dataType: "json",
				method: "POST",
				success: function(data){
					console.log(data);
					var table = "<table border='1' style='border-collapse:collapse;'>";
					table = table+"<tr>";
					table = table+"<td>Производитель</td>";
					table = table+"<td>Артикул</td>";
					table = table+"<td>Наименование</td>";
					table = table+"<td>Количество</td>";
					table = table+"<td>Цена</td>";
					table = table+"</tr>";
					for(var i=0; i < data.count; i++){
						table = table+"<tr>";
						table = table+"<td>"+data.items[i]['manufacture']+"</td>";
						table = table+"<td>"+data.items[i]['sku']+"</td>";
						table = table+"<td>"+data.items[i]['ru_name']+"</td>";
						table = table+"<td>"+data.items[i]['quantity']+"</td>";
						table = table+"<td>"+data.items[i]['price']+"</td>";
						table = table+"</tr>";
					}
					table = table+"</table>";
					$(".search_result").html(table);
				},
				error: function(data){
				}
			});
		}else{
			alert("не заданы условия поиска");
		}
		return false;
	});
});