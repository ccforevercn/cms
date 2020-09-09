import { inArray, arrayKey } from '@/utils/array'

const getDefaultState = () => {
    return {
        chat: false, // 留言表单状态 false 隐藏 ture 展示
        user: '', // 当前对话的用户
        speak: [], // 未接入的用户
    }
  }
  
  const state = getDefaultState()
  
  const mutations = {
    SET_USER:(state, user) =>{
        state.user = ''
        state.user = user
    },
    SET_CAHT: (state, status) => {
        state.chat = status
    },
    SET_SPEAK: (state, speak) => {
        if(!inArray(speak, state.speak, 'string')){
            state.speak = state.speak.concat(speak)
        }
    },
    RESET_SPEAK: (state, speak) => {
        state.speak = speak
    },
    SET_SHUT: (state, speak) =>{
        let index 
        index = arrayKey(speak, state.speak, 'string')
        if(index !== undefined){
            state.speak.splice(index, 1)
        }
    }
  }
  const actions = {
    chat({ commit, state }) {
        return new Promise(resolve => {
            let chat
            chat = !state.chat
            commit('SET_CAHT', chat)
            resolve()
        })
    },
    reset({ commit }, speak) {
        return new Promise(resolve => {
            commit('RESET_SPEAK', speak)
            resolve()
        })
    },
    speak({ commit }, speak) {
        return new Promise(resolve => {
            commit('SET_SPEAK', speak)
            resolve()
        })
    },
    shut({ commit }, speak) {
        return new Promise(resolve => {
            commit('SET_SHUT', speak)
            resolve()
        })
    },
    user({commit}, user) {
        return new Promise(resolve => {
            commit('SET_USER', user)
            commit('SET_CAHT', true)
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