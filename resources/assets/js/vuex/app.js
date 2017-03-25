// Vuex
import Vuex from 'vuex';
import Vue from 'vue';

const store = new Vuex.Store({
    state: {
        formMsg: null,
        showBack: false,
        menu: null,
        ws: null,
        data: [{name: '', location: '无数据', status: 0}],
        progress: []
    },

    getters: {

        formMsg: (state) => {
            return state.formMsg
        },
        
        ws: (state) => {
            return state.ws
        },

        data: (state) => {
            return state.data
        },

        progress: (state) => {
            return state.progress
        }
    },

    mutations: {

        /**
          * 设置表单对象信息
          */
        setFormMsg(state, formMsg) {
            state.formMsg = formMsg;
        },

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
        },

        setProgress(state, progress) {
            state.progress = progress
        },

        pushProgress(state, progress) {
            state.progress.unshift(progress)
        },

        changeEventStatus(state, event) {
            for(let item of state.data) {
                console.log(item);
                console.log(event);
                if(item.id == event.id) {
                    item.status = event.status
                }
            }
        }
    }
    
    // actions: {
    //     setUserInfo(context, user) {
    //         context.commit('setUserInfo', user);
    //     }
    // }
    
});

export default store;