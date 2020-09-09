/* 网站地图api */
import request from '@/utils/request'


/**
 * 网站链接
 * 
 * @param {*} data
 */
export function GetIndex() {
  return request({
      url: '/sitemap/index',
      method: 'get'
  })
}

/**
 * 网站地图html
 */
export function SetHtml() {
    return request({
        url: '/sitemap/html',
        method: 'post'
    })
}

/**
 * 网站地图xml
 */
export function SetXml() {
    return request({
        url: '/sitemap/xml',
        method: 'post'
    })
}

/**
 * 网站地图txt
 */
export function SetTxt() {
    return request({
        url: '/sitemap/txt',
        method: 'post'
    })
}