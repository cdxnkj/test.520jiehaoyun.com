<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 月嫂管理
 *
 * @icon fa fa-circle-o
 */
class Yuesao extends Backend
{

    /**
     * Yuesao模型对象
     * @var \app\admin\model\Yuesao
     */
    protected $model = null;
    protected $multiFields = "switch";

    public function _initialize()
    {

        parent::_initialize();
        $this->model = new \app\admin\model\Yuesao;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("levelList", $this->model->getLevelList());
        $this->view->assign("babyDataList", $this->model->getBabyDataList());
        $this->view->assign("schoolingDataList", $this->model->getSchoolingDataList());
        $this->view->assign("holderList", $this->model->getHolderList());
        $this->view->assign("newbornOptionDataList", $this->model->getNewbornOptionDataList());
        $this->view->assign("maternalOptionsDataList", $this->model->getMaternalOptionsDataList());
        $this->view->assign("medicalDataList", $this->model->getMedicalDataList());
    }


    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams('name');
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }


    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                /*   pr($params);die;
                   if ($params['training_records']) {
                       foreach ($params['training_records'] as $k => &$v) {
   //
                           $params['training_records_new'][] = [$v['key'] => $v['value']];
                       }
                       $params['training_records'] = json_encode(array_reduce($params['training_records_new'], 'array_merge', []), JSON_UNESCAPED_UNICODE);
                       unset($params['training_records_new']);

                   }*/


                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $params['holder'] = $params['holder'] ? implode(',', $params['holder']) : null;
                $params['newborn_option_data'] = $params['newborn_option_data'] ? implode(',', $params['newborn_option_data']) : null;
                $params['maternal_options_data'] = $params['maternal_options_data'] ? implode(',', $params['maternal_options_data']) : null;

                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validate($validate);
                    }
//                    var_dump(implode(',',$params['holder']));die;


                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result) {
                    $this->success();
                } else {
                    $this->error();
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $row['training_records'] = json_encode([
            '岗前培训' => '0',
            '中级升金牌' => '0',
            '金牌升钻石' => '0',
            '钻石升定制' => '0',
            '月子餐' => '0',
            '新生儿护理' => '0',
            '产妇护理' => '0',
            '产后康复' => '0',

        ], JSON_UNESCAPED_UNICODE);
//        pr($row);die;

        $this->view->assign('row', $row);
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
//        pr(json_decode($row->training_records),true);die;
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }


}
