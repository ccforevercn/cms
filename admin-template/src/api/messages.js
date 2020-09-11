/* 信息api */
import request from '@/utils/request'

/**
 * 信息列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/messages/list',
        method: 'get',
        params: data
    })
}

/**
 * 信息添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/messages/insert',
        method: 'post',
        data
    })
}

/**
 * 信息修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/messages/update',
        method: 'put',
        data
    })
}

/**
 * 信息删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/messages/delete',
        method: 'delete',
        data
    })
}

/**
 * 信息信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/messages/message',
      method: 'get',
      params: data
    })
}

/**
 * 信息内容添加删除查询
 * 
 * @param {*} data 
 */
export function content(data) {
    return request({
      url: '/messages/content',
      method: 'post',
      data
    })
}

/**
 * 信息点击量设置
 * 
 * @param {*} data 
 */
export function setClick(data) {
    return request({
      url: '/messages/click',
      method: 'put',
      data
    })
}

/**
 * 信息状态设置
 * 
 * @param {*} data 
 */
export function setState(data) {
    return request({
      url: '/messages/state',
      method: 'put',
      data
    })
}

/**
 * 视图列表
 */
export function GetViews() {
    return request({
      url: '/messages/views',
      method: 'get'
    })
}

/**
 * 信息标签
 * 
 * @param {*} data 
 */
export function GetTags(data) {
    return request({
      url: '/messages/tags',
      method: 'get',
      params: data
    })
}

/**
 * 信息统计
 */
export function statistics() {
    return request({
      url: '/messages/statistics',
      method: 'get'
    })
}