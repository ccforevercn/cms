/**
 * 获取窗口滚动条高度
 * 
 * @param {*} entity 
 */
export function getScrollTop(entity) {
    return entity.scrollTop  
} 
/**
 * 获取窗口可视范围的高度
 * 
 * @param {*} entity 
 */
export function getClientHeight(entity){    
    return entity.clientHeight
} 
/**
 * 获取文档内容实际高度
 * 
 * @param {*} entity 
 */
export function getScrollHeight(entity){    
    return entity.scrollHeight
}

/**
 * 获取滚动条距离底部的距离
 * 
 * @param {*} entity 
 */
export function getScrollBotom(entity) {
    let scrollHeight
    let scrollTop
    let clientHeight
    scrollHeight = getScrollHeight(entity)
    clientHeight = getClientHeight(entity)
    scrollTop = getScrollTop(entity)
    return scrollHeight - clientHeight - scrollTop
}

/**
 * 滚动到底部
 * 
 * @param {*} entity 
 */
export function scrollBotom(entity) {
    let scrollHeight
    scrollHeight = getScrollHeight(entity)
    entity.scrollTo(scrollHeight, scrollHeight)
}