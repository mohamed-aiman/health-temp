// Vue.use(AclPlugin, { isPermissionDisabled: (process.env.MIX_PERMISSION_DISABLED === undefined) ? false : JSON.parse(process.env.MIX_PERMISSION_DISABLED)});
const optionsDefaults = {
  isPermissionDisabled: false,
  permissions: [],
  user_id: null,
}

export default {
    install(vue, opts){

        const options = { ...optionsDefaults, ...opts}

        vue.directive('can', {
          bind: function (el, binding, vnode) {
            if (options.isPermissionDisabled) {
              console.log('permission disabled')
            } else {
              if (! options.permissions
                  .includes(binding.expression
                      .replace(/'/g, "")
                      .replace(/"/g, ""))) {
                    vnode.elm.style.display = "none";
                    // Array.prototype.slice.call(vnode.elm.childNodes).forEach(function(element) {
                    //     element.style.display = "none";
                    // })

              }
            }
          }
        })

        vue.directive('cannot', {
          bind: function (el, binding, vnode) {
            if (options.isPermissionDisabled) {
              console.log('permission disabled')
            } else {
              if (options.permissions.includes(binding.expression
                      .replace(/'/g, "")
                      .replace(/"/g, ""))) {
                    vnode.elm.style.display = "none";
                    // Array.prototype.slice.call(vnode.elm.childNodes).forEach(function(element) {
                    //     element.style.display = "none";
                    // })

              }
            }
          }
        })

        vue.prototype.hasPermission = function (slug) {
            return (!options.isPermissionDisabled) ? options.permissions.includes(slug) : options.isPermissionDisabled; 
        }

        vue.prototype.can = function (slug) {
            return (!options.isPermissionDisabled) ? options.permissions.includes(slug) : options.isPermissionDisabled; 
        }

        vue.prototype.isUser = function (id) {
            if (!options.isPermissionDisabled) {
              return (id != null && id == options.user_id) ? true : false;
            } else {
              return options.isPermissionDisabled; 
            }
          }

    }
}