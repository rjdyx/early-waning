import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue';
import store from './vuex/app.js';
import router from './route/app.js';

require('./config/app')

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {

        if (Laravel.user.id) {

            if(!store.getters.ws) {
              store.commit('setWS', new WebSocket('ws://www.earlywarning.com:3000/ws/chat'))
              store.getters.ws.onmessage = function(event) {
                let data = JSON.parse(event.data)
                console.log('onmessage')
                store.commit('pushData', data)
                $('.vux-swiper').css('height', store.getters.data.length * 66 + 'px')
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

