// Vuex
import Vuex from 'vuex';
import Vue from 'vue';

const store = new Vuex.Store({
    state: {
        showBack: false,
        menu: null,
        ws: null,
        data: [{name: '', location: '无数据', status: 0}]
    },

    getters: {
        ws: (state) => {
            return state.ws
        },

        data: (state) => {
            return state.data
        }
    },

    mutations: {

        setShowBack(state, showBack) {
            state.showBack = showBack
        },

        setMenu(state, menu) {
            state.menu = menu
        },

        setWS(state, ws) {
            state.ws = ws
        },

        setData(state, data) {
            state.data = data
        },

        pushData(state, data) {
            state.data.unshift(data)
        }
    }
    
    // actions: {
    //     setUserInfo(context, user) {
    //         context.commit('setUserInfo', user);
    //     }
    // }
    
});

export default store;