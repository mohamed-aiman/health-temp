export default {
    install(vue, opts){

        vue.prototype.dateOnly = function (datetime) {
          return moment(datetime).format("Y-MM-DD");
        }

    }
}