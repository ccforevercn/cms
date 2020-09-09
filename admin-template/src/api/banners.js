/* 轮播图api */
import request from '@/utils/request'


/**
 * 轮播图列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/banners/list',
        method: 'get',
        params: data
    })
}

/**
 * 轮播图添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/banners/insert',
        method: 'post',
        data
    })
}

/**
 * 轮播图修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/banners/update',
        method: 'post',
        data
    })
}

/**
 * 轮播图删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/banners/delete',
        method: 'post',
        data
    })
}

/**
 * 轮播图信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/banners/message',
      method: 'get',
      params: data
    })
}