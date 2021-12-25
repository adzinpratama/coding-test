(function(window){

	window.addEventListener('DOMContentLoaded', function(){

		let submitButton = document.getElementById('submit-choose');

		submitButton.addEventListener('click', function(e){
			e.preventDefault();

			let method = document.querySelector('input[name="choose-method"]:checked');
			let inputMethod = document.getElementById('inp-method');

			inputMethod.value = method.value;

			document.getElementById('method-form').submit();
		})

	});

})(window);