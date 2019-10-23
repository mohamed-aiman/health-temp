<template>
	<span>
		<a class="button is-small is-info" @click="isModalActive = true"> <b-icon icon="upload"></b-icon></a>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">{{title}}</p>
		      </header>
		      <section class="modal-card-body">
	      		<b-notification
	      			v-if="errorMessage"
		            type="is-danger"
		            role="alert">
		            {{errorMessage}}
		        </b-notification>

		        <b-field grouped>
	                <b-input 
	                	placeholder="Document Name"
	                    type="text"
	                    v-model="name"
	                    required>
	                </b-input>

    				<b-field class="file">
				        <b-upload  v-model="file" v-if="uploadStatus!=='uploading'">
				            <a class="button is-primary">
				                <b-icon icon="upload"></b-icon>
				            </a>
				        </b-upload>
				        <span class="file-name is-small" v-if="file" style="color:grey;border: none;">
				            {{ file.name }}
				        </span>
				    </b-field>    
		        </b-field>

		      </section>
		      <footer class="modal-card-foot">
		          <button 
			        class="button is-primary" 
		          	v-if="file && name" @click="uploadAndSave()"
		          >
			        Upload and Save
				  </button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['uri', 'title'],
		  data() {
		  	return {
				isModalActive:false,
				name: null,
				file: null,
				uploadStatus: null,
				errorMessage: null,
		  	}
		  },
		  methods: {
		  	uploadAndSave() {
		  		this.errorMessage = null;
				this.uploadStatus = 'uploading';
				const fd = new FormData();
				fd.set('name', this.name);
				fd.append('image', this.file, this.file.name);
				axios
				.post(this.uri, fd)
				.then(response => {
					this.uploadStatus = null;
	          		this.$emit('refresh')
	          		this.isModalActive = false;
				}, errors => {
		          	if (errors.response.status == 422) {
		          		if ("message" in errors.response.data.errors) {
		          			this.errorMessage = errors.response.data.errors.message[0]
		          		}
		          	} else {
						this.errorMessage = 'Error uploading file';
		          	}
					this.uploadStatus = null;
					this.file = null;
				});
			},

		  }
    }
</script>