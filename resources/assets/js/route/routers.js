/**
 * 路由
 */
import Router from 'vue-router'

//=============================顶层组件====================================
//---------------------------最顶层组件----------------------------------
const index = resolve => {
    require.ensure(['../page/index/index.vue'], () =>{
        resolve(require('../page/index/index.vue'));
    }, 'index');
};

const middle = resolve => {
    require.ensure(['../page/middle/middle.vue'], () =>{
        resolve(require('../page/middle/middle.vue'));
    }, 'middle');
};

const newForm = resolve => {
    require.ensure(['../views/new-form.vue'], () =>{
        resolve(require('../views/new-form.vue'));
    }, 'newForm');
};

const model = resolve => {
    require.ensure(['../page/model/model.vue'], () =>{
        resolve(require('../page/model/model.vue'));
    }, 'model');
};

const analyse = resolve => {
    require.ensure(['../page/analyse/analyse.vue'], () =>{
        resolve(require('../page/analyse/analyse.vue'));
    }, 'analyse');
};


//---------------------------登录组件----------------------------------
const login = resolve => {
    require.ensure(['../views/login.vue'], () =>{
        resolve(require('../views/login.vue'));
    }, 'login');
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
        path: '/index',
        component: index,
        meta: { requiresAuth: true },
        children: [
            {
                path: 'message/:model/:index',
                alias: ['reaction/:model/:index', 'rbac/:model/:index'],
                component: middle,
                meta: { requiresAuth: true }
            },
            {
                path: 'new-form/:model/:type',
                alias: ['event-handle/:model/:type', 'event-progress/:model/:type'],
                component: newForm,
                meta: { requiresAuth: true }
            },
            {
                path: 'model',
                component: model,
                meta: { requiresAuth: true }
            },
            {
                path: 'analyse',
                component: analyse,
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