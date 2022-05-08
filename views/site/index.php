<?php
use yii\grid\GridView;
use yii\helpers\html;
/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <span color=red>note:</span>
      <span id='note'>nothing selected</span>
      <button class="btn btn-primary" id="export">Export</button>
      <button class="btn btn-primary" id="clear">clear selection</button>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
        <?php
        echo GridView::widget([
                'id' => 'supplier',
                'dataProvider' => $provider,
                'filterModel' => $model,
                'layout' => "{summary}\n{items}\n{pager}" ,
                'emptyText'=>'nothing',
                'emptyTextOptions'=>['style'=>'color:red;font-weight:bold'],
                'rowOptions'=>function($model){
                    return ['id'=>"tr-".$model->id];
                },  
                'showFooter'=>false,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn'
                        
                    ],
                    [  
                        'header'=>'id',
                        'label'=>'id',
                        'attribute'=>'id',
                        'value' => function ($data) {
                            return $data->id;
                        },
                        'filter' => $model->getwhereid()
                    ],
                    [
                        'attribute'=>'name',
                        'enableSorting'=>false,
                        'value'=>function($data){
                            return $data->name;
                        },
                        
                    ],
                    [
                        'attribute'=>'code',
                        'value' => function ($data) {
                            return $data->code; 
                        }
                    ],
                   
                    [
                        'attribute'=>'t_status',
                        'value' => function ($data) {
                            return $data->t_status;
                        }, 
                        'filter' => $model->getwherestatus()  
                    ],
                ]
         ]);
        ?>
    </div>
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
   let page    = <?=(Yii::$app->request->get()['page'])?>;
   let suppliers = [];
   if(localStorage.suppliers){
        suppliers = JSON.parse(localStorage.suppliers);
   }
   if(suppliers && suppliers[page]){
        suppliers = suppliers[page];
   }
   let checked = $("input[type='checkbox']");
  if(suppliers && suppliers.length>0){
    suppliers.forEach(function(id){
        for(var i=0;i<checked.length;i++){
            if(id==checked[i].value){
                checked[i].checked = true;
            }  
        };
    });
  }
  let allsuppliers = getallsuppliers();
  $("#note").html('you checked '+allsuppliers.length+ ' suppliers');
  $("#export").on("click", function () {
    let ids = getallsuppliers();
    window.location.href = '/index?r=site%2Fexport&ids='+ids.join(',');
  });
  $("#clear").on("click", function () {
    localStorage.suppliers="";
    let checked = $("input[type='checkbox']");
    for(var i=0;i<checked.length;i++){
        checked[i].checked = false; 
    };
  });
  $("input[type='checkbox']").on("change", function () {
    let pageobj = {};
    if(localStorage.suppliers){
        pageobj = JSON.parse(localStorage.suppliers);
    }
    pageobj[page] = $("#supplier").yiiGridView('getSelectedRows');
    localStorage['suppliers'] = JSON.stringify(pageobj);
    let allsuppliers = getallsuppliers();
    $("#note").html('you checked '+allsuppliers.length+ ' suppliers');
  });
  function getallsuppliers(){
    let allsuppliers = [];
    if(localStorage.suppliers){
        suppliers = JSON.parse(localStorage.suppliers);
        for(i in suppliers){
            if(allsuppliers.length>0){
                allsuppliers = allsuppliers.concat(suppliers[i]);
            }else{
                allsuppliers=suppliers[i];
            }
        }
    }
    return allsuppliers;
  }
</script>