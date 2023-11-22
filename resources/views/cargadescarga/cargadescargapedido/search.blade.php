{!! Form::open(array('url'=>'cargadescarga/cargadescargapedido', 'method'=>'GET', 'autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group">
	<div class="input-group">
	<table>
		<tr>
			<td>
			<label for="categoria">Cliente</label>
			</td>
				<td>
					<div class="form-group col-md-12">	
						<div>
                    	<select id="_cliente" name="_cliente" class="form-control{{ $errors->has('idcliente') ? ' is-invalid' : '' }}" >
                         	@foreach($clientes->get() as $index => $cliente)
                            <option value="{{  $index }}" {{ old('idcliente') == $index  ? 'selected' : '' }}>
                                {{ $cliente }}
                            </option>
                        	@endforeach
                    	</select>

                   		@if ($errors->has('idcliente'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idcliente') }}</strong>
                        	</span>
                   		@endif
                		</div>
        			</div>
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
				<td>
					<label for="categoria">Estado</label>
				</td>
				<td>
				<div class="form-group col-md-12">	
						<div>
                    	<select id="_estado" name="_estado" class="form-control{{ $errors->has('idestado') ? ' is-invalid' : '' }}" >
                         	@foreach($estados->get() as $index => $estado)
                            <option value="{{  $index }}" {{ old('idestado') == $index  ? 'selected' : '' }}>
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
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
				</td>
				<td>
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>	
				</span>
				</td>
			</tr>
		</table>
	</div>
</div>
{{Form::close()}}