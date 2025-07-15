<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box @if(empty($company)) box-danger @else box-success @endif">
		<div class="box-header with-border">
			@if(empty($company))
			<h4>Chart of Accounts <small>(Choose a Company to see its Chart of Accounts)</small></h4>
			@else
			<h4>
				<span class="hidden-xs hidden-sm">Chart of Accounts for</span> <label>{{ $company->comp_name }}</label>
				<div class="pull-right">
					@if($permission['add_account_head'])
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">Add Account</button>
					@endif

					<!-- Add Modal -->
					<div class="modal" id="addModal" role="dialog">
						<div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add New Account</h4>
								</div>
								<form id="add-form" class="form-horizontal" action="#">
									{{ csrf_field() }}
									
									<div class="modal-body">
										<input type="hidden" id="comp_id" name="comp_id" value="{{ $company->id }}">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="parent_id" class="col-sm-3 col-md-2 control-label input-sm">Parent</label>

													<div class="col-sm-9 col-md-10">
														<select required class="form-control input-sm select2" id="parent_id" name="parent_id">
															<option value=""></option>
															@foreach($account_heads as $head)
															<option value='{{ $head->id }}'>{{ $head->name }}</option>

															<?php
															if(isset($head->children)){
																showChildOptions($head->children, 1);
															}
															?>
															@endforeach
														</select>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="name" class="col-sm-3 col-md-4 control-label input-sm">Account Name</label>

													<div class="col-sm-9 col-md-8">
														<input required type="text" class="form-control input-sm" id="name" name="name">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="increased_on" class="col-sm-3 col-md-4 control-label input-sm">Increased On</label>

													<div class="col-sm-9 col-md-8">
														<select required class="form-control input-sm" id="increased_on" name="increased_on">
															<option value='0'>Debit</option>
															<option value='1'>Credit</option>
														</select>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="balance" class="col-sm-3 col-md-4 control-label input-sm">Opening Balance</label>

													<div class="col-sm-9 col-md-8">
														<div class="input-group">
															@if($currency_symbol_placement == 0)
															<span class="input-group-addon" id="basic-addon1">{{ $currency_symbol }}</span>
															@endif
															
															<input required type="number" class="form-control input-sm" id="balance" name="balance" value="">

															@if($currency_symbol_placement == 1)
															<span class="input-group-addon" id="basic-addon1">{{ $currency_symbol }}</span>
															@endif
														</div>
														
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="desc" class="col-sm-3 col-md-4 control-label input-sm">Description</label>

													<div class="col-sm-9 col-md-8">
														<textarea class="form-control input-sm" id="desc" name="desc"></textarea>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-sm-10 col-sm-offset-1">
												<span id="add-note">
													Note: Balances of all parent heads of the newly added head will be recalculated.  Please only add opening balance if the new head is suppossed to be used as a ledger.
												</span>
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
			@endif
		</div>
		<div id="account_heads" class="box-body">
			@if(!empty($account_heads))
			<div class="nav-tabs-custom">
				<div class="hidden-sm hidden-md hidden-lg">
					<div id="mobile-acc-type" class="form-group">
						<label>Choose Account Type</label>
						<select class="form-control input-sm select2" id="account_head_dropdown">
							@foreach($account_heads as $i => $head)	
							<option @if($i == 0) selected @endif value="{!! $head->id !!}">{{ $head->name }}</option>
							@endforeach
						</select>
					</div>
					
				</div>
				
				<ul class="nav nav-tabs nav-justified hidden-xs">
					@foreach($account_heads as $i => $head)					
					<li id="main_accounts_{!! $head->id !!}" class="main_accounts @if($i == 0) active  @endif"><a href="#tab_{!! $head->id !!}" id="{!! $head->id !!}" data-toggle="tab"><strong>{!! $head->name !!}</strong></a></li>					
					@endforeach
				</ul>

				<div class="tab-content">
					@foreach($account_heads as $i => $head)					
					<div class="tab-pane @if($i == 0) active @endif" id="tab_{!! $head->id !!}">
						<h3>
							{!! $head->name !!}<br>
							<small>{!! $head->desc !!}</small>
						</h3>
						<table class="table table-condensed table-striped">
							<tbody>
								<tr>
									<th>Current Opening Balance</th>
									<td class="balance_col">
										@if($currency_symbol_placement == 0)
										{{ $currency_symbol }}
										@endif

										{!! number_format($head->opening_balance, $currency_decimal_places) !!}

										@if($currency_symbol_placement == 1)
										{{ $currency_symbol }}
										@endif
									</td>
								</tr>
								<tr>
									<th>Current Closing Balance</th>
									<td class="balance_col">
										@if($currency_symbol_placement == 0)
										{{ $currency_symbol }}
										@endif

										{!! number_format($head->opening_balance, $currency_decimal_places) !!}

										@if($currency_symbol_placement == 1)
										{{ $currency_symbol }}
										@endif
									</td>
								</tr>
								
							</tbody>
						</table>

						<hr>

						<table class="table table-condensed table-bordered">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th rowspan="2">Account Heads</th>
									<th class="hidden-xs hidden-sm" rowspan="2">Description</th>
									<th class="hidden-xs" id="update_header" rowspan="2">Last Updated On</th>
									<th id="increase_header" class="hidden-xs" rowspan="2">Increases On</th>
									<th class="balances_header" rowspan="1" colspan="2">Today's Balance</th>
								</tr>
								<tr>
									<th class="balances_header">Opening Balance ({{ $currency_symbol }})</th>
									<th class="balances_header">Closing Balance ({{ $currency_symbol }})</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(isset($head->children)){
									showChildList($head->children, 0, $currency_decimal_places);
								}
								?>
							</tbody>
						</table>
					</div>

					@endforeach
				</div>
				<!-- /.tab-content -->
			</div>
			@endif
		</div>
	</div>
</div>

<?php
function showChildList($children, $mult, $currency_decimal_places){
	$padding = $mult*1.5;
	if(isset($children)){
		foreach ($children as $head) {
			?>
			<tr id="{{ $head->id }}" class="children child_of_{{ $head->parent_id }}" >
			@if(!empty($head->children))
			<td class="handle"><strong><i class="fa fa-lg fa-angle-down"></i></strong></td>
			@else
			<td></td>
			@endif

			<td style='padding-left: {!! $padding+0.5 !!}rem;'>{!! $head->name !!}</td>
			<td class="hidden-xs hidden-sm">{!! $head->desc !!}</td>
			<td class="hidden-xs">{!! $head->last_update_date !!}</td>
			<td class="hidden-xs">
			@if($head->increased_on == 0)
			Debit
			@elseif($head->increased_on == 1)
			Credit
			@endif
			</td>
			<td class="balance_col">{!! number_format($head->opening_balance, $currency_decimal_places) !!}</td>
			<td class="balance_col">{!! number_format($head->closing_balance, $currency_decimal_places) !!}</td>
			</tr>
			<?php
			showChildList($head->children, ($mult+1), $currency_decimal_places);
		}
	}
}

function showChildOptions($children, $mult){
	$indent = $mult*2;
	if(isset($children)){
		foreach ($children as $head) {
			echo "<option value='".$head->id."'>";
			for ($i=0; $i < $indent; $i++) { 
				echo "&nbsp;&nbsp";
			}
			echo $head->name."</option>";
			?>

			<?php
			showChildOptions($head->children, ($mult+1));
		}
	}
}
?>