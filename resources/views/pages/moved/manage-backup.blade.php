@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Manage'])
	<div class="columns">
		<div class="column">
			<table class="table">
				@if(hasPermission('acl.dashboard'))
				<tr>
					<td colspan="2"><b>User Management</b></td>
				<tr>
					<td>
						<a href="/acl/dashboard" class="button is-success is-large" ><span>ACL Dashboard</span></a>
					</td>
				</tr>
				@endif
				@if(hasPermission('applications.index'))
				<tr>
					<td colspan="2"><b>Applications</b></td>
				<tr>
					<td>
						<a href="/applications" class="button is-success is-large" ><span>All Applications</span></a>
					</td>
				</tr>
				@endif
				@if(hasPermission('grading-points.manage') || hasPermission('grading-categories.manage'))
				<tr>
					<td colspan="2"><b>Grading Inspection Settings</b></td>
				<tr>
					<td>
						@if(hasPermission('grading-points.manage'))
						<a href="/gradingpoints/manage" class="button is-success is-large" ><span>Grading Points</span></a>
						@endif
						@if(hasPermission('grading-categories.manage'))
						<a href="/gradingcategories/manage" class="button is-success is-large" ><span>Grading Categories</span></a>
						@endif
					</td>
				</tr>
				@endif
				@if(hasPermission('normal-points.manage') || hasPermission('normal-categories.manage'))
				<tr>
					<td colspan="2"><b>Normal Inspection Settings</b></td>
				<tr>
					<td>
						@if(hasPermission('normal-points.manage'))
						<a href="/normalpoints/manage" class="button is-success is-large" ><span>Normal Points</span></a>
						@endif
						@if(hasPermission('normal-categories.manage'))
						<a href="/normalcategories/manage" class="button is-success is-large" ><span>Normal Categories</span></a>
						@endif
					</td>
				</tr>
				@endif
			</table>
		</div>
	</div>
@endsection