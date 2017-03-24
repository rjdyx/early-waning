
const state = {
  progress: []
}

// getters
const getters = {}

// actions
const actions = {}

// mutations
const mutations = {
  /**
   * 设置表单对象信息
   */
  setProgress(state, progress) {
    state.progress = progress
  },

  pushProgress(state, progress) {
    state.progress.unshift(progress)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
