/* 规则api */
import request from '@/utils/request'

/**
 * 规则列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/rules/list',
        method: 'get',
        params: data
    })
}

/**
 * 规则添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/rules/insert',
        method: 'post',
        data
    })
}

/**
 * 规则修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/rules/update',
        method: 'put',
        data
    })
}

/**
 * 规则删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/rules/delete',
        method: 'delete',
        data
    })
}

/**
 * 规则信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/rules/message',
      method: 'get',
      params: data
    })
}

/**
 * 规则菜单
 * 
 * @param {*} data 
 */
export function GetMenus(data) {
    return request({
      url: '/rules/menus',
      method: 'get',
      params: data
    })
}
/**
 * 规则列表信息
 */
export function GetRules() {
    return request({
      url: '/rules/rules',
      method: 'get',
    })

}