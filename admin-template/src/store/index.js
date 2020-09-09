import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'
import app from './modules/app'
import settings from './modules/settings'
import user from './modules/user'
import chat from './modules/chat'
import permission from './modules/permission'  // 导入permission文件 添加

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app,
    settings,
    user,
    chat,
    permission  // 添加
  },
  getters
})

export default store
