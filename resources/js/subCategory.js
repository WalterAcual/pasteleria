document.addEventListener('DOMContentLoaded', function(){
	alert("Hola");
	$('#_categoria').on('change', function() {
		var idcategoria = $(this).val();
		if($.trim(idcategoria != '')){
			$.get('invSubCategories', {idcategoria: idcategoria}, function (subCategory){
				$('#_subcategoria').empty();
				$('#_subcategoria').append("<option value=''>Seleccionar</option>");
				$.each(subCategory, function(index,value){
					$('_subcategoria').append("<option value='" + index +"'>"+ value +"</option>");
				})
			});
		}
	});
});