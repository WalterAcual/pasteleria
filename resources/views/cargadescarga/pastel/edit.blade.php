@extends ('layouts.admin')
@section ('contenido') 
@inject('categorias', 'App\Services\categoriaservicio')
@inject('subcategorias', 'App\Services\subcategoriaservicio')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>

<script type="text/javascript">
	
 document.addEventListener("onload", function(){
	var str,
	element = document.getElementById('subcategoria');
	if (element != null) {
    	str = element.value;
	}else{
    	str = null;
	}
	//alert("str: " + str);
});

window.addEventListener("load", function(){
	//document.getElementById("stock").value = 25;	
	var str,
	element = document.getElementById('subcategoria');
	if (element != null) {
    	str = element.value;
	}else{
    	str = null;
	}
	//alert("str: " + str);
	//var valsubcat = document.getElementById("subcategoria").value
	//alert("sub categoria:" + vasubcat);
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	var idcategoria = document.getElementById("_categoria").value;
				var valor = $(".getinfo").val();
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
							
							//document.getElementById("_subcategoria").value = valsubcat;
							if (data.lista.length > 0) {
								$("#_subcategoria").show();; 
								$("#_subcategoria").focus();
							} else {
								$("#_subcategoria").hide(); 
								$("#estado").focus();
    						} 
                    }
                }); 
});

function cambiarFile(){
    const input = document.getElementById('photo');
    	if(input.files && input.files[0])
		var tmppath = URL.createObjectURL(input.files[0]);
		var myPhoto = document.getElementById("photopastel").src= tmppath; 
		var height = document.getElementById("photopastel").clientHeight;
		var width = document.getElementById("photopastel").clientWidth;
	}


	document.addEventListener('DOMContentLoaded', function(){
		var str,
	element = document.getElementById('subcategoria');
	if (element != null) {
    	str = element.value;
	}else{
    	str = null;
	}
	//alert("str: DOMLoaded " + str);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$("#_subcategoria").hide(); 
			$('#_categoria').change(function() {
				var idcategoria = $(this).val();
				var valor = $(".getinfo").val();
                $.ajax({
                    url: '/postajax',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, message:idcategoria},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
							var opciones = "<option value=''>Seleccionar</option>";
							for (let i in data.lista){
								opciones += '<option value="'+ data.lista[i].idsubcategoria +'">'+ data.lista[i].descripcion +'</option>'
							}
							document.getElementById("_subcategoria").innerHTML = opciones;
							if (data.lista.length > 0) {
								$("#_subcategoria").show();; 
								$("#_subcategoria").focus();
							} else {
								$("#_subcategoria").hide(); 
								$("#estado").focus();
    						} 
                    }
                }); 
            });
		});
</script>

	{!! Form::model ($pastel, ['method'=>'PATCH','route'=>['pastel.update',$pastel->idpastel], 'files'=>'true'])!!}
	{{Form::token()}}
	@csrf

	<div class="writeinfo"></div>
<div class="form-row">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Modificar pastel</h3> 
		</div>	

		<div class="">
			
		<table>
			<tr>
				<td><div>DATOS GENERALES</div></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Descripci&oacute;n</label>
						<textarea  type="text" name="descripcionpastel" class="form-control" value="{{$pastel->descripcionpastel}}" placeholder="" rows="2" cols="35" required>{{$pastel->descripcionpastel}}</textarea>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Ingredientes</label>
						<input type="text" name="ingrediente" class="form-control" value="{{$pastel->ingrediente}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Precio Costo</label>
						<input type="text" name="pcosto" class="form-control" value="{{$pastel->pcosto}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Precio Venta</label>
						<input type="text" name="pventa" class="form-control" value="{{$pastel->pventa}}" placeholder="" required>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">stock</label>
						<input type="number" name="stock" class="form-control" value="{{$pastel->stock}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Ventas</label>
						<input type="number" name="ventas" class="form-control" value="{{$pastel->ventas}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Existencia</label>
						<input type="number" name="existencia" class="form-control" value="{{$pastel->existencia}}" placeholder="" required>
					</div>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
        				<label for="categoria">Categoria</label>
						<div>
                    	<select id="_categoria" name="idcategoria" class="form-control{{ $errors->has('idcategoria') ? ' is-invalid' : '' }}" required>
                         	@foreach($categorias->get() as $indexCategory => $categoria)
                            <option value="{{  $indexCategory }}" {{ $pastel->idcategoria == $indexCategory ? 'selected' : '' }}>
                                {{ $categoria }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idcategoria'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idcategoria') }}</strong>
                        	</span>
                   		 @endif
                		</div>
        			</div>
        	</div>
				</td>
				<td>
					<div class="form-group col-md-12">
        				<label for="_subcategoria">Sub Categoria</label>
                		<div>
                    		<select id="_subcategoria" name="idsubcategoria" class="form-control{{ $errors->has('idsubcategoria') ? ' is-invalid' : '' }}"></select>
                    		@if ($errors->has('idsubcategoria'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idsubcategoria') }}</strong>
                        	</span>
                    		@endif
                		</div>
        			</div>
				</td>
				
				<td>
					
				</td>
			</tr>
			<tr>
			<td>
					<div class="form-group col-md-12">
						<label for="photo">Foto</label>
						@if (($pastel->photo) !="")
						<input type="file" id="photo" name="photo" class="" value="{{$pastel->photo}}" accept="image/*" onchange="return cambiarFile();">
						@else
						<input type="file" id="photo" name="photo" class="" >
						@endif
					</div>
				</td>
				
				<td><input id="subcaterogia" class="getinfo" style="visibility:hidden;" value="{{$pastel->idsubcategoria}}"></td>
				<td></td>
				<td>
					<div class="form-group col-md-1">
							@if (($pastel->photo) !="")
								<img id="photopastel" src="{{$pastel->photo}}" width="200px"> 
							@endif
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		</div>
	</div>
	<div  class="form-group col-md-12">
		<a href="{{url ('cargadescarga/pastel')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection