axios.get('/user/permissions')
.then(success => {
	localStorage.setItem("permissions", JSON.stringify(success.data));
});

Vue.directive('can', {
  bind: function (el, binding, vnode) {
	if (! JSON.parse(localStorage.getItem('permissions'))
		.includes(binding.expression
			.replace(/'/g, "")
			.replace(/"/g, ""))) {
		vnode.elm.style.display = "none";
	  	// Array.prototype.slice.call(vnode.elm.childNodes).forEach(function(element) {
	  	// 	element.style.display = "none";
	  	// })

	}
  }
})