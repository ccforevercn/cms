/* 栏目api */
import request from '@/utils/request'

/**
 * 栏目列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/columns/list',
        method: 'get',
        params: data
    })
}

/**
 * 栏目添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/columns/insert',
        method: 'post',
        data
    })
}

/**
 * 栏目修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/columns/update',
        method: 'post',
        data
    })
}

/**
 * 栏目删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/columns/delete',
        method: 'post',
        data
    })
}

/**
 * 栏目信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/columns/message',
      method: 'get',
      params: data
    })
}

/**
 * 栏目内容添加删除查询
 * 
 * @param {*} data 
 */
export function content(data) {
    return request({
      url: '/columns/content',
      method: 'post',
      data
    })
}

/**
 * 栏目列表(全部)
 */
export function GetColumns() {
    return request({
      url: '/columns/columns',
      method: 'get'
    })
}

/**
 * 视图列表
 */
export function GetViews() {
    return request({
      url: '/columns/views',
      method: 'get'
    })
}