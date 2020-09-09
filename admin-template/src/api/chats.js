/* 留言api */
import request from '@/utils/request'


/**
 * 留言列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/chats/list',
        method: 'get',
        params: data
    })
}

/**
 * 留言用户列表
 * 
 * @param {*} data 
 */
export function GetUsers(data) {
    return request({
        url: '/chats/users',
        method: 'get',
        params: data
    })
}

/**
 * 留言客服和用户对话列表
 * 
 * @param {*} data 
 */
export function GetChats(data) {
    return request({
        url: '/chats/chats',
        method: 'get',
        params: data
    })
}

/**
 * 修改留言状态
 * 
 * @param {*} data 
 */
export function chatsSee(data) {
    return request({
        url: '/chats/see',
        method: 'post',
        data
    })
}

/**
 * 留言用户统计
 */
export function statistics() {
    return request({
        url: '/chats/statistics',
        method: 'get'
    })
}