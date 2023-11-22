@extends ('layouts.admin')
@section ('contenido') 
@inject('categorias', 'App\Services\categoriaservicio')
@inject('subcategorias', 'App\Services\subcategoriaservicio')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
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
	
	
function cambiarFile(){
    const input = document.getElementById('photo');
    	if(input.files && input.files[0])
		var tmppath = URL.createObjectURL(input.files[0]);
		document.getElementById("photopastel").src= tmppath;
		var myPhoto = document.getElementById("photopastel").src= tmppath; 
		var height = document.getElementById("photopastel").clientHeight;
		var width = document.getElementById("photopastel").clientWidth;
		if ((parseInt(height) > 200) && (parseInt(width) > 200)){
    		document.getElementById("photopastel").style.width = (parseInt(width))/2 + "px";
		}else{
			document.getElementById("photopastel").style.height = height+"px";
    		document.getElementById("photopastel").style.width = width+"px";
		}
	}

document.addEventListener('DOMContentLoaded', function(){
	//document.getElementById("stock").value = 30;
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
								opciones += '<option value="'+ data.lista[i].idsubcategoria +'">'+ data.lista[i].descripcionsubcategoria +'</option>'
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

	{!! Form::open(array('url' => 'cargadescarga/pastel', 'method' => 'POST', 'autocomplete'=>'off', 'files'=>'true')) !!}
	{{Form::token()}}
	@csrf

	<!-- <input class="getinfo"></input>
    <div class="writeinfo"></div>    -->
<div class="">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Nuevo pastel</h3>
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
						<textarea  type="text" name="descripcionpastel" class="form-control" value="{{old('descripcionpastel')}}" placeholder="" rows="2" cols="35" required></textarea>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Ingredientes</label>
						<textarea  type="text" name="ingrediente" class="form-control" value="{{old('ingrediente')}}" placeholder="" rows="2" cols="35" required></textarea>
					</div>
				</td>
				
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Precio Costo</label>
						<input type="number" name="pcosto" class="form-control" value="{{old('ingrediente')}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Precio Venta</label>
						<input type="number" name="pventa" class="form-control" value="{{old('pventa')}}" placeholder="" required>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Stock</label>
						<input type="number" name="stock" class="form-control" value="{{old('stock')}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Ventas</label>
						<input type="number" name="ventas" class="form-control" value="{{old('ventas')}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Existencia</label>
						<input type="number" name="existencia" class="form-control" value="{{old('existencia')}}" placeholder="" required>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
        				<label for="categoria">Categoria</label>
						<div>
                    	<select id="_categoria" name="idcategoria" class="form-control{{ $errors->has('idcategoria') ? ' is-invalid' : '' }}" required>
                         	@foreach($categorias->get() as $index => $categoria)
                            <option value="{{  $index }}" {{ old('idcategoria') == $index  ? 'selected' : '' }}>
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
					<div class="form-group col-md-12">
						<label for="photo">Foto</label>
						<input type="file" id="photo" name="photo" class="form-control" value="{{old('photo')}}" accept="image/*" onchange="return cambiarFile();">
						@error('file')
							<small class="text-danger">{{$message}}</small>
						@enderror
					</div>
				</td>
				<td>
					
				</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="form-group col-md-12">
		<a href="{{url ('cargadescarga/pastel')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection
