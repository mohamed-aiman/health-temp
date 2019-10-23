<template>
	<span v-if="uri && can(permission)">
		<a class="button is-small is-info" @click="isModalActive = true"> <b-icon icon="upload"></b-icon></a>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">{{title}}</p>
		      </header>
		                  <!-- :value="email" -->
		      <section class="modal-card-body">
	      		<b-notification
	      				v-if="errorMessage"
		            type="is-danger"
		            role="alert">
		            {{errorMessage}}
		        </b-notification>

		          <b-field label="Upload File">
		          </b-field>
		          <b-field class="file">
		      			<template>
						    <b-field class="file">
						        <b-upload  v-model="file" v-if="uploadStatus!=='uploading'">
						            <a class="button is-primary is-small">
						                <b-icon icon="upload"></b-icon>
						            </a>
						        </b-upload>
						        <span class="file-name is-small" v-if="file" style="color:grey;border: none;">
						            {{ file.name }}
						        </span>
						    </b-field>    
						</template>
		          </b-field>

		          <b-field label="Document Type" v-if="is_type_required">
	                <b-input 
	                	v-if="is_type_required"
	                    type="text"
	                    v-model="form.document_type"
	                    required>
	                </b-input>
	            </b-field>

		      </section>
		      <footer class="modal-card-foot" v-if="is_type_required">
		          <button 
			        class="button is-primary" 
		          	v-if="form.uploaded_file_path && form.document_type" @click="uploadDocument()"
		          >
			        Upload Document
				  </button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['uri', 'title', 'is_type_required', 'permission'],
		  watch: {
		  	file: function() {
		  		if (this.file) {
			  		this.upload();
		  		}
		  	}
		  },
		  data() {
		  	return {
					isModalActive:false,
					file: null,
					uploadStatus: null,
					errorMessage: null,
					form: {
						document_type: ""
					}
		  	}
		  },
		  methods: {
		  	upload() {
		  		this.errorMessage = null;
				this.uploadStatus = 'uploading';
				const fd = new FormData();
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
			}
		  }
    }
</script>