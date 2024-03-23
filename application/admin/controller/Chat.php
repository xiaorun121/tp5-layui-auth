<?php

namespace app\admin\controller;

use app\admin\logic\GetViewMenuPermission;
use app\admin\model\Logs;
use think\Db;

class Chat extends Common
{
    function chatList()
    {
        $chat = Db::name('chats')
            ->field(true)
            ->order('id asc')
            ->paginate(10, false, [
                'type'     => 'bootstrap',
                'var_page' => 'page',
            ]);
        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu', $viewMenu);
        $this->assign('chat', $chat);
        return view();
    }

    function publicSaveChat()
    {
        if (request()->isPost()) {
            $param = [
                'chat_id' => input('post.chat_id'),
                'detail' => input('post.detail')
            ];
            if (Db::name('chats')->insert($param) == 1) {
                return success('保存成功', url('chatlist'));
            } else {
                return error('请更新数据！');
            }
        } else {
            return view();
        }
    }

    public function delChat()
    {
        $id = input('post.id');


        $res = Db::name('chats')->delete($id);
        if ($res == 1) {

            $logsData = "删除数据【id： " . $id . "】 的数据";

            Logs::create([
                'title'   => '删除数据',
                'content' => $logsData,
            ]);

            echo json_encode(['status' => 'success', 'code' => 200, 'msg' => '删除成功']);
        } else {
            echo json_encode(['status' => 'error', 'code' => 201, 'msg' => '删除失败']);
        }
    }
}
