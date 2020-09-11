/* 分站api */
import request from '@/utils/request'


/**
 * 分站列表
 * 
 * @param {*} data
 */
export function GetList(data) {
  return request({
      url: '/substations/list',
      method: 'get',
      params: data
  })
}

/**
* 分站添加
* 
* @param {*} data
*/
export function SetInsert(data) {
  return request({
      url: '/substations/insert',
      method: 'post',
      data
  })
}

/**
* 分站修改
* 
* @param {*} data
*/
export function SetUpdate(data) {
  return request({
      url: '/substations/update',
      method: 'put',
      data
  })
}

/**
* 分站删除
* 
* @param {*} data
*/
export function SetDelete(data) {
  return request({
      url: '/substations/delete',
      method: 'delete',
      data
  })
}

/**
* 分站信息
* 
* @param {*} data
*/
export function GetMessage(data) {
  return request({
    url: '/substations/message',
    method: 'get',
    params: data
  })
}

/**
* 分站缓存
* 
* @param {*} data
*/
export function cache(data) {
    return request({
      url: '/substations/cache',
      method: 'post',
      data
    })
  }
