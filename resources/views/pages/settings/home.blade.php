@extends('layouts.admin_layout')

@section('styles')
<style type="text/css">
.purchase_code{
	text-align: center;
}
.timezone{
	
}
.currency{
	text-align: center;
}
.currency_symbol{
	text-align: center;
}
.currency_code{
	text-align: center;
}
.currency_decimal_places{
	text-align: center;
}
.currency_symbol_placement{
}
</style>
@endsection


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Application Settings
		<small></small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a></li>
		<li class="active">Application Settings</li>
	</ol>
</section>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@if($code_verified == false)
			<div class="box box-danger">
				<div class="box-header with-border">
					<h4>
						Purchase Code Form <small></small>
					</h4>
				</div>
				<form class="form-horizontal" method="POST" action="{{ url('/admin/settings/purchase') }}">
					<div class="box-body">
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4><i class="icon fa fa-ban"></i> Warning!</h4>
							You have not verified your Purchase. Please insert your Purchase Code.You have <b>{{ $remaining_days }}</b> days remaining to verify your purchase.
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="purchase_code" class="col-sm-4 col-md-2 control-label input-sm">Purchase Code</label>

								<div class="col-sm-8 col-md-10">
									<input type="text" id="purchase_code" name="purchase_code" class="form-control input-sm" value="{{ $code }}">
								</div>
							</div>
						</div>
					</div>

					<div class="box-footer">
						<div class="pull-right">
							<button type="submit" class="btn btn-sm btn-success">Submit Code</button>
						</div>
					</div>
				</form>
			</div>
			@endif

			<div class="box box-primary">
				<div class="box-header with-border"><h4>Set Application Settings</h4></div>
				<form class="form-horizontal" method="POST" action="{{ url('/admin/settings/update') }}">
					<div class="box-body">
						{{ csrf_field() }}
						<div class="col-md-6">
							<div class="form-group">
								<label for="timezone" class="col-sm-4 control-label input-sm">Timezone</label>
								<div class="col-sm-8">
									<select id="timezone" name="timezone" class="form-control input-sm select2">
										@foreach($timezones as $zone)
										@if($timezone_selected_by_user == 0)
										<option value="{{ $zone }}">{{ $zone }}</option>
										@else
										<option @if($timezone == $zone) selected @endif value="{{ $zone }}">{{ $zone }}</option>
										@endif
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="default_currency" class="col-sm-4 control-label input-sm">Default Currency</label>
								<div class="col-sm-8">
									<select id="default_currency" name="default_currency" class="form-control input-sm select2">
										@foreach($currencies as $currency)
										<option @if($default_currency == $currency->id) selected @endif value="{{ $currency->id }}">
											{{ $currency->name }} - {{ $currency->symbol }}
										</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="pull-right">
							<button type="submit" class="btn btn-sm btn-success">Update</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- /.main-content -->
@endsection

@section('scripts')

@if($timezone_selected_by_user == 0)
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js"></script>

<script type="text/javascript">	
	$(document).ready(function(){
		var tz = jstz.determine(); 
		var timezone = tz.name();
		$("#timezone").val(timezone).trigger('change');
	});
</script>
@endif

@endsection