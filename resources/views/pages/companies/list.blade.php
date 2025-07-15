<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box @if(empty($companies)) box-danger @else box-success @endif">
		<div class="box-header with-border">
			<h4>
				Companies
				<div class="pull-right">
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">Add Company</button>

					<!-- Add Modal -->
					<div class="modal" id="addModal" role="dialog">
						<div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add New Company</h4>
								</div>
								{{-- action="{{ url('/admin/companies/add') }}" method="POST" --}}
								<form id="add-form" class="form-horizontal" enctype="multipart/form-data">
									{{ csrf_field() }}
									
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="comp_name" class="col-sm-3 col-md-4 control-label input-sm">Name</label>

													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="comp_name" name="comp_name" required>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="email" class="col-sm-3 col-md-4 control-label input-sm">E-mail</label>

													<div class="col-sm-9 col-md-8">
														<input type="email" class="form-control input-sm" id="email" name="email" required>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label for="address" class="col-sm-3 col-md-2 control-label input-sm">Address</label>

													<div class="col-sm-9 col-md-10">
														<textarea class="form-control input-sm" id="address" name="address" required></textarea>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="country" class="col-sm-3 col-md-4 control-label input-sm">Country</label>
													
													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="country" name="country">
													</div>
												</div>
												
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label for="state" class="col-sm-3 col-md-4 control-label input-sm">State</label>
													
													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="state" name="state">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label for="city" class="col-sm-3 col-md-4 control-label input-sm">City</label>
													
													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="city" name="city">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="zip_code" class="col-sm-3 col-md-4 control-label input-sm">Zip Code</label>
													
													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="zip_code" name="zip_code">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="currency" class="col-sm-3 col-md-4 control-label input-sm">Currency</label>

													<div class="col-sm-9 col-md-8">
														<select class="form-control input-sm select2" id="currency" name="currency" required>
															<option></option>

															@foreach($currencies as $cur)
															<option value="{{ $cur->id }}">{{ $cur->name }} ({{ $cur->symbol }})</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="logo" class="col-sm-3 col-md-4 control-label input-sm">Logo</label>
													
													<div class="col-sm-9 col-md-8">
														<input type="file" class="form-control input-sm" id="logo" name="logo" accept="image/*">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label for="brand_color_1" class="col-sm-3 col-md-4 control-label input-sm">Primary</label>
													
													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="brand_color_1" name="brand_color_1" placeholder="Color">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label for="brand_color_2" class="col-sm-3 col-md-4 control-label input-sm">Secondary</label>
													
													<div class="col-sm-9 col-md-8">
														<input type="text" class="form-control input-sm" id="brand_color_2" name="brand_color_2" placeholder="Color">
													</div>
												</div>
											</div>

											<!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<hr>
												<span id="add-note">
													Note: Balances of all parent heads of the newly added head will be recalculated.  Please only add opening balance if the new head is suppossed to be used as a ledger.
												</span>
											</div> -->
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
			
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<th></th>
						<th class="hidden-xs hidden-sm">Logo</th>
						<th>Name</th>
						<th class="hidden-xs">Email</th>
						<th class="hidden-xs hidden-sm">Address</th>
						<th class="hidden-xs">Currency</th>
						<th>Accountants</th>
					</tr>
				</thead>
				<tbody>
					@foreach($companies as $company)
					<tr>
						<td class="edit_col">
							<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal_{{ $company->id }}">
								<i class="fa fa-pencil" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Edit</span>
							</button>
							<div class="modal" id="editModal_{{ $company->id }}" role="dialog">
								<div class="modal-dialog modal-lg">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Edit {{ $company->comp_name }}</h4>
										</div>
										<form id="edit-form" class="form-horizontal" action="#">
											{{ csrf_field() }}
											<input type="hidden" id="id" name="id" value="{{ $company->id }}">

											<div class="modal-body">
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-success">Edit</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</td>
						<td class="hidden-xs hidden-sm"><img class="comp-logo img-responsive" src="{{ $company->logo }}"></td>
						<td>{{ $company->comp_name }}</td>
						<td class="hidden-xs">{{ $company->email }}</td>
						<td class="hidden-xs hidden-sm">
							{{ $company->address }}, {{ $company->city }} @if(!empty($company->state)), {{ $company->state }} @endif, {{ $company->country }} - {{ $company->zip_code }}
						</td>
						<td class="hidden-xs">{{ $company->currency }}</td>
						<td>
							@if(sizeof($company->users) == 0)
							None.
							@else
							@foreach($company->users as $i => $accountant)
							{{ $i+1 }}. {{ $accountant->name }} <br>
							@endforeach
							@endif
						</td>
					</tr>
					
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>