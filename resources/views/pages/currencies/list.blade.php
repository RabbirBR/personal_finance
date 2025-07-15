<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box @if(empty($currencies)) box-danger @else box-success @endif">
		<div class="box-header with-border">
			<h4>
				Currencies
				<div class="pull-right">
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">Add Currency</button>

					<!-- Add Modal -->
					<div class="modal" id="addModal" role="dialog">
						<div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add New Currency</h4>
								</div>  
								{{-- method="POST" action="{{ url('/admin/currencies/add') }}" --}}
								<form id="add-form" class="form-horizontal">
									{{ csrf_field() }}
									
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="name" class="col-sm-3 col-md-2 control-label input-sm">Currency Name</label>

													<div class="col-sm-9 col-md-10">
														<input type="text" class="form-control input-sm" id="name" name="name" autocomplete="off">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="symbol" class="col-sm-3 col-md-4 control-label input-sm">Symbol</label>

													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" autocomplete="off" id="symbol" name="symbol" style="text-align: center;" maxlength="1" placeholder="Ex: $, ৳">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="code" class="col-sm-3 col-md-4 control-label input-sm">Currency Code</label>

													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" autocomplete="off" id="code" name="code" style="text-align: center;" maxlength="3" placeholder="Ex: USD, BDT">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="decimal_places" class="col-sm-3 col-md-4 control-label input-sm">Decimal Places</label>

													<div class="col-sm-9 col-md-8">
														<input type="number" class="form-control input-sm" id="decimal_places" name="decimal_places" style="text-align: center;" min="0" max="8" placeholder="Number of digits after decimal.">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="symbol_placement" class="col-sm-3 col-md-4 control-label input-sm">Symbol Placement</label>

													<div class="col-sm-9 col-md-8">
														<select class="form-control input-sm" id="symbol_placement" name="symbol_placement" required>
															<option value='0'>Before Values (Ex: $1,000)</option>
															<option value='1'>After Values (Ex: 1,000৳)</option>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="row">

											<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-4">

												<ol class="errors-list"></ol>
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
			</h4>
		</div>
		<div class="box-body">
			<label class="text-danger">*Note: Cannot Delete Currencies associated to atleast one company.</label>
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<th></th>
						<th>Name</th>
						<th>Symbol</th>
						<th>Code</th>
						<th>Decimal Places</th>
						<th class="hidden-xs">Symbol Placement</th>
						<th class="hidden-xs hidden-sm">Companies currently using this currency</th>
					</tr>
				</thead>
				<tbody>
					@foreach($currencies as $currency)
					<tr>
						<td class="action_col">
							<div class="pull-left">
								<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal_{{ $currency->id }}"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="hidden-xs">Edit</span></button>
								<div class="modal" id="editModal_{{ $currency->id }}" role="dialog">
									<div class="modal-dialog modal-lg">

										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Edit {{ $currency->name }}</h4>
											</div>
											<form class="form-horizontal edit-form" action="#">
												{{ csrf_field() }}
												<input type="hidden" id="id" name="id" value="{{ $currency->id }}">

												<div class="modal-body">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label for="name" class="col-sm-3 col-md-2 control-label input-sm">Currency Name</label>

																<div class="col-sm-9 col-md-10">
																	<input type="text" class="form-control input-sm" id="name" name="name" required value="{{ $currency->name }}">
																</div>
															</div>
														</div>

														<div class="col-md-6">
															<div class="form-group">
																<label for="symbol" class="col-sm-3 col-md-4 control-label input-sm">Symbol</label>

																<div class="col-sm-9 col-md-8">
																	<input type="text" class="form-control input-sm" autocomplete="off" id="symbol" name="symbol" style="text-align: center;" maxlength="1" placeholder="Ex: $, ৳" value="{{ $currency->symbol }}">
																</div>
															</div>
														</div>

														<div class="col-md-6">
															<div class="form-group">
																<label for="code" class="col-sm-3 col-md-4 control-label input-sm">Currency Code</label>

																<div class="col-sm-9 col-md-8">
																	<input type="text" class="form-control input-sm" autocomplete="off" id="code" name="code" style="text-align: center;" maxlength="3" placeholder="Ex: USD, BDT" required value="{{ $currency->code }}">
																</div>
															</div>
														</div>

														<div class="col-md-6">
															<div class="form-group">
																<label for="decimal_places" class="col-sm-3 col-md-4 control-label input-sm">Decimal Places</label>

																<div class="col-sm-9 col-md-8">
																	<input type="number" class="form-control input-sm" id="decimal_places" name="decimal_places" style="text-align: center;" min="0" max="20" placeholder="Number of digits after decimal." required value="{{ $currency->decimal_places }}">
																</div>
															</div>
														</div>

														<div class="col-md-6">
															<div class="form-group">
																<label for="symbol_placement" class="col-sm-3 col-md-4 control-label input-sm">Symbol Placement</label>

																<div class="col-sm-9 col-md-8">
																	<select class="form-control input-sm" id="symbol_placement" name="symbol_placement" required>

																		<option value='0' @if($currency->symbol_placement == 0) selected @endif >Before Values (Ex: $1,000)</option>
																		<option value='1' @if($currency->symbol_placement == 1) selected @endif >After Values (Ex: 1,000৳)</option>																	
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-success">Edit</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</form>
										</div>

									</div>
								</div>
							</div>

							@if($currency->can_delete == true)
							<div class="pull-right">
								<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal_{{ $currency->id }}"><i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs">Delete</span></button>

								<div class="modal" id="deleteModal_{{ $currency->id }}" role="dialog">
									<div class="modal-dialog modal-lg">

										{{-- Modal content --}}
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Confirm the Delete of {{ $currency->name }}</h4>
											</div>
											<form class="form-horizontal delete-form" action="#">
												{{ csrf_field() }}
												<input type="hidden" id="id" name="id" value="{{ $currency->id }}">

												<div class="modal-body">
													<div class="row">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<label>Are you sure you want to delete?</label>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-danger">Confirm Delete</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
												</div>
											</form>
										</div>

									</div>
								</div>
							</div>
							@endif
						</td>
						<td>{{ $currency->name }}</td>
						<td>{{ $currency->symbol }}</td>
						<td>{{ $currency->code }}</td>
						<td>{{ $currency->decimal_places }}</td>
						<td class="hidden-xs">
							@if($currency->symbol_placement == 0)
							Before Values
							@elseif($currency->symbol_placement == 1)
							After Values
							@endif
						</td>
						<td class="hidden-xs hidden-sm">
							@foreach($currency->companies as $i => $company)
							{{ $i+1 }}. {{ $company->comp_name }} <br>
							@endforeach
						</td>
					</tr>




					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>