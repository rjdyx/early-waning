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

const list = resolve => {
    require.ensure(['../appPage/index/components/list.vue'], () =>{
        resolve(require('../appPage/index/components/list.vue'));
    }, 'list');
};

const detail = resolve => {
    require.ensure(['../appPage/index/components/detail.vue'], () =>{
        resolve(require('../appPage/index/components/detail.vue'));
    }, 'detail');
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
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                component: list,
                meta: { requiresAuth: true }
            },
            {
                path: 'detail/:id',
                component: detail,
                meta: { requiresAuth: true }
            }
        ]
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