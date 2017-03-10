/**
 * 路由
 */
import Router from 'vue-router'

//=============================顶层组件====================================
//---------------------------最顶层组件----------------------------------
const index = resolve => {
    require.ensure(['../views/index.vue'], () =>{
        resolve(require('../views/index.vue'));
    }, 'index');
};

const message = resolve => {
    require.ensure(['../views/message.vue'], () =>{
        resolve(require('../views/message.vue'));
    }, 'message');
};

const reaction = resolve => {
    require.ensure(['../views/reaction.vue'], () =>{
        resolve(require('../views/reaction.vue'));
    }, 'reaction');
};

const newForm = resolve => {
    require.ensure(['../views/new-form.vue'], () =>{
        resolve(require('../views/new-form.vue'));
    }, 'newForm');
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
        component: index
    },
    {
        path: '/index',
        component: index,
        children: [
            {
                path: 'message/:model/:index',
                component: message,
                meta: { requiresAuth: true }
            },
            {
                path: 'reaction/:model/:index',
                component: reaction,
                meta: { requiresAuth: true }
            },
            {
                path: 'new-form/:model/:type',
                component: newForm,
                meta: { requiresAuth: true }
            },
            {
                path: 'event-handle/:model/:type',
                component: newForm,
                meta: { requiresAuth: true }
            },
            {
                path: 'event-progress/:model/:type',
                component: newForm,
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