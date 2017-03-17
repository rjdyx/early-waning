/**
 * js库初始化
 */

require('babel-polyfill'); // 解决手机端uc浏览器、qq浏览器和微信浏览器无法使用部分ES6语法
require('animate.css'); // 动画css插件


// 路由插件
import VueRouter from 'vue-router';	
Vue.use(VueRouter);


// 表单验证插件
import VeeValidate from 'vee-validate';	
import messagesZhCN from 'lang/validate/zh_CN.js';
import messagesEn from 'lang/validate/en.js';
Vue.use(VeeValidate, {
    fieldsBagName: 'vfields',
    errorBagName: 'verrors',
    locale: require('projectRoot/env.js').app_lang,
    dictionary: {
        'zh-CN': {
            messages: messagesZhCN
        },
        'en': {
            messages: messagesEn
        }
    }
});


// vue-i18n初始化
import VueI18n from 'vue-i18n'
// 准备替换的语言
import en from 'lang/en/en.js'
import zhCN from 'lang/zh-CN/zh-CN.js'
var locales = {
  en: en,
  'zh-CN': zhCN
}
// 这次插件
Vue.use(VueI18n)
// 设置语言
Vue.config.lang = require('projectRoot/env.js').app_lang
// 设置语言文件
Object.keys(locales).forEach(function (lang) {
  Vue.locale(lang, locales[lang])
})


/**
 * css库
 */
require('sass/app.scss');


axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

// axios
axios.interceptors.request.use(function (config) {
  return config;
}, function (error) {
  return Promise.reject(error)
});

axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    return Promise.reject(error)
});

// 注册全局组件
// Vue.component('passport-clients', require('components/passport/Clients.vue'))




// 注册自定义验证规则
import { Validator } from 'vee-validate'
import validates from '../utils/validate.js'
Object.keys(validates).forEach(k => Validator.extend(k, validates[k]())) 



// 注册自定义指令
import directive from '../directive/directive.js' 
Object.keys(directive).forEach(k => Vue.directive(k, directive[k]())) 



// 注册全局方法
import utils from '../utils/utils' 
Vue.use(utils) 
require('../plugin');


// 实例化Vue的filter
import filters from '../filters/filters.js' 
Object.keys(filters).forEach(k => Vue.filter(k, filters[k])) 