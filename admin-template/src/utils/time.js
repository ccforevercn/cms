/**
 * 时间格式化
 */
/**
 * 格式化时间
 * second 秒
 *
 * @param {*} second
 */
export function secondToTime(second) {
  var date = new Date(second * 1000)
  var YY = date.getFullYear() + '-'
  var MM = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-'
  var DD = (date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate())
  var hh = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':'
  var mm = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + ':'
  var ss = (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds())
  return YY + MM + DD + ' ' + hh + mm + ss
}

/**
  * 毫秒转秒
  *
  * @param {*} millisecond
  */
export function millisecondToSecond(millisecond) {
  return parseInt(new Date(millisecond).getTime() / 1000)
}

/**
 * 秒转毫秒
 *
 * @param {*} second
 */
export function secondToMillisecond(second) {
  return parseInt(second * 1000)
}
