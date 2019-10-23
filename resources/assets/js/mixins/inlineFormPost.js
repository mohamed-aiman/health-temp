export const inlineFormPost = {
  methods: {
    postForm(url, data, errorMessagePrefix) {
        axios
        .post(url, data)
        .then(response => {
            this.response = response;
            this.$emit('formPosted');
        })
        .catch(errors => {
            this.response = errors.response;
        }); 
    }
  }
}
