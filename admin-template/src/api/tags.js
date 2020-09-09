/* 标签api */
import request from '@/utils/request'


/**
 * 标签列表
 * 
 * @param {*} data
 */
export function GetList(data) {
  return request({
      url: '/tags/list',
      method: 'get',
      params: data
  })
}

/**
* 标签添加
* 
* @param {*} data
*/
export function SetInsert(data) {
  return request({
      url: '/tags/insert',
      method: 'post',
      data
  })
}

/**
* 标签修改
* 
* @param {*} data
*/
export function SetUpdate(data) {
  return request({
      url: '/tags/update',
      method: 'post',
      data
  })
}

/**
* 标签删除
* 
* @param {*} data
*/
export function SetDelete(data) {
  return request({
      url: '/tags/delete',
      method: 'post',
      data
  })
}

/**
* 标签信息
* 
* @param {*} data
*/
export function GetMessage(data) {
  return request({
    url: '/tags/message',
    method: 'get',
    params: data
  })
}

/**
 * 标签列表(全部)
 */
export function GetTagsTotal() {
    return request({
      url: '/tags/tags',
      method: 'get'
    })
}
