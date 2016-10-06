<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>vue</title>
</head>
<body>
	<div id="app">
		<h1>@{{ message }}</h1>
		<input type="text" v-model="message">
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
	<script>
		var data = {
			message: 'hello world'
		};
		new Vue({
			el: '#app',
			data: data
		});
	</script>
</body>
</html>