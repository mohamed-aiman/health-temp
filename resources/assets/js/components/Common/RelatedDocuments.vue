<template>
	<div class="columns" v-if="can('api.'+resource+'.documents.index') && (editable || documents.length>0)">
		<div class="column">
			<table class="table is-bordered is-fullwidth is-narrow is-striped">
				<thead>
					<tr>
						<th class="is-info" colspan="2">
							{{title}}
							<span class="is-pulled-right">
								<upload-file-with-name-modal
									v-if="can(resource+'.documents.store') && editable"
									:title="'Upload a document'"
									:uri="'/'+ resource +'/' + model.id + '/documents'"
									@refresh="reloadDocuments"
								></upload-file-with-name-modal>
							</span>
						</th>
					</tr>
				</thead>
				<tbody v-if="documents">
					<tr v-for="item, index in documents">
						<td>{{item.name}}
							<span class="is-pulled-right">
	              <a v-if="can('api.'+resource+'.documents.show')" class="button is-success is-small" target="_blank" 
	                :href="'/'+ resource +'/' + model.id + '/documents/' + item.id">
	                <b-icon pack="fas" icon="eye"></b-icon>
	              </a>
								<a v-if="can('api.'+resource+'.documents.destroy') && editable" class="button is-danger is-small" target="_blank" @click="detachFromModel(item)">
	                <b-icon pack="fas" icon="close"></b-icon>
	              </a>
	            </span>
            </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
import UploadFileWithNameModal from './UploadFileWithNameModal';

export default {
  props: ['model', 'resource', 'title', 'editable'],
  components: {
  	'upload-file-with-name-modal': UploadFileWithNameModal
  },
  watch: {
  	'model.documents': function() {
  			this.documents = this.model.documents;
  	}
  },
  data() {
  	return {
  		documents: []
  	}
  },
  methods: {
  	reloadDocuments() {
  		this.$emit('refresh')
		},
		detachFromModel(item) {
			if (!confirm('are you sure you want to delete the document?')) return;

			axios
			.delete('/api/'+ this.resource +'/' + this.model.id + '/documents/' + item.id)
			.then(response => {
				this.documents = this.documents.filter(function(element) {
					return element.id != item.id;
				});
			})
			.catch(errors => console.log(errors));
		}
  }
}
</script>