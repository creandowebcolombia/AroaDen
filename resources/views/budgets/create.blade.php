@extends('layouts.main')

@section('content')

@include('includes.patients_nav')

@include('includes.messages')
@include('includes.errors')


<meta name="_token" content="{!! csrf_token() !!}"/>

<div id="new_url" value="{!! $new_url !!}"> </div>
<div id="del_url" value="{!! $del_url !!}"> </div>

<div class="row">
  <div class="col-sm-12"> 
 	 <div class="input-group">
   	<span class="input-group-btn pad10"> <p> Finalizar </p> </span>
  		<div class="btn-toolbar pad4" role="toolbar"> 
    		<div class="btn-group">
	      		<a href="{!! url("/$main_route/$idpat") !!}" role="button" class="btn btn-sm btn-primary">
	          		Finalizar
	       		</a>
       		</div>
       	</div>
     </div>
</div> </div>


<div class="row">
 	<div class="col-sm-12">
   	<div class="panel panel-default">

    	<table class="table">
		     <tr class="fonsi15 success">
				  <td class="wid140">Tratamiento</td>
				  <td class="wid95 textcent">Precio</td>
				  <td class="wid50 textcent">Cantidad</td>
				  <td class="wid50"></td>
				  <td class="wid230"></td>
		     </tr>
    	</table>

   		<div class="box230">
	   		<table class="table table-striped">      	  	

		   		@foreach ($main_loop as $service)

					<tr>
					 	<form id="new_budgets_form">
							<input type="hidden" name="idpat" value="{!! $idpat !!}">
							<input type="hidden" name="idser" value="{!! $service->idser !!}">
							<input type="hidden" name="price" value="{!! $service->price !!}">
							<input type="hidden" name="tax" value="{!! $service->tax !!}">
							<input type="hidden" name="uniqid" value="{!! $uniqid !!}">
							<input type="hidden" name="created_at" value="{!! $created_at !!}">						 	

							  <td class="wid140">{!! $service->name !!}</td>
							  <td class="wid95 textcent">{!! $service->price !!} €</td>
							  <td class="wid50 textcent">
							  	 	<div class="form-group">
							  			<input type="number" min="1" step="1" value="1" class="form-control" name="units" required>
							  		</div>
							  </td>
							  <td class="wid50">
								  	<button type="submit" class="btn btn-sm btn-info">
								  		<i class="fa fa-plus"></i>
								  	</button>
							  </td>
							  <td class="wid230"></td>
						</form>  
					</tr>	

				  @endforeach
  	  
				</table> 

</div> </div> </div> </div>


{!! addText("Añadidos") !!}


<div class="row">
 	<div class="col-sm-12">
   	<div class="panel panel-default">

    	<table class="table">
		     <tr class="fonsi15 success">
				  <td class="wid140">Tratamiento</td>
				  <td class="wid95 textcent">Precio</td>
				  <td class="wid95 textcent">Cantidad</td>
				  <td class="wid50"></td>
				  <td class="wid230"></td>
		     </tr>
    	</table>

   		<div class="box400">
	   		<table class="table table-striped">
	   			<tbody id="budgets_list"></tbody>
	   		</table>
	   	</div> 

</div> </div> </div>


@endsection
	 
@section('js')
    @parent

	  	<script type="text/javascript" src="{!! asset('assets/js/new_budgets.js') !!}"></script>
	  	<script type="text/javascript" src="{!! asset('assets/js/del_budgets.js') !!}"></script>
@endsection