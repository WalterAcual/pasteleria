@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Estados pastel: </h2> <a href="pasteltatus/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('catalogos.pasteltatus.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="table-responsive">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Descripci&oacute;n</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($pasteltatus as $productStatus)
				<tr>
					<td class="table-active">{{$productStatus->descripcionpasteltatus}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('pasteltatusController@edit', $productStatus->estado)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$productStatus->estado}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('catalogos.pasteltatus.modal')
				@endforeach
			</table>
			Total: {{$pasteltatus->total()}}
		</div>
		{{$pasteltatus->render()}}
	</div>
</div>
@endsection