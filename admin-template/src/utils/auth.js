/* eslint-disable prefer-const */
import Cookies from 'js-cookie'

// 管理员秘钥
const TokenKey = 'admin_header_token'

// 管理员唯一值
const adminUnique = 'admin_unique'

// 管理员信息状态
const adminStatus = 'admin_status'

// 后台菜单状态
const adminMenus = 'admin_menus_time'

// 登陆状态
const adminLogin = 'admin_login'

// WebSocket unique
const uniqueWebSocket = 'unique_web_socket'

/**
 * 获取管理员秘钥
 *
 */
export function getToken() {
  return Cookies.get(TokenKey)
}
/**
 * 设置管理员秘钥
 *
 * @param {*} token
 */
export function setToken(token) {
  return Cookies.set(TokenKey, token)
}
/**
 * 删除管理员秘钥
 *
 */
export function removeToken() {
  return Cookies.remove(TokenKey)
}
/**
 * 获取后台菜单状态
 *
 */
export function getMenusToken() {
  let status
  status = Cookies.get(adminMenus)
  if (status === undefined) { return 'false' }
  return status
}
/**
 * 设置后台菜单状态
 *
 * @param {*} status
 */
export function setMenusToken(status) {
  return Cookies.set(adminMenus, status)
}

/**
 * 删除后台菜单状态
 *
 */
export function removetMenusToken() {
  return Cookies.remove(adminMenus)
}
/**
 * 获取登陆状态
 *
 */
export function getLoginStatus() {
  let status
  status = Cookies.get(adminLogin)
  if (status === undefined) { return 'false' }
  return status
}
/**
 * 设置登陆状态
 *
 * @param {*} status
 */
export function setLoginStatus(status) {
  return Cookies.set(adminLogin, status)
}
/**
 * 删除登陆状态
 *
 */
export function removetLoginStatus() {
  return Cookies.remove(adminLogin)
}
/**
 * 获取管理员信息状态
 *
 */
export function getAdminStatus() {
  let status
  status = Cookies.get(adminStatus)
  if (status === undefined) { return 'false' }
  return status
}
/**
 * 设置管理员信息状态
 *
 * @param {*} status
 */
export function setAdminStatus(status) {
  return Cookies.set(adminStatus, status)
}
/**
 * 删除管理员信息状态
 */
export function removetAdminStatus() {
  return Cookies.remove(adminStatus)
}
/**
 * 获取管理员唯一值
 */
export function getAdminUnique() {
  let unique
  unique = Cookies.get(adminUnique)
  if (unique === undefined) { return 0 }
  return unique
}
/**
 * 设置管理员唯一值
 *
 * @param {*} unique
 */
export function setAdminUnique(unique) {
  return Cookies.set(adminUnique, unique)
}
/**
 * 删除管理员唯一值
 */
export function removetAdminUnique() {
  return Cookies.remove(adminUnique)
}
/**
 * 获取socket唯一值
 */
export function getUniqueWebSocket() {
  let unique
  unique = Cookies.get(uniqueWebSocket)
  if (unique === undefined || unique === 'undefined') { return '' }
  return unique
}
/**
 * 设置socket唯一值
 *
 * @param {*} unique
 */
export function setUniqueWebSocket(unique) {
  return Cookies.set(uniqueWebSocket, unique)
}
/**
 * 删除socket唯一值
 */
export function removetUniqueWebSocket() {
  return Cookies.remove(uniqueWebSocket)
}

