// Vuex
import Vuex from 'vuex';
import Vue from 'vue';

const store = new Vuex.Store({
    state: {
        showBack: false,
        menu: null
    },
    mutations: {

        setShowBack(state, showBack) {
            state.showBack = showBack
        },

        setMenu(state, menu) {
            state.menu = menu
        }
    }
    
    // actions: {
    //     setUserInfo(context, user) {
    //         context.commit('setUserInfo', user);
    //     }
    // }
    
});

export default store;