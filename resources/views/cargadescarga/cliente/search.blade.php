{!! Form::open(array('url'=>'cargadescarga/cliente', 'method'=>'GET', 'autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group">
	<div class="input-group">
		<input type="text" class="form-control" aria-label="Small" name="searchText" placeholder="Buscar  por NIT" values="{{$searchText}}"> &nbsp;&nbsp;
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>	
		</span>
	</div>
</div>
{{Form::close()}}