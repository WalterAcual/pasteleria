@extends ('layouts.admin')
@section ('contenido') 
@inject('pastel', 'App\Services\pastelservicio')
<script type="text/javascript">
	document.addEventListener('DOMContentLoad', function(){	
		var strcargadescarga;
		idcargadescarga = document.getElementById('idcargadescarga');
		if (idpastel != null) {
    		strcargadescarga = idcargadescarga.value;
		}else{
    		strcargadescarga = 0;
		}
		var url = "../listacargadescargadetallepedido/" + strcargadescarga;
        window.location.href = url;
	});

	document.addEventListener('DOMContentLoaded', function(){
		var label = document.getElementById('resultado');
		label.textContent = '';
		document.getElementById('resultado').style.visibility='hide';

		

		$("#btnAgregarpastel").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			var strcargadescarga;
			idcargadescarga = document.getElementById('idcargadescarga');
			if (idpastel != null) {
    			strcargadescarga = idcargadescarga.value;
			}else{
    			strcargadescarga = 0;
			}
			var strpastel;
			idpastel = document.getElementById('idpastel');
			if (idpastel != null) {
    			strpastel = idpastel.value;
			}else{
    			strpastel = 0;
			}
			var strcantidad;
			cantidad = document.getElementById('cantidad');
			if (cantidad != null) {
    			strcantidad = cantidad.value;
			}else{
    			strcantidad = 0;
			}
			// var strprecio;
			// precio = document.getElementById('precio');
			// if (precio != null) {
    		// 	strprecio = precio.value;
			// }else{
    		// 	strprecio = 0;
			// }
		
			if(strpastel > 0 && strcantidad > 0){
				//var subtotal = strcantidad * strprecio;
                $.ajax({
                    url: '/postdetalleventa',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, idcargadescarga:strcargadescarga, idpastel:strpastel, cantidad:strcantidad},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
						console.log("hola");
						for (let i in data.lista){
                            alert(data.fechacargadescarga);
				        }
                    }
                }); //FIN AJAX
				var url = "../listacargadescargadetallepedido/" + strcargadescarga;
                window.location.href = url;
				var label = document.getElementById('resultado');
				label.textContent = 'Se agrego correctamente el pastel!!!!';
				document.getElementById('resultado').style.visibility='visible';
				document.getElementById('resultado').style.color ='green';
            }else{
				alert("Falta un dato para agregar pastel");
			};
            
        }); //FIN BOTON AGREGAR pastel          
		
		$("#btnQuitarpastel").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var strcargadescarga;
			idcargadescarga = document.getElementById('idcargadescarga');
			if (idpastel != null) {
    			strcargadescarga = idcargadescarga.value;
			}else{
    			strcargadescarga = 0;
			}
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$(".table tbody tr").each(function(){
				var isCkecked = $(this).find('input[type="checkbox"]').is(':checked');
				var tableSize = $(".table tbody tr").length;
				var idcargadescargadetalle = 0;
				if(isCkecked){
					var idcargadescargadetalle = $(this).find('input[type="checkbox"]').val();
					//alert("id seleccionado: " + idcargadescargadetalle);
					$.ajax({
                    	url: '/postquitardetalleventa',
                    	type: 'POST',
                    	data: {_token: CSRF_TOKEN, idcargadescargadetalle:idcargadescargadetalle},
                    	dataType: 'JSON',
                    	success: function (data) { 
							console.log(data);
							console.log("hola");
							for (let i in data.lista){
                            	alert(data.fechacargadescarga);
				        	}
                    	}
                	}); //FIN AJAX
					var url = "../listacargadescargadetallepedido/" + strcargadescarga;
                	window.location.href = url;
					var label = document.getElementById('resultado');
					label.textContent = 'Se quitaron correctamente los pastel seleccionados!!!!';
					document.getElementById('resultado').style.visibility='visible';
					document.getElementById('resultado').style.color ='green';
				}
			});
		}); //FIN BOTON QUITAR pastel      
		
		$("#btnAplicar").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			var strcargadescarga;
			idcargadescarga = document.getElementById('idcargadescarga');
			if (idpastel != null) {
    			strcargadescarga = idcargadescarga.value;
			}else{
    			strcargadescarga = 0;
			}
                $.ajax({
                    url: '/postaplicardetalleventa',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, idcargadescarga:strcargadescarga},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
						console.log("hola");
						for (let i in data.lista){
                            alert(data.fechacargadescarga);
				        }
                    }
                }); //FIN AJAX
				var url = "../listacargadescargadetallepedido/" + strcargadescarga;
                window.location.href = url;
				var label = document.getElementById('resultado');
				label.textContent = 'Compra cargada correctamente!!!!';
				document.getElementById('resultado').style.visibility='visible';
				document.getElementById('resultado').style.color ='green';
            
        }); //FIN BOTON APLICAR pastel  
		
		$("#btnAnular").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			var strcargadescarga;
			idcargadescarga = document.getElementById('idcargadescarga');
			if (idpastel != null) {
    			strcargadescarga = idcargadescarga.value;
			}else{
    			strcargadescarga = 0;
			}
                $.ajax({
                    url: '/postanulardetalleventa',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, idcargadescarga:strcargadescarga},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
						console.log("hola");
						for (let i in data.lista){
                            alert(data.fechacargadescarga);
				        }
                    }
                }); //FIN AJAX
				var url = "../listacargadescargadetallepedido/" + strcargadescarga;
                window.location.href = url;
				var label = document.getElementById('resultado');
				label.textContent = 'Compra anulada correctamente!!!!';
				document.getElementById('resultado').style.visibility='visible';
				document.getElementById('resultado').style.color ='green';
            
        }); //FIN BOTON anular pastel  

	}); //FIN DOM
</script>

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

        @if(\Session::has('Success'))
		<div class="alert alert-danger">
			<p>{{ $msgbox }}</p>
		</div>
		@endif
        
	</div>
</div>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<label id="resultado" name="resultado" class="alert alert-danger">
	</div>
</div>

<div>
    <table class="tituloDetalle">
	<tr>
            <td><h2>Cliente: </h2></td>
            <td><h2>{{$nombrecliente}}</h2></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h2></h4></td>
            <td><h2></h2></td>
            <td><h2></h2></td>
        </tr>
        <tr>
			<td><h2>Fecha: </h4></td>
            <td><h2>{{$fechacargadescarga}}</h2></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h2></h4></td>
            <td><h2></h2></td>
            <td><h2></h2></td>
        </tr>
    </table>
	<br>
	<table class="row">
		<tr>
            <td>
				<div class="form-group col-md-12">
        			<label for="pastel">pastel</label>
        		</div>
			</td>
            <td>
				<div class="form-group col-md-12">
					<label for="nombre">Cantidad</label>
				</div>
			</td>
        </tr>
        <tr>
            <td>
				<div class="form-group col-md-12">
					<div>
                    	<select id="idpastel" name="idpastel" class="form-control{{ $errors->has('idpastel') ? ' is-invalid' : '' }}" required>
                         	@foreach($pastel->get() as $index => $pastel)
                            <option value="{{  $index }}" {{ old('idpastel') == $index  ? 'selected' : '' }}>
                                {{ $pastel }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idpastel'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idpastel') }}</strong>
                        	</span>
                   		 @endif
                	</div>
        		</div>
			</td>
            <td>
				<div class="form-group col-md-12">
					<input type="number" id="cantidad" name="cantidad" class="form-control" value="{{old('cantidad')}}" placeholder="" required>
				</div>
			</td>
            <!-- <td>
				<div class="form-group col-md-12">
					<input type="number" id="precio" name="precio" class="form-control" value="{{old('precio')}}" placeholder="" required>
				</div>
			</td> -->
			<td>
				@if(($idestado) == 1)
					<button id="btnAgregarpastel" class= "btn btn-success text-light" title="Regresar">Agregar</button>
				@endif
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				@if(($idestado) == 1)
					<button id="btnQuitarpastel" class= "btn btn-danger text-light" title="Regresar">Quitar</button>	
				@endif
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				@if(($idestado) == 1)
					<button id="btnAplicar" class= "btn btn-success text-light" title="Regresar">Validado</button>
				@endif		
			</td>
			<td>
				@if ($idestado== 1 || $idestado == 2)
					<button id="btnAnular" class= "btn btn-success text-light" title="Regresar">Anular</button>		
				@endif	
			</td>
			<td>
				<div class="form-group col-md-12">
					<input type="number" style="visibility:hidden;" id="idcargadescarga" name="idcargadescarga" class="form-control" value="{{$idcargadescarga}}" placeholder="" required>
				</div>
			</td>
        </tr>
    </table>
</div>
<br>
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h2>Detalle de Venta  </h2>
	</div>
</div>
<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">pastel</th>
                    <th class="fondoGrid">Cantidad</th>
                    <th class="fondoGrid">Precio</th>
					<th class="fondoGrid">subtotal</th>
					<th class="fondoGrid">Quitar</th>
				</thead>
		
				@foreach ($cargadescargadetalle as $detalle)
				<tr>
					<td class="table-active">{{$detalle->descripcionpastel}}</td>
					<td class="table-active">{{$detalle->cantidad}}</td>
                    <td class="table-active">{{$detalle->precio}}</td>
					<td class="table-active" style="text-align:right">{{$detalle->subtotal}}</td>
                    <div id="buttonArray" class="">
					<td class="table-active alignButtonGrid">
						<input type="checkbox" id="ckDetalle" class="" value="{{$detalle->idcargadescargadetalle}}">
					</td>
                </div>
				</tr>
				@endforeach
			</table>
			Total: {{$cargadescargadetalle->total()}}
		</div>
		{{$cargadescargadetalle->render()}}
	</div>
</div>
<br>
<div class="" style="text-align: lefth; width=300">
	<table>
		<tr>
			<td>
				<a href="../cargadescarga/cargadescargapedido"><button id="regresarcargadescarga" class= "btn btn-secondary text-light" title="Regresar">Regresar</button></a>
			</td>
		</tr>
	</table>
</div>
@endsection