import Form from './Form';

export default {
    install(vue, opts){
        vue.prototype.newForm = function (data) {
            return new Form(data);
        }
    }
}