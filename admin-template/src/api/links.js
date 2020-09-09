/* 友情链接api */
import request from '@/utils/request'


/**
 * 友情链接列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/links/list',
        method: 'get',
        params: data
    })
}

/**
 * 友情链接添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/links/insert',
        method: 'post',
        data
    })
}

/**
 * 友情链接修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/links/update',
        method: 'post',
        data
    })
}

/**
 * 友情链接删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/links/delete',
        method: 'post',
        data
    })
}

/**
 * 友情链接信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/links/message',
      method: 'get',
      params: data
    })
}