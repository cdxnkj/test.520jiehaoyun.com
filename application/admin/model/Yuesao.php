<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Yuesao extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'yuesao';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'type_text',
        'baby_data_text',
        'schooling_data_text',
        'holder_text',
        'newborn_option_data_text',
        'maternal_options_data_text',
        'medical_data_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getTypeList()
    {
        return ['yuesao' => __('Type yuesao'), 'yuersao' => __('Type yuersao')];
    }

    public function getBabyDataList()
    {
        return ['yhyy' => __('Baby_data yhyy'), 'yhwy' => __('Baby_data yhwy'), 'ly' => __('Baby_data ly'), 'so' => __('Baby_data so')];
    }

    public function getSchoolingDataList()
    {
        return ['cz' => __('Schooling_data cz'), 'gz' => __('Schooling_data gz'), 'dz' => __('Schooling_data dz'), 'bk' => __('Schooling_data bk'), 'ssys' => __('Schooling_data ssys')];
    }

    public function getHolderList()
    {
        return ['sfz' => __('Holder sfz'), 'yys' => __('Holder yys'), 'my' => __('Holder my'), 'ys' => __('Holder ys'), 'cr' => __('Holder cr'), 'xrtn' => __('Holder xrtn'), 'chkfs' => __('Holder chkfs'), 'bjam' => __('Holder bjam'), 'yy' => __('Holder yy'), 'byy' => __('Holder byy'), 'cs' => __('Holder cs'), 'hs' => __('Holder hs'), 'jszg' => __('Holder jszg'), 'hz' => __('Holder hz'), 'gatx' => __('Holder gatx'), 'jz' => __('Holder jz')];
    }

    public function getNewbornOptionDataList()
    {
        return ['xsrjchl' => __('Newborn_option_data xsrjchl'), 'xsrcjjbgc' => __('Newborn_option_data xsrcjjbgc'), 'sbtzcrhl' => __('Newborn_option_data sbtzcrhl'), 'xrtn' => __('Newborn_option_data xrtn'), 'xsrzj' => __('Newborn_option_data xsrzj')];
    }

    public function getMaternalOptionsDataList()
    {
        return ['cfjchl' => __('Maternal_options_data cfjchl'), 'tscfhl' => __('Maternal_options_data tscfhl'), 'cfcjjbgc' => __('Maternal_options_data cfcjjbgc'), 'jcyzc' => __('Maternal_options_data jcyzc'), 'tlyzc' => __('Maternal_options_data tlyzc'), 'chkfz' => __('Maternal_options_data chkfz'), 'chbfd' => __('Maternal_options_data chbfd'), 'chjlam' => __('Maternal_options_data chjlam'), 'jcrfhl' => __('Maternal_options_data jcrfhl')];
    }

    public function getMedicalDataList()
    {
        return ['qualified' => __('Medical_data qualified'), 'unqualified' => __('Medical_data unqualified')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getHolderList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getBabyDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['baby_data']) ? $data['baby_data'] : '');
        $list = $this->getBabyDataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getSchoolingDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['schooling_data']) ? $data['schooling_data'] : '');
        $list = $this->getSchoolingDataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getHolderTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['holder']) ? $data['holder'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getHolderList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getNewbornOptionDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['newborn_option_data']) ? $data['newborn_option_data'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getNewbornOptionDataList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getMaternalOptionsDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['maternal_options_data']) ? $data['maternal_options_data'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getMaternalOptionsDataList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getMedicalDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['medical_data']) ? $data['medical_data'] : '');
        $list = $this->getMedicalDataList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setHolderAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }

    protected function setNewbornOptionDataAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }

    protected function setMaternalOptionsDataAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }


}
