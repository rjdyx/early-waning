/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>

    <div id="app">
        <router-view></router-view>
		<!-- <input type="text" v-model="value"> -->
		<!-- <button @click="sendMsg">Go</button> -->
    </div>

</template>

<script>

    export default {
        name:'App',
        data () {
        	return {
        		ws: new WebSocket('ws://localhost:3000/ws/chat'),
        		value: ''
        	}
        },
        mounted () {
        	this.ws.onmessage = function(event) {
		        var data = event.data;
		        console.log('onmessage');
		        console.log(data);
		    };

		    this.ws.onclose = function (evt) {
		        console.log('[closed] ' + evt.code);
		    };

		    this.ws.onerror = function (code, msg) {
		        console.log('[ERROR] ' + code + ': ' + msg);
		    };
        },
        methods: {
        	sendMsg() {
        		this.ws.send(this.value)
        	}
        }
    }
</script>

<style scoped>
	#app {
		height: 100%;
	}
</style>

