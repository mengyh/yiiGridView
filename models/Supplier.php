<?php

namespace app\models;
use yii\db\activerecord;
use yii\data\activedataprovider;
class Supplier extends activerecord
{

    public function rules()
    {
        return [
          [['id', 'name', 'code', 't_status'], 'trim'],
          [['id', 't_status'], 'integer'],
          [['name','code'], 'safe'],
         
        ];
    }
    public function getwhereid(){
        return ['All','>10','>=10','<10','<=10'];
    }
    public function getwherestatus(){
        return ['All','ok','hold'];
    }
    public function getdefaultval($params,$key){
        $params = $params['Supplier'];
        return $params[$key];
    }
    public function exportbyid($params){
        $query = self::find();
        if(isset($params['ids'])){
            $params['ids'] = explode(",",$params['ids']);
            $data = $query->andfilterwhere(['in','id',$params['ids']])->asArray()->all();
        }else{
            $data = [];
        }
        return $data;
    }
    public function search($params)
    {
        $query = self::find();
        $provider = new activedataprovider([
          'query' => $query,
          'pagination' => [
            'pagesize' => 3
          ]
        ]);
        $params = $params['Supplier'];
        if (empty($params)) {
          return $provider;
        }
        if(isset($params['id'])){
            switch ($params['id']){
                case 1:
                    $query->andfilterwhere(['>','id',10]);
                    break;
                case 2:
                    $query->andfilterwhere(['>=','id',10]);
                    break;
                case 3:
                    $query->andfilterwhere(['<','id',10]);
                    break;
                case 4:
                    $query->andfilterwhere(['<=','id',10]);
                    break;
                default:
                    break;
                }
        }
        if($params['name']||$params['code']){
            $query->andfilterwhere(['or',['like','name', $params['name']],['like','code',$params['code']]]);
        }
        if(!empty($params['t_status'])){
            switch ($params['t_status']){
                case 1:
                    $query->andfilterwhere(['t_status' => 1]);
                    break;
                case 2:
                    $query->andfilterwhere(['t_status' => 2]);
                    break;
                default:
                    break;
            }
        }
        return $provider;
    }
}
