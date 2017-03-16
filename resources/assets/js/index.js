import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue';
import store from './vuex/index.js';
import router from './route/routers.js';

require('./config/init')

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {

        if (Laravel.user.id) {
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

