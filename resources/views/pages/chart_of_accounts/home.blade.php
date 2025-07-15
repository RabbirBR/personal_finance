@extends('layouts.admin_layout')

@section('styles')
<style type="text/css">
	#account_heads{
		overflow-x: auto;
		padding: 15px 0px 0px 0px;
	}

	.nav-tabs-custom{
		overflow-x: auto;
		margin-bottom: 0px;
	}

	.nav-tabs-custom .tab-pane{
		min-height: 400px;
		max-height: 5000px;
		overflow-y: auto;
	}

	#mobile-acc-type{
		padding: 0px 10px 0px 10px;
	}

	#increase_header{
		text-align: center;
		width: 50px;
	}

	#update_header{
		text-align: center;
		width: 100px;
	}

	.balances_header{
		text-align: center;
	}

	#add-form #balance{
		text-align: right;
	}

	#account_heads table tr td{
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	.btn-middle{
		vertical-align: middle;
	}

	#account_heads table tbody tr td:nth-child(1) {
		cursor: pointer;
		text-align: center;
	}

	#account_heads table tbody tr td:nth-child(3) {
		text-align: left;
	}

	#account_heads table tbody tr td:nth-child(4) {
		text-align: center;
	}

	#account_heads table tbody tr td:nth-child(5) {
		text-align: center;
	}

	#account_heads table tbody tr td:nth-child(6) {
		text-align: right;
	}
	#account_heads .balance_col {
		text-align: right;
	}

	#add-note{
		text-align: center;
		color: red;
	}



</style>
@endsection


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Chart of Accounts
		<small></small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a></li>
		<li class="active">Chart of Accounts</li>
	</ol>
</section>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-primary">
				<div class="box-header with-border"><h4>Choose Company</h4></div>
				<div class="box-body">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-2">
						<form class="form-horizontal">
							<div class="form-group">
								<label for="company" class="col-sm-3 control-label input-sm">Company</label>

								<div class="col-sm-8">
									<select id="company" class="form-control input-sm select2">
										<option></option>
										@foreach($companies as $company)
										<option value="{{ $company->id }}">{{ $company->comp_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" id="chart_of_accounts">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-danger">
				<div class="box-header with-border"><h4>Chart of Accounts <small>(Choose a Company to see its Chart of Accounts)</small></h4></div>
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
	function loadChartOfAccounts(){
		var comp_id = $('#company').val();
		var overlay = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";
		$('#chart_of_accounts').find('.box').append(overlay);
		$('#chart_of_accounts').load('{{ url("/accounting/accountHeads/list/") }}/'+comp_id, function( response, status, xhr ) {
			$('#chart_of_accounts').find('.select2').select2({
				width: '100%',
				placeholder: 'Select an option'
			});
		});
	}

	function loadChartOfAccountsWithId(id){
		var comp_id = $('#company').val();
		var overlay = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";
		$('#chart_of_accounts').find('.box').append(overlay);
		$('#chart_of_accounts').load('{{ url("/accounting/accountHeads/list/") }}/'+comp_id, function( response, status, xhr ) {
			$('#chart_of_accounts').find('.select2').select2({
				width: '100%',
				placeholder: 'Select an option'
			});

			$("#tab_"+id).addClass('active');
			$(".tab-pane").not("#tab_"+id).removeClass('active');

			$("#main_accounts_"+id).addClass('active');
			$(".main_accounts").not("#main_accounts_"+id).removeClass('active');
		});
	}

	$('#company').change(function(event){
		loadChartOfAccounts();
	});

	$('#chart_of_accounts').on('click', '.handle', function(){
		var id = $(this).parent().attr('id');

		if($(this).find('i').hasClass('fa-angle-down')){
			var child_id = $('.child_of_'+id).attr('id');
			openOrCloseChildren(child_id, 'close');

			$(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-right');
			$('.child_of_'+id).find('td').slideUp(80);
		}
		else if($(this).find('i').hasClass('fa-angle-right')){
			var child_id = $('.child_of_'+id).attr('id');
			openOrCloseChildren(child_id, 'open');

			$(this).find('i').removeClass('fa-angle-right').addClass('fa-angle-down');
			$('.child_of_'+id).find('td').slideDown(80);			
		}
	});

	function openOrCloseChildren(id, open_close){
		var children = $('#chart_of_accounts').find('.child_of_'+id);
		if(children.length > 0){
			$('#chart_of_accounts').find('.child_of_'+id).each(function(){
				var child_id = $(this).attr('id');

				if(open_close == 'close'){
					openOrCloseChildren(child_id, 'close');// Add to Activity

					$('#child_id').find('i').removeClass('fa-angle-down').addClass('fa-angle-right');
					$('.child_of_'+id).find('td').slideUp(80);
				}
				else if(open_close == 'open'){
					openOrCloseChildren(child_id, 'open');

					console.log('Opening: ' + child_id);
					console.log($('#child_id').find('i'));

					$('#child_id').find('i').removeClass('fa-angle-right').addClass('fa-angle-down');
					$('.child_of_'+id).find('td').slideDown(80);
				}
			});
		}
	}

	$('#chart_of_accounts').on('change', '#add-form #parent_id', function(){
		var parent_id = $('#chart_of_accounts #add-form #parent_id').val();
		$('#chart_of_accounts #add-form #increased_on').load('{{ url("/accounting/accountHeads/debit_credit/") }}/'+parent_id);
	});

	$('#chart_of_accounts').on('submit', '#add-form', function(event){
		event.preventDefault();

		var form_data = {};
		
		form_data._token = $(this).find("input[name='_token']").val();
		form_data.comp_id = $(this).find('#comp_id').val();
		form_data.parent_id = $(this).find('#parent_id').val();
		form_data.name = $(this).find('#name').val();
		form_data.increased_on = $(this).find('#increased_on').val();
		form_data.balance = $(this).find('#balance').val();
		form_data.desc = $(this).find('#desc').val();

		$('#chart_of_accounts').find('#addModal').delay(5).modal('hide');

		// console.log(form_data);

		$.ajax({
			url: '{{ url('/accounting/accountHeads/add') }}',
			method: 'POST',
			async: 'false',
			data: form_data,

			success: function(response) {
				// console.log(response);
				loadChartOfAccountsWithId(response);
			},

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
				console.log(thrownError);
			}
		});
	});

	$('#chart_of_accounts').on('change', '#account_head_dropdown', function(){
		var id = $(this).val();
		$("#tab_"+id).addClass('active');
		$(".tab-pane").not("#tab_"+id).removeClass('active');

		$("#main_accounts_"+id).addClass('active');
		$(".main_accounts").not("#main_accounts_"+id).removeClass('active');
	});

	$('#chart_of_accounts').on('click', '.main_accounts', function(){
		var id = $(this).find('a').attr('id');

		$("#account_head_dropdown").val(id).trigger('change');
	});

</script>
@endsection