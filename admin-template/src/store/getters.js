const getters = {
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  token: state => state.user.token,
  admin: state => state.user.admin,
  chat: state => state.chat.chat,
  speak: state => state.chat.speak,
  user: state => state.chat.user,
  routers: state => state.permission.routes  // 异步加载的路由 添加
}
export default getters
