/**
 * 查找字符串是否在数组中 needle 查找的字符  haystack 被查找的一维数组 type 查找字符的类型
 * 
 * @param {*} needle 
 * @param {*} haystack 
 * @param {*} type 
 */
export function inArray(needle, haystack, type) {
    let bool = false
    type = type.toLowerCase()
    if(haystack.length){
        haystack.forEach((item) => {
            switch (type) {
                case 'string': /* 字符串类型 */
                    if(String(needle) === String(item)){
                        bool = true
                    }
                    break
                case 'number': /* 数字类型 */
                    if(Number(needle) === Number(item)){
                        bool = true
                    }
                    break
                case 'parsefloat': /* 浮点数类型 */
                    if(parseFloat(needle) === parseFloat(item)){
                        bool = true
                    }
                    break
                case 'parseint': /* 整数类型 */
                    if(parseInt(needle) === parseInt(item)){
                        bool = true
                    }
                    break
                case 'boolean': /* 布尔类型 */
                    if(Boolean(needle) === Boolean(item)){
                        bool = true
                    }
                    break
                default:
                    if(needle === item){
                        bool = true
                    }
            } 
        })
    }
    return bool
}
/**
 * 获取字符串在数组中的key
 * 
 * @param {*} needle 
 * @param {*} haystack 
 * @param {*} type 
 */
export function arrayKey(needle, haystack, type) {
    let key = undefined
    type = type.toLowerCase()
    if(haystack.length){
        haystack.forEach((item, index) => {
            switch (type) {
                case 'string': /* 字符串类型 */
                    if(String(needle) === String(item)){
                        key = index
                    }
                    break
                case 'number': /* 数字类型 */
                    if(Number(needle) === Number(item)){
                        key = index
                    }
                    break
                case 'parsefloat': /* 浮点数类型 */
                    if(parseFloat(needle) === parseFloat(item)){
                        key = index
                    }
                    break
                case 'parseint': /* 整数类型 */
                    if(parseInt(needle) === parseInt(item)){
                        key = index
                    }
                    break
                case 'boolean': /* 布尔类型 */
                    if(Boolean(needle) === Boolean(item)){
                        key = index
                    }
                    break
                default:
                    if(needle === item){
                        key = index
                    }
            }
        })
    }
    return key
}