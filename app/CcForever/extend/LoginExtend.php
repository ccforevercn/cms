<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/14
 */

namespace App\CcForever\extend;
use App\Repositories\AdminsRepository;

/**
 * 登陆
 *
 * Class LoginExtend
 * @package App\CcForever\extend
 */
class LoginExtend
{
    /**
     * 管理员登陆验证
     *
     * @param int $id
     * @param string $api
     * @return bool
     */
    public static function admin(int $id, string $api): bool
    {
        $adminsRepository = new AdminsRepository(); // 实例化AdminsRepository类
        $noMenusRoute = $adminsRepository::noMenusRoute(); // 获取不需要验证的路由
        if(!in_array($api, $noMenusRoute)){
            $superAdministratorIds = $adminsRepository::superAdministratorIds();// 获取超级管理员编号
            if(!in_array($id, $superAdministratorIds)){// 不是超级管理员
                $bool = $adminsRepository::returnAdminRuleMenusRoutes($id, $api); // 判断当前管理员是否有权限访问
                return $bool;
            }
        }
        return true;
    }
}