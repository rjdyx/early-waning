// Vuex
import Vuex from 'vuex';
import Vue from 'vue';

const store = new Vuex.Store({
    state: {
        userInfo: {userId: ''}
    },
    mutations: {

        /**
         * 设置用户登录信息
         */
        setUserInfo(state, userInfo) {
            state.userInfo.userId = userInfo;
        }
    },
    
    actions: {
        setUserInfo(context, user) {
            context.commit('setUserInfo', user);
        }
    }
    
});

export default store;