import { getToken, getUniqueWebSocket, setUniqueWebSocket, removetUniqueWebSocket } from '@/utils/auth'
import store from '@/store'

var ws // WebSocket
var vm // 传入的this
var timer // 心跳
var wsStatus // WebSocket链接状态
wsStatus = false
/**
 * 连接
 *
 * @param {*} that
 */
export function connect(that) {
  vm = that
  that.$on('connect', (data) => {
    // 连接socket
    const unique = getUniqueWebSocket()
    if (unique.length > 0) {
      formatDataSend('chats_admin', { newunique: data.data.unique })
    } else {
      setUniqueWebSocket(data.data.unique)
      formatDataSend('chats_admin', {})
    }
  })
  that.$on('admin_check', (data) => {
    // 客服验证
    that.$message({ type: 'info', message: data.message || 'info' })
    // 客服验证成功后添加心跳
    heartbeat()
  })
  that.$on('heartbeat', (data) => {
    // 心跳
  })
  that.$on('admin_message', (data) => {
    that.$message({ type: 'info', message: data.message || 'info' })
    that.socketMessages(data.data.user)
  })
  that.$on('admin_notice_message', (data) => {
    // 用户新消息通知
    store.dispatch('chat/speak', data.data.speak)
    that.$message({ type: 'info', message: data.message || 'info' })
  })
  that.$on('admin_notice_success', (data) => {
    // 信息发送成功提示
    that.$message({ type: 'success', message: data.message || 'success' })
    that.socketMessages(data.data.user)
  })
  that.$on('admin_notice_error', (data) => {
    // 管理员信息发送失败提示
    that.$message({ type: 'error', message: data.message || 'error' })
  })
  that.$on('admin_shut_user', (data) => {
    // 重置未计入用户
    store.dispatch('chat/reset', data.data)
  })

  //
  ws = new WebSocket(process.env.VUE_APP_BASE_WS)
  ws.onopen = function(event) {
    /* 连接成功 */
    wsStatus = true
  }
  ws.onmessage = function(event) {
    // 接收服务器发送的信息
    const { type, message, data = {}} = JSON.parse(event.data)
    that.$emit(type, { message, data })
  }
  ws.onclose = function() {
    // 关闭
    clearInterval(timer)
    removetUniqueWebSocket()
  }
  ws.onerror = function(event) {
    /* 报错 */
  }
}
/**
 * 格式化参数并发送
 *
 * @param {*} type
 * @param {*} data
 */
export function formatDataSend(type, data) {
  var send = {
    'type': type,
    'token': getToken(),
    'unique': getUniqueWebSocket()
  }
  ws.send(JSON.stringify(Object.assign(send, data)))
}
/**
 * 心跳
 */
export function heartbeat() {
  timer = setInterval(function() {
    formatDataSend('heartbeat')
  }, 10000)
}
/**
 * 验证当前用户是否在线
 *
 * @param {*} user
 * @param {*} callback
 */
export function check(user, callback) {
  if (wsStatus === true) {
    vm.$on('admin_user_check', (data) => {
      callback(data)
    })
    formatDataSend('user_check', { check: user })
  } else {
    callback({ data: { status: false }})
  }
}

