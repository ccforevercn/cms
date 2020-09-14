/* 视图api */
import request from '@/utils/request'

/**
 * 视图列表
 *
 * @param {*} data
 */
export function GetList(data) {
  return request({
    url: '/views/list',
    method: 'get',
    params: data
  })
}

/**
* 视图添加
*
* @param {*} data
*/
export function SetInsert(data) {
  return request({
    url: '/views/insert',
    method: 'post',
    data
  })
}

/**
* 视图修改
*
* @param {*} data
*/
export function SetUpdate(data) {
  return request({
    url: '/views/update',
    method: 'put',
    data
  })
}

/**
* 视图删除
*
* @param {*} data
*/
export function SetDelete(data) {
  return request({
    url: '/views/delete',
    method: 'delete',
    data
  })
}

/**
* 视图信息
*
* @param {*} data
*/
export function GetMessage(data) {
  return request({
    url: '/views/message',
    method: 'get',
    params: data
  })
}
