/* 管理员api */
import request from '@/utils/request'

/**
 * 管理员列表
 *
 * @param {*} data
 */
export function GetList(data) {
  return request({
    url: '/admins/list',
    method: 'get',
    params: data
  })
}

/**
 * 管理员添加
 *
 * @param {*} data
 */
export function SetInsert(data) {
  return request({
    url: '/admins/insert',
    method: 'post',
    data
  })
}

/**
 * 管理员修改
 *
 * @param {*} data
 */
export function SetUpdate(data) {
  return request({
    url: '/admins/update',
    method: 'put',
    data
  })
}

/**
 * 管理员删除
 *
 * @param {*} data
 */
export function SetDelete(data) {
  return request({
    url: '/admins/delete',
    method: 'delete',
    data
  })
}

/**
 * 管理员信息
 *
 * @param {*} data
 */
export function GetMessage(data) {
  return request({
    url: '/admins/message',
    method: 'get',
    params: data
  })
}

/**
 * 退出
 *
 * @param {*} data
 */
export function logout(data) {
  return request({
    url: '/logout',
    method: 'delete',
    data
  })
}
