<template>
	<div id="response-messages" class="notification hero" :class="prepared.class" v-if="prepared.title">
		<div class="title">{{prepared.title}}</div>
		<div class="subtitle" v-for="message in prepared.messages">{{message}}</div>
	</div>
</template>

<script>
    export default {
		props: ['response'],
		data() {
			return {
				prepared: this.initial()
			}
		},
		mounted() {
			this.$emit('update:response', null);
		},
		watch: {
			response: {
			  immediate: true,
			  deep: true,
			  handler(newValue, oldValue) {
			  	this.prepared = this.initial();
			  	this.setPrepared()
			  }
			}
		},
		methods: {
			initial() {
				return { title: '', messages: [], class: ''};
			},
			setPrepared() {
				if (!this.response) return;
				
				if (this.response.status == 422) {
					this.prepared.title = 'Validation Error';
					this.prepared.class = 'is-danger';

					if (this.response.data.message) {
						this.prepared.messages.push(this.response.data.message);
					} else {
						Object.keys(this.response.data.errors).forEach(key => {
							this.prepared.messages.push(this.response.data.errors[key].toString());
						});
					}
				}

				if (this.response.status == 201) {
					this.prepared.title = 'Created successfully';
					this.prepared.class = 'is-success';
				}

				if (this.response.status == 200) {
					this.prepared.title = 'Updated successfully';
					this.prepared.class = 'is-success';
				}
			}
		}
    }
</script>
