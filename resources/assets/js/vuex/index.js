import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import websocket from './modules/websocket'
import form from './modules/form'
import basicModel from './modules/basic-model'


export default new Vuex.Store({
  actions,
  getters,
  modules: {
  	websocket,
    form,
    basicModel
  }
})
