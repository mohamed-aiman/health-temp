<template>
	<div id="error-messages" class="notification hero is-danger" v-if="error.title">
		<div class="title">{{error.title}}</div>
		<div class="subtitle"  v-for="message in error.messages">{{message}}</div>
	</div>
</template>

<script>
    export default {
		props: ['errorResponse'],
		data() {
			return {
				error: this.initial()
			}
		},
		watch: {
			errorResponse: {
			  immediate: true,
			  deep: true,
			  handler(newValue, oldValue) {
			  	this.error = this.initial();
			  	this.setErrors()
			  }
			}
		},
		methods: {
			initial() {
				return { title: '', messages: []};
			},
			setErrors() {
				if (this.errorResponse.status == 422) {
					this.error.title = 'Validation Error';

					Object.keys(this.errorResponse.data.errors).forEach(key => {
						this.error.messages.push(this.errorResponse.data.errors[key].toString());
					});

				}
			}
		}
    }
</script>
