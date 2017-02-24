// Vuex
import Vuex from 'vuex';

const store = new Vuex.Store({
    state: {
        userInfo: {userId: ''},
        title: ''
    },
    mutations: {

    	/**
    	 * 设置标题
    	 */
        setTitle(state, title) {
        	state.title = title;
        },

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