<?php

namespace Observer;

/*
|--------------------------------------------------------------------------
| 模型观察者
|--------------------------------------------------------------------------
| 模型事件触发顺序
|--------------------------------------------------------------------------
|
| 创建 & 更新
|
|          |-- creating -- created --|
| saving --|                         |-- saved
|          |-- updating -- updated --|
| 
| 
| 软删除 & 强制删除
| 
| deleting -- deleted
|            
| 
| 恢复
| 
| restoring -- saving -- updating -- updated -- saved -- restored
| 
*/
class AdminAccount
{
    public function created($model)
    {
        // 账号创建后，补充逻辑，标记超级管理员
        if ($model->id === 1) {
            // 移除只读限制
            $model->removeRule('is_super_account.read_only', 'updating');
            $model->find($model->id)->update(['is_super_account' => true]);
        }
    }

}

