@extends('layouts.admin_layout')

@section('styles')
<style type="text/css">
.table thead tr th{
	text-align: center;
}
.table tbody tr td{
	text-align: center;
	vertical-align: middle;
}
.action_col{
	width: 120px;
}

.errors-list{
	color: red;
	padding-top: 10px;
	font-size: 15px;
}
</style>
@endsection


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Currencies
	</h1>

	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a></li>
		<li class="active">Currencies</li>
	</ol>
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="row" id="currencies">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-danger">
				<div class="box-header with-border"><h4>Currencies</h4></div>
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
	var add_ledgers = [];

	function load_currencies(){
		

		var overlay = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";

		$('#currencies').find('.box').append(overlay);
		$('#currencies').load('{{ url("/admin/currencies/list/") }}');
	}

	$(document).ready(function(){
		load_currencies();
	});

	$('#currencies').on('submit', '#add-form', function(event){
		event.preventDefault();

		var form_data = {};
		
		form_data._token = $(this).find("input[name='_token']").val();
		form_data.name = $(this).find('#name').val();
		form_data.symbol = $(this).find('#symbol').val();
		form_data.code = $(this).find('#code').val();
		form_data.decimal_places = $(this).find('#decimal_places').val();
		form_data.symbol_placement = $(this).find('#symbol_placement').val();

		// console.log(form_data);

		$.ajax({
			url: '{{ url('/admin/currencies/add') }}',
			method: 'POST',
			async: 'false',
			data: form_data,

			success: function(response) {
				// console.log(response);
				if(response == 'true'){
					$('#currencies').find('#addModal').delay(5).modal('hide');
					load_currencies();
				}
				else{
					// console.log(response);
					var errors = response;
					console.log(errors);

					var error_list = "";

					$('#add-form').find('input').css('border-color', '');

					for (var error in errors) {
						if (errors.hasOwnProperty(error)) {
					        error_list = error_list + "<li>"+errors[error]+"</li>";
					        $('#add-form #'+error).css('border-color', 'red');
					    }
					}

					$('#add-form .errors-list').html(error_list);
				}
			},

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
			}
		});
	});

	$('#currencies').on('submit', '.edit-form', function(event){
		event.preventDefault();

		var form_data = {};
		
		form_data._token = $(this).find("input[name='_token']").val();
		form_data.id = $(this).find('#id').val();
		form_data.name = $(this).find('#name').val();
		form_data.symbol = $(this).find('#symbol').val();
		form_data.code = $(this).find('#code').val();
		form_data.decimal_places = $(this).find('#decimal_places').val();
		form_data.symbol_placement = $(this).find('#symbol_placement').val();

		$('#currencies').find('#editModal_'+form_data.id).delay(5).modal('hide');

		// console.log(form_data);

		$.ajax({
			url: '{{ url('/admin/currencies/edit') }}',
			method: 'POST',
			async: 'false',
			data: form_data,

			success: function(response) {
				// console.log(response);
				load_currencies();
			},

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
			}
		});
	});

	$('#currencies').on('submit', '.delete-form', function(event){
		event.preventDefault();
		var form_data = {};

		form_data._token = $(this).find("input[name='_token']").val();
		form_data.id = $(this).find('#id').val();

		$('#currencies').find('#deleteModal_'+form_data.id).delay(5).modal('hide');

		// console.log(form_data);

		$.ajax({
			url: '{{ url('/admin/currencies/delete') }}',
			method: 'POST',
			async: 'false',
			data: form_data,

			success: function(response) {
				// console.log(response);
				load_currencies();
			},

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
			}
		});
	});
</script>
@endsection