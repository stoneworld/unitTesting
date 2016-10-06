<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>vue</title>
</head>
<body>
	<div id="app">
		@{{ $data | json }}
		<div v-for="plan in plans">
			<plan :plan="plan" :active.sync="active">
				
			</plan>	
		</div>
		<div v-my-directive="someValue"></div>
	</div>
	<template id="plan-template">
		<div>

			<span>
				@{{ plan.name }}
			</span>
			<span>
				@{{ plan.price }}
			</span>
			<button @click="setActivePlan">
				@{{ isUpgrade ? "Upgrade" : "downgrade" }}
			</button>
		</div>
	</template>
	<script src="//cdn.bootcss.com/vue/1.0.26/vue.js"></script>
	<script>
		Vue.directive('my-directive', {
			bind: function () {
				alert(1222);
			// 准备工作
			// 例如，添加事件处理器或只需要运行一次的高耗任务
			},
			update: function (newValue, oldValue) {
			// 值更新时的工作
			// 也会以初始值为参数调用一次
			},
			unbind: function () {
			// 清理工作
			// 例如，删除 bind() 添加的事件监听器
			}
		})
		new Vue({
			el: '#app',
			data: {
				plans: [
					{ name: 'enterprise', price: 100},
					{ name: 'stoneworld', price: 1000},
					{ name: 'prise', price: 120},
					{ name: 'enter', price: 140},
				],
				active: {}
			},
			components: {
				plan: {
					template: '#plan-template',
					props: ['plan', 'active'],
					computed: {
						isUpgrade: function () {
							return this.plan.price > this.active.price;
						}
					},
					methods: {
						setActivePlan: function () {
							this.active = this.plan;
						}
					}
				}
			}
		});
	</script>
</body>
</html>