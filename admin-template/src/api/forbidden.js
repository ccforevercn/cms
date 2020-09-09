/* 违禁词api */
import request from '@/utils/request'

/**
 * 违禁词查看
 * 
 */
export function GETContent() {
    return request({
        url: '/forbidden/word/forbidden',
        method: 'get'
    })
}

/**
 * 违禁词修改
 * 
 * @param {*} data 
 */
export function SetUpdate(data) {
    return request({
        url: '/forbidden/word/update',
        method: 'post',
        data
    })
}

/**
 * 违禁词验证
 */
export function checkContent() {
    return request({
        url: '/forbidden/word/check',
        method: 'get'
    })
}
