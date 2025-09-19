<?php

namespace app\controllers;

use app\models\Vehicle;
use app\models\VehicleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use Yii;

/**
 * VehicleController implements the CRUD actions for Vehicle model.
 */
class VehicleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ],
             ['access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        // allow only the specific user (by username)
                        'allow' => true,
                        'roles' => ['@'], // logged-in users                        
                    ],
                ],
            ],],
        );
    }

    /**
     * Lists all Vehicle models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VehicleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vehicle model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Vehicle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Vehicle();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        if ($this->request->isAjax)
        {
            return $this->renderAjax('create', [
            'model' => $model,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Vehicle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Vehicle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vehicle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Vehicle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vehicle::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionInfo($id)
    {
        $model=$this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
        // after save, close modal & refresh GridView
        // return '<script>jQuery("#modal").modal("hide"); $.pjax.reload({container:"#grid-pjax"}); console.log("aa");</script>';
        return $this->redirect(['index']);
    }
        return $this->renderAjax('info', [
        'model' => $model,
    ]);
    }

    public function actionEditStartDate()
{
    $model = Vehicle::findOne(Yii::$app->request->post('editableKey'));
    $out = ['output' => '', 'message' => ''];

    if ($model !== null) {
        $posted = current($_POST['Vehicle']);
        $post = ['Vehicle' => $posted];
        if ($model->load($post) && $model->save()) {
            $out['output'] = Yii::$app->formatter->asDate($model->start_date, 'php:Y-m-d');
        } else {
            $out['message'] = 'Eroare salvare !';
        }
    }
    return json_encode($out);
}
  public function actionEditEndDate()
{
    $model = Vehicle::findOne(Yii::$app->request->post('editableKey'));
    $out = ['output' => '', 'message' => ''];

    if ($model !== null) {
        $posted = current($_POST['Vehicle']);
        $post = ['Vehicle' => $posted];
        if ($model->load($post) && $model->save()) {
            $out['output'] = Yii::$app->formatter->asDate($model->end_date, 'php:Y-m-d');
        } else {
            $out['message'] = 'Eroare salvare !';
        }
    }
    return json_encode($out);
}

public function actionEditExpAdrStart()
{
    $model = Vehicle::findOne(Yii::$app->request->post('editableKey'));
    $out = ['output' => '', 'message' => ''];

    if ($model !== null) {
        $posted = current($_POST['Vehicle']);
        $post = ['Vehicle' => $posted];
        if ($model->load($post) && $model->save()) {
            $out['output'] = $model->exp_adr_start; // return new value
        } else {
            $out['message'] = 'Eroare salvare !';
        }
    }
    return json_encode($out);
}
public function actionEditExpAdrEnd()
{
    $model = Vehicle::findOne(Yii::$app->request->post('editableKey'));
    $out = ['output' => '', 'message' => ''];

    if ($model !== null) {
        $posted = current($_POST['Vehicle']);
        $post = ['Vehicle' => $posted];
        if ($model->load($post) && $model->save()) {
            $out['output'] = $model->exp_adr_end; // return new value
        } else {
            $out['message'] = 'Eroare salvare !';
        }
    }
    return json_encode($out);
}

public function actionEditImpAdrStart()
{
    $model = Vehicle::findOne(Yii::$app->request->post('editableKey'));
    $out = ['output' => '', 'message' => ''];

    if ($model !== null) {
        $posted = current($_POST['Vehicle']);
        $post = ['Vehicle' => $posted];
        if ($model->load($post) && $model->save()) {
            $out['output'] = $model->imp_adr_start; // return new value
        } else {
            $out['message'] = 'Eroare salvare !';
        }
    }
    return json_encode($out);
}
public function actionEditImpAdrEnd()
{
    $model = Vehicle::findOne(Yii::$app->request->post('editableKey'));
    $out = ['output' => '', 'message' => ''];

    if ($model !== null) {
        $posted = current($_POST['Vehicle']);
        $post = ['Vehicle' => $posted];
        if ($model->load($post) && $model->save()) {
            $out['output'] = $model->imp_adr_end; // return new value
        } else {
            $out['message'] = 'Eroare salvare !';
        }
    }
    return json_encode($out);
}
public function actionEditOrder()
{
     $model = Vehicle::findOne(Yii::$app->request->post('editableKey'));
     $transportOrder = $model->transportOrder;
        if($transportOrder!==null)
        {
            $transportOrder->status=0;
            $transportOrder->save();
        }
     $out = ['output' => '', 'message' => ''];        
    if ($model !== null) {
        $posted = current($_POST['Vehicle']);
        $post = ['Vehicle' => $posted];      
         /*if(strlen($posted['transport_order_id'])>0) {
        $cnt = Vehicle::find()->where(['transport_order_id'=>$posted['transport_order_id']])->count();      
        if ($cnt>0) {
            $out['output']='Comanda alocata!';
            $out['message']=$out['output'];
            return json_encode($out);
        }
         } */
        if ($model->load($post) && $model->save()) {
            if(strlen($posted['transport_order_id'])>0)
            {
           
            $model->status=1;
            $model->transportOrder->status=1;
            $model->transportOrder->save();
            } else{
            $model->status=0; 
            $transportOrder->status=0;
            $transportOrder->save();
            }
         
            $model->save();            
            
            $out['output'] = isset($model->transportOrder)?$model->transportOrder->documentno:'(not set)'; // return new value
        } else {
            $out['message'] = 'Eroare salvare !';
        }
    }
    return json_encode($out);
}

/* Helper function */
protected function saveEditable($modelClass, $attribute, $displayCallback = null) {
    $model = $modelClass::findOne(Yii::$app->request->post('editableKey'));
    $out = ['output' => '', 'message' => ''];

    if($model !== null) {
        $posted = current($_POST[$modelClass::formName()]);
        $post = [$modelClass::formName() => $posted];
        if($model->load($post) && $model->save()) {
            if($displayCallback) {
                $out['output'] = $displayCallback($model);
            } else {
                $out['output'] = $model->$attribute;
            }
        } else {
            $out['message'] = 'Eroare salvare!';
        }
    }
    return json_encode($out);
}

public function actionFinalizeOrder($id)
{
     $model = Vehicle::findOne($id);
     $transportOrder = $model->transportOrder;
        if($transportOrder!==null)
        {
            $transportOrder->status=2;
            $transportOrder->save();
            // free vehicle
            $model->status=0;
             $model->transport_order_id=null;
            $model->start_date=null;
            $model->end_date=null;
            $model->exp_adr_start=null;
            $model->exp_adr_end=null;                
            $model->imp_adr_start=null;
            $model->imp_adr_end=null;                
            $model->info=null;
            $model->save();
        }
     return $this->redirect(['index']);

}
public function actionSummary($id) {
    
    $model=$this->findModel($id);         
        return $this->renderPartial('_popover', [
        'model' => $model,
    ]);
}
public function actionData()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $query = Vehicle::find();
        $total = $query->count();

        // 🔍 Search filter
        $search = \Yii::$app->request->get('search')['value'] ?? null;
        if ($search) {
            $query->andFilterWhere(['like', 'regno', $search])
                  ->orFilterWhere(['like', 'end_date', $search]);
        }

        $filtered = $query->count();

        // 🔄 Paging & ordering
        $start = Yii::$app->request->get('start', 0);
        $length =Yii::$app->request->get('length', 10);
        $order = Yii::$app->request->get('order', []);
        $columns = ['regno', 'end_date']; // map column indexes → DB fields

    if (!empty($order)) {
        $colIndex = $order[0]['column']; // which column index
        $dir = $order[0]['dir'] === 'desc' ? SORT_DESC : SORT_ASC;

        if (isset($columns[$colIndex])) {
            $query->orderBy([$columns[$colIndex] => $dir]);
        }
    }
        $vehicles = $query->offset($start)->limit($length)->all();

        $data = [];
        foreach ($vehicles as $vehicle) {
             $actions = '
            <a href="'.\yii\helpers\Url::to(['vehicle/view', 'id' => $vehicle->id]).'" class="btn btn-sm btn-primary">View</a>
            <a href="'.\yii\helpers\Url::to(['vehicle/update', 'id' => $vehicle->id]).'" class="btn btn-sm btn-warning">Edit</a>
            <a href="'.\yii\helpers\Url::to(['vehicle/delete', 'id' => $vehicle->id]).'" class="btn btn-sm btn-danger" data-method="post" data-confirm="Are you sure?">Delete</a>
        ';
            $data[] = [
                $vehicle->id,
                $vehicle->regno,   
                $vehicle->transport_order_id,
                $vehicle->start_date,
                $vehicle->end_date,
                $vehicle->exp_adr_start,
                $vehicle->exp_adr_end,
                $vehicle->imp_adr_start,
                $vehicle->imp_adr_end,
                $actions
            ];
        }

        return [
            "draw" => intval(\Yii::$app->request->get('draw')),
            "recordsTotal" => $total,
            "recordsFiltered" => $filtered,
            "data" => $data,
        ];
    }
}