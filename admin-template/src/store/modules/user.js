import { logout, GetMessage } from '@/api/admins'
import { login } from '@/api/public'
import { getToken, setToken, removeToken, setMenusToken, removetMenusToken, setLoginStatus, removetLoginStatus, getAdminStatus, setAdminStatus, removetAdminStatus, getAdminUnique, setAdminUnique, removetAdminUnique } from '@/utils/auth'
import { resetRouter } from '@/router'

const getDefaultState = () => {
  return {
    token: getToken(),
    admin: [],
    unique: 1
  }
}

const state = getDefaultState()

const mutations = {
  RESET_STATE: (state) => {
    Object.assign(state, getDefaultState())
  },
  SET_TOKEN: (state, token) => {
    state.token = token
  },
  SET_UNIQUE: (state, unique) =>{
    state.unique = unique
  },
  SET_ADMIN: (state, admin) => {
    state.admin = admin
  }
}

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { username, password, captcha, key } = userInfo
    return new Promise((resolve, reject) => {
      login({ username: username.trim(), password: password, captcha: captcha, key: key }).then(response => {
        const { data } = response
        commit('SET_TOKEN', data.token)
        commit('SET_UNIQUE', data.unique)
        setToken(data.token)
        setAdminUnique(data.unique)
        setMenusToken('false')
        setLoginStatus('false')
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      commit('SET_UNIQUE', getAdminUnique())
      if(state.unique < 1){
        reject("参数错误")
      }else{
        if(getAdminStatus() === 'false' || state.admin.length < 1){
          GetMessage({id: state.unique}).then(response => {
            const { data } = response
            if (!data) { reject('验证失败，请重新登录') }
            commit('SET_ADMIN', data)
            setAdminStatus('true')
            resolve(data)
          }).catch(error => {
            reject(error)
          })
        }else{
          resolve(state.admin)
        }
      }      
    })
  },

  // user logout
  logout({ commit, state }) {
    return new Promise((resolve, reject) => {
      logout({id: state.unique}).then(() => {
        removeToken() // must remove  token  first
        removetMenusToken()
        removetLoginStatus()
        removetAdminStatus()
        removetAdminUnique()
        resetRouter()
        commit('RESET_STATE')
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      removeToken() // must remove  token  first
      removetMenusToken()
      removetLoginStatus()
      removetAdminStatus()
      removetAdminUnique()
      resetRouter()
      commit('RESET_STATE')
      resolve()
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

