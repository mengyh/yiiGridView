<?php
namespace app\controllers;
use yii;
use yii\web\controller;
use app\models\Supplier;
class SiteController extends controller
{
  public function actionIndex()
  {
 
    $Supplier = new Supplier(); 
    //调用模型search方法，把get参数传进去
    $provider = $Supplier->search(yii::$app->request->get());
    $Supplier->name = $Supplier->getdefaultval(yii::$app->request->get(),'name');
    $Supplier->code = $Supplier->getdefaultval(yii::$app->request->get(),'code');
    $Supplier->id   = $Supplier->getdefaultval(yii::$app->request->get(),'id');
    $Supplier->t_status   = $Supplier->getdefaultval(yii::$app->request->get(),'t_status');
    return $this->render('index', [
      'model' => $Supplier,
      'provider' => $provider,
      'params' =>yii::$app->request->get()
    ]);
  }
  public function actionExport(){
    $Supplier = new Supplier(); 
    $filename = date('Y-m-d_H-i-s') . '.csv';        
    header('Content-Type: text/csv');
    header("Content-Disposition: attachment;filename={$filename}");
    $fp = fopen('php://output', 'w');
    $header = ['id','name','code','t_status'];
    fputcsv($fp, $header);
    $data = $Supplier->exportbyid(yii::$app->request->get());
    if (isset($data)) {
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
    }
  }
}