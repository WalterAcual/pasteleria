@extends ('layouts.admin')
@section ('contenido') 
@inject('tiposcargadescarga', 'App\Services\tipocargadescargaservicio')
@inject('empleados', 'App\Services\empleadoservicio')
@inject('proveedores', 'App\Services\proveedorservicio')
@inject('clientes', 'App\Services\clienteservicio')
@inject('estados', 'App\Services\estadoservicio')

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
	window.addEventListener("load", function(){

	});

	document.addEventListener('DOMContentLoaded', function(){
	});

</script>

	{!! Form::model ($cargadescarga, ['method'=>'PATCH','route'=>['cargadescargacompra.update',$cargadescarga->idcargadescarga], 'files'=>'true'])!!}
	{{Form::token()}}
	@csrf

	<div class="writeinfo"></div>
<div class="form-row">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Modificar</h3> 
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
        				<label for="Empleado">Empleado</label>
						<div>
                    	<select id="_empleado" name="idempleado" class="form-control{{ $errors->has('idempleado') ? ' is-invalid' : '' }}" required disabled>
                         	@foreach($empleados->get() as $indexEmpleado => $empleado)
                            <option value="{{  $indexEmpleado }}" {{ $cargadescarga->idempleado == $indexEmpleado ? 'selected' : '' }}>
                                {{ $empleado }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idempleado'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idempleado') }}</strong>
                        	</span>
                   		 @endif
                		</div>
        				</div>
        			</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Total</label>
						<input type="number" name="total" class="form-control" value="{{$cargadescarga->total}}" placeholder="" requerid disabled>
					</div>
				</td>
				<td>
				<td>
					<div class="form-group col-md-12">
        				<label for="Estado">Estado</label>
						<div>
                    	<select id="_estado" name="idestado" class="form-control{{ $errors->has('idestado') ? ' is-invalid' : '' }}" required>
                         	@foreach($estados->get() as $indexEstadoT => $estado)
                            <option value="{{  $indexEstadoT }}" {{ $cargadescarga->idestado == $indexEstadoT ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idestado'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idestado') }}</strong>
                        	</span>
                   		 @endif
                		</div>
        				</div>
        			</div>
				</td>
				</td>
			</tr>
			<tr>
		
		</table>
		</div>
	</div>
	<div  class="form-group col-md-12">
		<a href="{{url ('cargadescarga/cargadescargacompra')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection