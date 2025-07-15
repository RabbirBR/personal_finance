@extends('layouts.admin_layout')

@section('styles')
<style type="text/css">
#add-note{
	color: red;
}

.table thead tr th{
	text-align: center;
}
.table tbody tr td{
	text-align: center;
	vertical-align: middle;
}
.table .comp-logo{
	/*height: : 50px;*/
	width: 50px;
	display:block;
	margin:0 auto;
}
</style>
@endsection


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Companies
	</h1>

	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a></li>
		<li class="active">Companies</li>
	</ol>
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="row" id="companies">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-danger">
				<div class="box-header with-border"><h4>Companies</h4></div>
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
	function load_companies(with_overlay){
		if(with_overlay == true){
			var overlay = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";
			$('#activity_log').find('.box').append(overlay);
		}
		// var overlay = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";

		$('#companies').find('.box').append(overlay);
		$('#companies').load('{{ url("/admin/companies/list/") }}');
	}

	$(document).ready(function(){
		load_companies(true);
	});

	$('#companies').on('submit', '#add-form', function(event){
		event.preventDefault();

		var form_data = new FormData($(this)[0]);

		$('#companies').find('#addModal').delay(5).modal('hide');

		$.ajax({
			url: '{{ url('/admin/companies/add') }}',
			method: 'POST',
			data: form_data,
			cache: false,
	        contentType: false,
	        processData: false,

			success: function(response) {
				console.log(response);
				load_companies(false);
			},

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
				load_companies(false);
			}
		});
	});

	$('#companies').on('submit', '#edit-form', function(event){
		event.preventDefault();

		var form_data = {};
		
		form_data._token = $(this).find("input[name='_token']").val();
		form_data.id = $(this).find('#id').val();
		form_data.name = $(this).find('#name').val();
		form_data.symbol = $(this).find('#symbol').val();
		form_data.code = $(this).find('#code').val();
		form_data.decimal_places = $(this).find('#decimal_places').val();
		form_data.symbol_placement = $(this).find('#symbol_placement').val();

		$('#companies').find('#editModal_'+form_data.id).delay(5).modal('hide');

		// console.log(form_data);

		$.ajax({
			url: '{{ url('/admin/companies/edit') }}',
			method: 'POST',
			async: 'false',
			data: form_data,

			success: function(response) {
				// console.log(response);
				load_companies(false);
			},

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
				load_companies(false);
			}
		});
	});
</script>
@endsection