import { asyncRoutes, constantRoutes } from '@/router'
import { getMenusToken, setMenusToken } from '@/utils/auth'
import { GetButton } from '@/api/menus'   // 调用后台的接口
import Layout from '@/layout'

/**
 * 格式化菜单 处理后台传过来的菜单格式
 * @param {*} routes 
 * @param {*} data 
 */
export function formatMenus(routes, data) {
    data.forEach(item => {
        const menu = {}
        if(item.top){// 一级菜单
            menu.path = item.page;
            menu.component = Layout
            menu.children = []
            menu.alwaysShow = true
            menu.redirect = 'noRedirect'
            menu.name = item.name
            menu.meta = { title: item.meta.title, icon: item.meta.icon }
        }else{
            // 二级菜单
            menu.path = item.page
            menu.component =  resolve => require([`@/views${item.page}/index`], resolve)
            menu.children = []
            menu.name = item.name
            menu.meta = { title: item.meta.title, icon: item.meta.icon }
        }
        if (item.children) {
            formatMenus(menu.children, item.children)
        }
        routes.push(menu)
    })
}


const state = {
    routes: [],
}
const mutations = {
    SET_ROUTES: (state, routes) => {
        state.routes = constantRoutes.concat(routes)
    }
}

const actions = {
    generateRoutes({ commit }, adminInfo) {
        return new Promise(resolve => {
            let routesMenus
            let menusStatus
            asyncRoutes.splice(0, asyncRoutes.length)
            menusStatus = getMenusToken()
            routesMenus = sessionStorage.getItem('routes-menus')
            // menusStatus = 'false'
            if(null === routesMenus || menusStatus === 'false'){
                const loadMenuData = []
                /* 获取后台菜单接口 */
                GetButton({id: adminInfo.id}).then(response => {
                    let data = response.data
                    Object.assign(loadMenuData, data)
                    sessionStorage.setItem('routes-menus', JSON.stringify(loadMenuData))
                    formatMenus(asyncRoutes, loadMenuData) /* 格式化菜单 */
                    let accessedRoutes
                    accessedRoutes = asyncRoutes
                    commit('SET_ROUTES', accessedRoutes)
                    setMenusToken('true')
                    resolve(accessedRoutes)
                }).catch(error => {
                    console.log(error)
                })
            }else{
                // 格式化菜单
                let loadMenuData
                let accessedRoutes
                loadMenuData = JSON.parse(routesMenus)
                formatMenus(asyncRoutes, loadMenuData)
                accessedRoutes = asyncRoutes
                commit('SET_ROUTES', accessedRoutes)
                resolve(accessedRoutes)
            }
        })
    }
}
export default {
    namespaced: true,
    state,
    mutations,
    actions
}