@extends('layouts.admin_layout')

@section('styles')
<style type="text/css">
.table-date{
	text-align: center;
	width: 80px;
}
.table-ref{
	text-align: center;
}
.table-remarks{

}
.table-amount{
	text-align: right;
}

#ledger_entry_table tbody tr td{
	text-align: center;
	vertical-align: middle;

}
</style>
@endsection


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Transactions
		<small></small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a></li>
		<li class="active">Transactions</li>
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

	<div class="row" id="transactions_list">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-danger">
				<div class="box-header with-border"><h4>Transactions <small>(Choose a Company to see its Transactions)</small></h4></div>
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
	$('#company').change(function(event){
		loadTransactions();
	});

	var total_debit = 0;
	var total_credit = 0;

	var add_ledger_entries = [];

	$('#transactions_list').on('click', '#add-form .add_entry_btn', function(){
		add_form_ledger_entry_add();
	});

	$('#transactions_list').on('change', '#add-form .account_head', function(){
		var indx = $(this).parent().parent().find('.indx').val();
		add_form_ledger_entry_edit(indx);
	});

	$('#transactions_list').on('change', '#add-form .head_type', function(){
		var indx = $(this).parent().parent().find('.indx').val();
		add_form_ledger_entry_edit(indx);
	});

	$('#transactions_list').on('keyup', '#add-form .ledger_amount', function(){
		var indx = $(this).parent().parent().find('.indx').val();
		add_form_ledger_entry_edit(indx);
	});

	function add_form_ledger_entry_edit(indx){
		
		add_ledger_entries[indx].head_id = parseInt($("#add_ledger_entries").find(".indx[value='"+indx+"']").parent().find('.account_head').val());
		add_ledger_entries[indx].type = parseInt($("#add_ledger_entries").find(".indx[value='"+indx+"']").parent().find('.head_type').val());
		add_ledger_entries[indx].amount = parseFloat($("#add_ledger_entries").find(".indx[value='"+indx+"']").parent().find('.ledger_amount').val());


		recalculate_totals();
	}

	function add_form_ledger_entry_add(){
		ledger_entry = {
			head_id: 0,
			type: '',
			amount: 0,
		};

		add_ledger_entries.push(ledger_entry);

		recreate_add_ledger_entry_table();
		recalculate_totals();
	}

	function recreate_add_ledger_entry_table(){
		// console.clear();
		recalculate_totals();
		// console.log(add_ledger_entries);

		var l = add_ledger_entries.length;

		var table = "";

		$('#add_ledger_entries').empty();

		// console.log(add_ledger_entries);

		for(var i = 0; i < l; i++){
			var comp_id = $('#company').val();
			var data = add_ledger_entries[i];

			var head_select;

			var ajax_url = "{{ url("/accounting/transactions/get_select/") }}/"+comp_id+"/"+data.head_id;

			$.ajax({
				url: ajax_url,
				data: {
					comp_id: comp_id
				},
				type: "GET",
				async: false,
				dataType: "html",
				success: function (response) {
					head_select = response;
				},
				error: function(xhr, ajaxOptions, thrownError) {
				console.log(xhr.thrownError);
				}
			});

			var debit_credit_select = "<select required class='form-control head_type'>";
			if(data.type == 0){
				debit_credit_select += "<option selected value='0'>Debit</option><option value='1'>Credit</option>";
			}
			else if(data.type == 1){
				
				debit_credit_select += "<option value='0'>Debit</option><option selected value='1'>Credit</option>";
			}
			else{
				debit_credit_select += "<option value='0'>Debit</option><option value='1'>Credit</option>";	
			}
			debit_credit_select += "</select>";

			var row = "<tr>";
			var row = row + "<input type='hidden' class='indx' value='"+i+"'>";
			var row = row + "<td class='ledger-btn-col' style='width:30px;'><button type='button' class='btn btn-sm btn-flat btn-danger' onclick='deleteAddLedger("+i+")'><i class='fa fa-remove'></i></button></td>";
			var row = row + "<td>"+head_select+"</td>";
			var row = row + "<td>"+debit_credit_select+"</td>";
			var row = row + "<td><input type='number' class='form-control ledger_amount' style='text-align: right;' value='"+data.amount+"'></td>";
			var row = row + "</tr>";

			table = table + row;
		}

		$('#transactions_list').find('#add-form').find('#add_ledger_entries').html(table);

		$('#add_ledger_entries').find('.select2').select2({
			width: '100%',
			height: 'auto',
			placeholder: 'Select an option'
		});
	}

	function loadTransactions(){
		var comp_id = $('#company').val();
		var overlay = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";
		$('#transactions_list').find('.box').append(overlay);
		$('#transactions_list').load('{{ url("/accounting/transactions/list/") }}/'+comp_id);

		total_debit = 0;
		total_credit = 0;
		add_form_ledger_entries = [];


		recreate_add_ledger_entry_table();
	}

	function deleteAddLedger(indx){
		add_ledger_entries.splice(indx, 1);

		recreate_add_ledger_entry_table();
		
	}

	function recalculate_totals(){
		var l = add_ledger_entries.length;

		total_debit = 0;
		total_credit = 0;

		for(var i = 0; i < l; i++){
			if(add_ledger_entries[i].type == 0){
				total_debit += add_ledger_entries[i].amount;
			}
			else if(add_ledger_entries[i].type == 1){
				total_credit += add_ledger_entries[i].amount;
			}
		}
		
		console.clear();
		console.log("Total Debit: " + total_debit);
		console.log("Total Credit:" + total_credit);
		console.log(add_ledger_entries);
	}

	


</script>
@endsection