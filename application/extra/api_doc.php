<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | Company: YG | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/2/28 18:13
// +----------------------------------------------------------------------
// | TITLE:文档列表
// +----------------------------------------------------------------------

return [
    '1' => ['name' => '测试文档', 'id' => '1', 'parent' => '0', 'class' => '', 'readme' => ''],//下面有子列表为一级目录
    '2' => ['name' => '说明', 'id' => '2', 'parent' => '1', 'class' => '', 'readme' => '/doc/md/auth.md'],//没有接口的文档，加载markdown文档
    '3' => ['name' => '用户接口', 'id' => '3', 'parent' => '1', 'readme' => '', 'class' => \app\demo\controller\User::class],//User接口文档
    '4' => ['name' => '角色接口', 'id' => '4', 'parent' => '1', 'readme' => '', 'class' => \app\demo\controller\Role::class],//Role接口文档
];
