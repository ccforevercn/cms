/* 配置分类api */
import request from '@/utils/request'


/**
 * 配置分类列表
 * 
 * @param {*} data
 */
export function GetList(data) {
    return request({
        url: '/config/category/list',
        method: 'get',
        params: data
    })
}

/**
 * 配置分类添加
 * 
 * @param {*} data
 */
export function SetInsert(data) {
    return request({
        url: '/config/category/insert',
        method: 'post',
        data
    })
}

/**
 * 配置分类修改
 * 
 * @param {*} data
 */
export function SetUpdate(data) {
    return request({
        url: '/config/category/update',
        method: 'put',
        data
    })
}

/**
 * 配置分类删除
 * 
 * @param {*} data
 */
export function SetDelete(data) {
    return request({
        url: '/config/category/delete',
        method: 'delete',
        data
    })
}

/**
 * 配置分类信息
 * 
 * @param {*} data
 */
export function GetMessage(data) {
    return request({
      url: '/config/category/message',
      method: 'get',
      params: data
    })
}

/**
 * 配置分类列表(all)
 * 
 */
export function GetConfigCategory() {
    return request({
      url: '/config/category/category',
      method: 'get'
    })
}