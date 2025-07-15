<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box @if(empty($company)) box-danger @else box-success @endif">
		<div class="box-header with-border">
			@if(empty($company))
			<h4>Transactions <small class="hidden-xs">(Choose a Company to see its Transactions)</small></h4>
			@else
			<h4>
				<span class="hidden-xs hidden-sm">Transactions for</span> <label>{{ $company->comp_name }}</label>
				@if($permission['add_transaction'])
				<div class="pull-right">
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">New Transaction</button>

					<div class="modal" id="addModal" role="dialog">
						<div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">New Transaction for {{ $company->comp_name }}</h4>
								</div>
								<form id="add-form" class="form-horizontal" action="#">
									<input type="hidden" id="comp_id" name="comp_id" value="{{ $company->id }}">
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="date" class="col-sm-3 col-md-4 control-label input-sm">Date</label>

													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="date" name="date" value="{{ date('Y-m-d') }}" required>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="ref_no" class="col-sm-3 col-md-4 control-label input-sm">Ref. No/Code</label>

													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="ref_no" name="ref_no" required>
													</div>
												</div>
											</div>

											{{-- <div class="col-md-6">
												<div class="form-group">
													<label for="amount" class="col-sm-3 col-md-4 control-label input-sm">Amount</label>

													<div class="col-sm-9 col-md-8">
														<div class="input-group">
															@if($currency_symbol_placement == 0)
															<span class="input-group-addon" id="basic-addon1">{{ $currency_symbol }}</span>
															@endif

															<input type="number" class="form-control input-sm" id="amount" name="amount" required>

															@if($currency_symbol_placement == 1)
															<span class="input-group-addon" id="basic-addon1">{{ $currency_symbol }}</span>
															@endif
														</div>
													</div>
												</div>
											</div> --}}

											<div class="col-md-12">
												<div class="form-group">
													<label for="desc" class="col-sm-3 col-md-2 control-label input-sm">Voucher/File</label>

													<div class="col-sm-9 col-md-10">
														<input class="form-control input-sm" type="file" id="ref_file" name="ref_file" accept="application/msword, application/pdf ,image/*">
														<!-- <textarea required class="form-control input-sm" id="desc" name="desc"></textarea> -->
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label for="desc" class="col-sm-3 col-md-2 control-label input-sm">Remarks</label>

													<div class="col-sm-9 col-md-10">
														<textarea required class="form-control input-sm" id="desc" name="desc"></textarea>
													</div>
												</div>
											</div>
											<hr>
											<div class="col-md-12">
												<h4>
													Ledger Entries
													<div class="pull-right">
														<button type="button" class="btn btn-sm btn-flat btn-primary add_entry_btn"><i class="fa fa-lg fa-plus"></i> Add More Entries</button>
													</div>
												</h4>
												<table class="table table-condensed table-bordered" id="ledger_entry_table">
													<thead>
														<tr>
															<th style="width: 30px;"><button type="button" class="btn btn-sm btn-flat btn-primary add_entry_btn"><i class="fa fa-lg fa-plus"></i></button></th>
															<th>Account Head</th>
															<th style="width: 80px;">Debit/Credit</th>
															<th style="width: 160px;">Amount</th>
														</tr>
													</thead>

													<tbody id="add_ledger_entries"></tbody>
												</table>
											</div>
											
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-success">Add</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
				@endif
			</h4>
			@endif
		</div>
		<div id="transactions" class="box-body">
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<th class="table-date">Date</th>
						<th class="table-ref">Reference No.</th>
						<th class="table-remarks">Remarks/Narration</th>
						<th class="table-amount">Total Amount ({{ $currency_symbol }})</th>
					</tr>
				</thead>

				@if(!empty($transactions))
				<tbody>					
					@foreach($transactions as $transaction)
					<tr>
						<td class="table-date">{{ $transaction->date }}</td>
						<td class="table-ref">{{ $transaction->ref_no }}</td>
						<td class="table-remarks">{{ $transaction->desc }}</td>
						<td class="table-amount">{{ $transaction->amount }}</td>
					</tr>
					@endforeach					
				</tbody>
				@endif
			</table>
		</div>
	</div>
</div>

