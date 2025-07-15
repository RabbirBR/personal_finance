@extends('layouts.admin_layout')

@section('styles')
<style type="text/css">
	#activity_log .box-body{
		
	}
	#activity_log table th{
		text-align: center;
	}
	#activity_log table td{
		text-align: center;
		vertical-align: middle;
	}
	#activity_log .narration{
		text-align: left;
	}

	#activity_log .date_col{
		width: 80px;
	}
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Activity Log
		<small></small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a></li>
		<li class="active">Activity Log</li>
	</ol>
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-primary">
				<div class="box-header with-border"><h4>Filter</h4></div>
				<div class="box-body">
					<form class="form-horizontal">
						<div class="row" id="filter">
							<div class="col-md-6">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="affected_model" class="col-sm-3 control-label input-sm">Date Range</label>

									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" id="from_date" name="from_date" class="form-control" value="{{ $from_date }}">
											<span class="input-group-addon"> To </span>
											<input type="text" id="to_date" name="to_date" class="form-control" value="{{ $to_date }}">
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="user_id" class="col-sm-3 control-label input-sm">User</label>

									<div class="col-sm-8">
										<select id="user_id" class="form-control input-sm select2">
											<option value="All">All</option>
											@foreach($users as $user)
											<option value="{{ $user->id }}">{{ $user->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="action" class="col-sm-3 control-label input-sm">Action</label>

									<div class="col-sm-8">
										<select id="action" class="form-control input-sm select2">
											<option value="All">All</option>
											<option value="Add">Add</option>
											<option value="Edit">Edit</option>
											<option value="Delete">Delete</option>
											<option value=""></option>
											<option value=""></option>
											<option value=""></option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row" id="activity_log">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-danger">
				<div class="box-header with-border"><h4>Activity Log</h4></div>
				<div class="box-body">
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.main-content -->
@endsection

@section('scripts')

<script type="text/javascript">
	function loadActivities(with_overlay){
		var form_data = {};

		form_data._token = $("#filter input[name='_token']").val();
		form_data.user_id = $('#filter #user_id option:selected').val();
		form_data.action = $('#filter #action option:selected').val();
		form_data.from_date = $('#filter #from_date').val();
		form_data.to_date = $('#filter #to_date').val();

		if(with_overlay == true){
			var overlay = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";
			$('#activity_log').find('.box').append(overlay);
		}

		$.ajax({
			url: '{{ url("/admin/activity/list/") }}',
			method: 'POST',
			async: 'false',
			data: form_data,

			success: function(response) {
				// console.log(response);
				$('#activity_log').html(response);
			},

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
				console.log(thrownError);
			}
		});
	}

	$('#user_id, #action, #from_date, #to_date').change(function(event){
		loadActivities(true);
	});

	$(document).ready(function(){
		loadActivities(true);
	});

	setInterval(function(){
		loadActivities(false);
	}, 30000);
</script>
@endsection