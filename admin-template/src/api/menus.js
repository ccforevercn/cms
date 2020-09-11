/* 菜单api */
import request from '@/utils/request'

/**
 * 菜单列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/menus/list',
        method: 'get',
        params: data
    })
}

/**
 * 菜单添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/menus/insert',
        method: 'post',
        data
    })
}

/**
 * 菜单修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/menus/update',
        method: 'put',
        data
    })
}

/**
 * 菜单删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/menus/delete',
        method: 'delete',
        data
    })
}

/**
 * 菜单信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/menus/message',
      method: 'get',
      params: data
    })
}

/**
 * 所有菜单
 * 
 * @param {*} data 
 */
export function GetMenus(data) {
    return request({
      url: '/menus/menus',
      method: 'get',
      params: data
    })

}
/**
 * 左侧菜单
 * 
 * @param {*} data 
 */
export function GetButton(data) {
    return request({
      url: '/menus/button',
      method: 'get',
      params: data
    })
}