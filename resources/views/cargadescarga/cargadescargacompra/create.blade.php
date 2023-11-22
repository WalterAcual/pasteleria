@extends ('layouts.admin')
@section ('contenido') 
@inject('tiposcargadescarga', 'App\Services\tipocargadescargaservicio')
@inject('clientes', 'App\Services\clienteservicio')
@inject('estados', 'App\Services\estadoservicio')
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
	document.addEventListener('DOMContentLoaded', function(){
	});
</script>

	{!! Form::open(array('url' => 'cargadescarga/cargadescargacompra', 'method' => 'POST', 'autocomplete'=>'off', 'files'=>'true')) !!}
	{{Form::token()}}
	@csrf

	<!-- <input class="getinfo"></input>
    <div class="writeinfo"></div>    -->
<div class="">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Compra</h3>
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
						<label for="nombre">Total</label>
						<input type="number" name="total" class="form-control" value="{{old('total')}}" placeholder="0.00" disabled>
					</div>
				</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="form-group col-md-12">
		<a href="{{url ('cargadescarga/cargadescargacompra')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection
