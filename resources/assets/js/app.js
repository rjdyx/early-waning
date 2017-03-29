import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue'
import store from './vuex/app.js'
import router from './route/app.js'
import env from 'projectRoot/env.js'

require('./config/app')

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {

        if (Laravel.user.id) {

            if(!store.getters.ws) {
              store.commit('setWS', new WebSocket('ws://'+ env.app_url +':3000/ws/chat'))
              store.getters.ws.onmessage = function(event) {
                let s = JSON.parse(event.data)
                console.log('onmessage')
                if(s.type == 'event') {
                  if(s.msg.status == 2 || s.msg.status == 3) {
                    store.commit('pushEarlyWaningData', s.msg)
                  }else {
                    store.commit('pushEmergencyData', s.msg)
                  }
                  if(store.getters.earlyWaningData.length > store.getters.emergencyData.length) {
                    $('.vux-swiper').css('height', store.getters.earlyWaningData.length * 66 + 'px')
                  }else {
                    $('.vux-swiper').css('height', store.getters.emergencyData.length * 66 + 'px')
                  }
                }
                if(s.type == 'progress'){
                  store.commit('pushProgress', s.msg)
                }
                if(s.type == 'closeEvent'){
                  if(store.getters.formMsg) {
                    if(store.getters.formMsg.id == s.msg.id) {
                      Vue.$vux.alert.show({
                        title: '通知',
                        content: '事件：' + s.msg.name + ' 已完成'
                      })
                      store.commit('setFormMsg', s.msg)
                    }
                  }else {
                    store.commit('changeEventStatus', s.msg)
                  }
                }
                
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

