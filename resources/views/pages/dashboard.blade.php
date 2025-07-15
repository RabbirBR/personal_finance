@extends('layouts.admin_layout')

@section('styles')
<style type="text/css">
</style>
@endsection


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Dashboard
		<small></small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
</section>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	@if($code_verified == false)
	<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="icon fa fa-ban"></i> Warning!</h4>
		You have not verified your Purchase. Please go to settings and insert your Purchase Code or ask an admin to input purchase code. You have <b>{{ $remaining_days }}</b> days remaining to verify your purchase.
	</div>
	@endif
</section>
<!-- /.main-content -->
@endsection

@section('scripts')
<script type="text/javascript"></script>
@endsection