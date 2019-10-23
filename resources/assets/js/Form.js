import Errors from './Errors';
// import axios from 'axios';

class Form {
	constructor(data) {
		this.originalData = data;

		for (let field in data) {
			this[field] = data[field];
		}

		this.errors = new Errors();
	}

	reset() {
		for (let field in this.originalData) {
			this[field] = '';
		}

		this.errors.clear();
	}

	data() {
		let data = {}

		for (let property in this.originalData) {
			data[property] = this[property];
		}

		return data;
	}

	post(url) {
		return this.submit('post', url);
	}

	postWithImage(url) {
		const formData = new FormData();
			  formData.append("image", this.image);
		return new Promise((resolve, reject) => {
			axios['post'](url, this.data())
				.then(response => {
					this.onSuccess(response.data);
					resolve(response.data);
				})
				.catch(error => {
					this.onFail(error.response.data);
					reject(error.response.data);
				});
		})
	}

	
	patch(url) {
		return this.submit('patch', url);
	}


	submit(requestType, url) {
		return new Promise((resolve, reject) => {
			axios[requestType](url, this.data())
				.then(response => {
					this.onSuccess(response.data);
					resolve(response.data);
				})
				.catch(error => {
					this.onFail(error.response.data);
					reject(error.response.data);
				});
		})
	}

	onSuccess(data) {
		this.reset();
	}

	onFail(errors) {
		this.errors.record(errors);
	}
}

export default Form;