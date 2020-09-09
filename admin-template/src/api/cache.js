/* 缓存api */
import request from '@/utils/request'

/**
 * 首页缓存
 * 
 * @param {*} data 
 */
export function index(data) {
    return request({
        url: '/cache/index',
        method: 'post',
        data
    })
}

/**
 * 栏目页缓存
 * 
 * @param {*} data 
 */
export function columns(data) {
    return request({
        url: '/cache/columns',
        method: 'post',
        data
    })
}

/**
 * 信息页缓存
 * 
 * @param {*} data 
 */
export function message(data) {
    return request({
        url: '/cache/message',
        method: 'post',
        data
    })
}

/**
 * 搜索页缓存
 * 
 * @param {*} data 
 */
export function search(data) {
    return request({
        url: '/cache/search',
        method: 'post',
        data
    })
}