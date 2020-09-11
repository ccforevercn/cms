/* robotsapi */
import request from '@/utils/request'

/**
 * robots查看
 * 
 */
export function GETContent() {
    return request({
        url: '/robots/content',
        method: 'get'
    })
}

/**
 * robots修改
 * 
 * @param {*} data 
 */
export function SetUpdate(data) {
    return request({
        url: '/robots/update',
        method: 'put',
        data
    })
}
