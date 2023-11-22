@extends ('layouts.admin')
@section ('contenido') 
@inject('categorias', 'App\Services\categoriaservicio')

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	//Poner invisible botones y caja de texto
	$("#_subcategoria").hide(); 
	
	//Permite seleccionar las subcategorias a partir de la categoria -- Inicia
	$('#_categoria').change(function() {
				var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
				var idcategoria = $(this).val();
				var valor = $(".getinfo").val();
				$("#idProd").hide(); 
                $.ajax({
                    url: '/postajax',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, message:idcategoria},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
							var opciones = "<option value=''>Seleccionar</option>";
							for (let i in data.lista){
								opciones += '<option value="'+ data.lista[i].idsubcategoria +'">'+ data.lista[i].descripcionsubcategoria +'</option>'
							}
							document.getElementById("_subcategoria").innerHTML = opciones;
							if (data.lista.length > 0) {
								$("#_subcategoria").show();; 
								$("#_subcategoria").focus();
							} else {
								$("#_subcategoria").hide(); 
    					} 
                    }
                }); 
            });
	//Permite seleccionar las subcategorias a partir de la categoria -- Finaliza
	});//cierre del DOM
</script>
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Pastel: </h2> <a href="pastel/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('cargadescarga.pastel.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Descripci&oacute;n</th>
					<th class="fondoGrid">Ingrediente</th>
					<th class="fondoGrid">Categoria</th>
					<th class="fondoGrid">Sub Categoria</th>
					<th class="fondoGrid" style="text-align: right;">Costo</th>
					<th class="fondoGrid" style="text-align: right;">Precio Venta</th>
					<th class="fondoGrid" style="text-align: right;">Stock</th>
					<th class="fondoGrid" style="text-align: right;">Ventas</th>
					<th class="fondoGrid" style="text-align: right;">Existencia</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($pastel as $product)
				<tr>
					<td class="table-active">{{$product->descripcionpastel}}</td>
					<td class="table-active">{{$product->ingrediente}}</td>
					<td class="table-active">{{$product->descripcion}}</td>
					<td class="table-active">{{$product->descripcionsubcategoria}}</td>
					<td class="table-active" style="text-align: right;">{{$product->pcosto}}</td>
					<td class="table-active" style="text-align: right;">{{$product->pventa}}</td>
					<td class="table-active" style="text-align: right;">{{$product->stock}}</td>
					<td class="table-active" style="text-align: right;">{{$product->ventas}}</td>
					<td class="table-active" style="text-align: right;">{{$product->existencia}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('pastelController@edit', $product->idpastel)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$product->idpastel}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('cargadescarga.pastel.modal')
				@endforeach
			</table>
			Total: {{$pastel->total()}}
		</div>
		{{$pastel->render()}}
	</div>
</div>
@endsection