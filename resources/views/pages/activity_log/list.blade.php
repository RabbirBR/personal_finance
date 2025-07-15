<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box @if(empty($activities)) box-danger @else box-success @endif">
		<div class="box-header with-border">
			<h4>
				Activity Log
			</h4>
		</div>
		<div class="box-body">
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<!-- <th class="date_col">Date</th> -->
						<!-- <th>User ID</th> -->
						<th>User</th>
						<th class="narration">Description</th>
						<th class="hidden-xs hidden-sm">Affected Module</th>
						{{-- <th>Ref. ID</th> --}}
						<th class="hidden-xs">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($activities as $activity)
					<tr>
						<!-- <td class="date_col">{{ $activity->date }}</td> -->
						<!-- <td>{{ $activity->user_id }}</td> -->
						<td>{{ $activity->user_name }}</td>
						<td class="narration">{!! $activity->narration !!}</td>
						<td class="hidden-xs hidden-sm">{{ $activity->affected_module }}</td>
						{{-- <td>{{ $activity->ref_id }}</td> --}}
						<td class="hidden-xs">{{ $activity->action }}</td>
						
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>