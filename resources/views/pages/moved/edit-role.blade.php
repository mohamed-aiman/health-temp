@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'roles.edit'">
@endverbatim

	@include('components.heading', ['title' => 'Edit Role'])
	<input type='hidden' id="editingId" value="{{(isset($roleId)) ? $roleId : null}}" />
	<div class="container">
	@verbatim
		<div class="columns">
			<div class="column">
				<response-messages :response="editResponse"></response-messages>
			</div>
		</div>
		<div class="columns box">
			<div class="column">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label">Editing Role: {{role.name}}</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field has-addons">
						  <div class="control is-expanded">
						    <input type="text" placeholder="name" class="input" v-model="editForm.name">
						  </div>
						  <div class="control">
						    <a class="button is-warning"  @click="updateRole">
						      Update
						    </a>
						  </div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<br>
		<div class="columns">
			<div class="column">
				<response-messages :response="attachDetachResponse"></response-messages>
			</div>
		</div>
		<div class="columns box">
			<div class="column">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label">Add or remove role's permissions</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field has-addons">
						  <div class="control is-expanded">
						    <input class="input" type="text" placeholder="Find a permission" v-model="permissionQuery">
						  </div>
						</div>
					</div>
				</div>
				<table class="table is-narrow">
					<tr>
						<th>Slug</th>
						<th>Url</th>
						<th>Add(+)/Remove(-)</th>
					</tr>
					<tr v-for="permission in selectedRolePermissions">
						<td>{{permission.slug}}</td>
						<td>{{permission.name}}</td>
						<td v-if="permission.has_permission == 1">
							<button class="button is-danger" @click="detachPermission(permission)">
					            <b-icon icon="minus"></b-icon>
					        </button>
					    </td>
						<td v-if="permission.has_permission == 0">
							<button class="button is-success" @click="attachPermission(permission)">
					            <b-icon icon="plus"></b-icon>
					        </button>
					    </td>
					</tr>
				</table>
			</div>
		</div>
	@endverbatim
	</div>
</div>
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/edit-role.js')}}"></script>
@endsection