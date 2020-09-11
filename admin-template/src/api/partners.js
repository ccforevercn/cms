/* 合作伙伴api */
import request from '@/utils/request'


/**
 * 合作伙伴列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/partners/list',
        method: 'get',
        params: data
    })
}

/**
 * 合作伙伴添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/partners/insert',
        method: 'post',
        data
    })
}

/**
 * 合作伙伴修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/partners/update',
        method: 'put',
        data
    })
}

/**
 * 合作伙伴删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/partners/delete',
        method: 'delete',
        data
    })
}

/**
 * 合作伙伴信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/partners/message',
      method: 'get',
      params: data
    })
}