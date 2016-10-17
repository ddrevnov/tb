@extends('layouts.layoutDirector')
@section('content')
	<section class="director-kunden director-main">
		<h1 class="director-content__heading heading heading__h1">Protocol</h1>

		<div class="director-content">

			<table class="table table--striped" id="clients-table">
				<thead>
				<tr>
					<th>Nr:</th>
					<th>Datum</th>
					<th>Author</th>
					<th>Activity</th>
					<th>Changed</th>
				</tr>
				</thead>
				<?php $i = 1 + (($protocols->currentPage() - 1) * $protocols->perPage())?>
				<tbody>
				@foreach($protocols as $protocol)
					<tr>
						<td>{{$i}}</td>
						<td>{{$protocol->created_at}}</td>
						<td>
							@if($protocol->author == 'admin')
								admin
							@else
								director
							@endif
						</td>
						<td>{{$protocol->type}}</td>
						<td>
							@if(isset($protocol->old_value))
								{{$protocol->old_value}} -> {{$protocol->new_value}}
							@else
								{{$protocol->new_value}}
							@endif
						</td>
					</tr>
					<?php $i++?>
				@endforeach
				</tbody>
			</table>
			{!! $protocols->render() !!}
		</div>

	</section>
@stop