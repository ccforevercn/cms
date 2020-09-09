/* 配置信息api */
import request from '@/utils/request'


/**
 * 配置信息列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/config/message/list',
        method: 'get',
        params: data
    })
}

/**
 * 配置信息添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/config/message/insert',
        method: 'post',
        data
    })
}

/**
 * 配置信息修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/config/message/update',
        method: 'post',
        data
    })
}

/**
 * 配置信息删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/config/message/delete',
        method: 'post',
        data
    })
}

/**
 * 配置信息信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/config/message/message',
      method: 'get',
      params: data
    })
}

/**
 * 配置信息信息 select获取
 * 
 * @param {*} data
 */
export function GetConfig(data) {
    return request({
      url: '/config/message/config',
      method: 'get',
      params: data
    })
}
