@extends ('layouts.admin')
@section ('contenido') 
@inject('tiposcargadescarga', 'App\Services\tipocargadescargaservicio')
@inject('clientes', 'App\Services\clienteservicio')
@inject('estados', 'App\Services\estadoservicio')

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	
	});//cierre del DOM
</script>
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>stock: </h2> <a href="cargadescargacompra/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('cargadescarga.cargadescargacompra.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Fecha</th>
					<th class="fondoGrid">Total</th>
					<th class="fondoGrid">Estado</th>
					<th class="alignButtonGrid">Opciones</th>
					<th class="alignButtonGrid">Detalle</th>
				</thead>
		
				@foreach ($cargadescarga as $cargade)
				<tr>
					<td class="table-active">{{$cargade->fecha}}</td>
					<td class="table-active" style="text-align: right;">{{$cargade->total}}</td>
					<td class="table-active">{{$cargade->descripcionestado}}</td>
					<td class="table-active alignButtonGrid">
						<!-- <a href="{{URL::action('cargadescargacompraController@edit', $cargade->idcargadescarga)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a> -->
						<a href="" data-target="#modal-delete-{{$cargade->idcargadescarga}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
					<td>
						<a href="../listacargadescargadetallecompra/{{$cargade->idcargadescarga}}"><button class="btn btn-outline-primary"><i class="fa fa-eye"></i></button></a>
					</td>
				</tr>
				@include('cargadescarga.cargadescargacompra.modal')
				@endforeach
			</table>
			Total: {{$cargadescarga->total()}}
		</div>
		{{$cargadescarga->render()}}
	</div>
</div>
@endsection