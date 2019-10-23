@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'users.edit'">
@endverbatim

	@include('components.heading', ['title' => 'Edit User'])
	<input type='hidden' id="editingId" value="{{(isset($userId)) ? $userId : null}}" />
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
					    <label class="label">Editing User: {{user.name}}</label>
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
						    <a class="button is-warning"  @click="updateUser">
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
					    <label class="label">Add or remove user's roles</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field has-addons">
						  <div class="control is-expanded">
						    <input class="input" type="text" placeholder="Find a role" v-model="roleQuery">
						  </div>
						</div>
					</div>
				</div>
				<table class="table is-narrow">
					<tr>
						<th>Slug</th>
						<th>Name</th>
						<th>Add(+)/Remove(-)</th>
					</tr>
					<tr v-for="role in selectedUserRoles">
						<td>{{role.slug}}</td>
						<td>{{role.name}}</td>
						<td v-if="role.has_role == 1">
							<button class="button is-danger" @click="detachRole(role)">
					            <b-icon icon="minus"></b-icon>
					        </button>
					    </td>
						<td v-if="role.has_role == 0">
							<button class="button is-success" @click="attachRole(role)">
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
<script type="text/javascript" src="{{mix('/js/edit-user.js')}}"></script>
@endsection