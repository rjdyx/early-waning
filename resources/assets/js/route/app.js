/**
 * 路由
 */
import Router from 'vue-router'

//=============================顶层组件====================================
//---------------------------最顶层组件----------------------------------
const index = resolve => {
    require.ensure(['../appPage/index/index.vue'], () =>{
        resolve(require('../appPage/index/index.vue'));
    }, 'app-index');
};

//---------------------------登录组件----------------------------------
const login = resolve => {
    require.ensure(['../views/app-login.vue'], () =>{
        resolve(require('../views/app-login.vue'));
    }, 'app-login');
};


//---------------------------404----------------------------------
const notFound = resolve => {
    require.ensure(['../views/404.vue'], () =>{
        resolve(require('../views/404.vue'));
    }, 'fourOFour');
};


const routes = [
    
    {
        path: '/',
        name: 'index',
        component: index,
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'login',
        component: login
    },
    {
        path: '/404',
        name: 'notFound',
        component: notFound
    }
    
];

export default new Router({
    routes
});