import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue';
import store from './vuex/index.js';
import router from './route/routers.js';

require('./config/init')

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {

        if (Laravel.user.id) {

            if(!store.getters.ws) {
              store.commit('setWS', new WebSocket('ws://www.earlywarning.com:3000/ws/chat'))
              store.getters.ws.onmessage = function(event) {
                var data = event.data
                console.log('onmessage')
                console.log(data)
              };

              store.getters.ws.onclose = function (evt) {
                console.log('[closed] ' + evt.code)
              }

              store.getters.ws.onerror = function (code, msg) {
                console.log('[ERROR] ' + code + ': ' + msg)
              }
            }

            next();
        } else {
            next({
                path: '/login'
            });
        }
    } else {
        next();
    }
});

router.afterEach(route => {
	
})

const app = new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');

