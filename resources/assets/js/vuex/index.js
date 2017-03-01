// Vuex
import Vuex from 'vuex';

const store = new Vuex.Store({
    state: {
        formMsg: null
    },
    mutations: {

    	/**
    	 * 设置表单对象信息
    	 */
        setFormMsg(state, formMsg) {
        	state.formMsg = formMsg;
        }
    }
    
});

export default store;