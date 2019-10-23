@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => '‫ACL Dashboard'])
@verbatim

<section v-can="'acl.dashboard'">
	<div class="columns">
		<div class="column">
			<div v-can="'roles.store'" class="box" v-if="isOpenSaveRole">
				<response-messages :response.sync="roleCreateResponse"></response-messages>
				<div class="heading">New Role</div>
				<div class="field is-grouped">
				  <p class="control is-expanded">
				    <input class="input" type="text" placeholder="Name" v-model="roleForm.name">
				  </p>
				  <p class="control">
				    <a class="button is-info" @click="saveRole">
				      Save
				    </a>
				  </p>
				</div>
			</div>
			<button v-can="'roles.store'" class="button is-success" @click="openSaveRole">Add New Role</button>
			<div id="roles" v-can="'roles.index'">
				<acl-roles :roles.sync="roles"></acl-roles>
			</div>
			<div id="permissions" v-can="'permissions.index'">
				<acl-permissions :permissions="permissions"></acl-permissions>
			</div>
		</div>
		<div id="users" class="column">
			<div v-can="'users.store'" class="box" v-if="isOpenSaveUser">
				<response-messages :response.sync="userCreateResponse"></response-messages>
				<div class="heading">New User</div>
				<div class="field is-grouped">
				  <p class="control is-expanded">
				    <input class="input" type="text" placeholder="Name" v-model="userForm.name">
				  </p>
				  <p class="control is-expanded">
				    <input class="input" type="text" placeholder="Email" v-model="userForm.email">
				  </p>
				  <p class="control">
				    <a class="button is-info" @click="saveUser">
				      Save
				    </a>
				  </p>
				</div>
			</div>
			<button v-can="'users.store'" class="button is-success" @click="openSaveUser">Add New User</button>
			<div id="users" v-can="'users.index'">
				<acl-users :users.sync="users"></acl-users>
			</div>
		</div>
	</div>
</section>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/acl-dashboard.js')}}"></script>
@endsection
