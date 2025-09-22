<?php

namespace app\controllers;

use app\models\Countries;
use app\models\Location;
use app\models\LocationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use Yii;
use app\models\Vehicle;
use yii\helpers\VarDumper;
use yii\db\Query;
/**
 * LocationController implements the CRUD actions for Location model.
 */
class LocationController extends Controller
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
     * Lists all Location models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Location model.
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
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Location();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Location model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Location model.
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
     * Finds the Location model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Location the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Location::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

public function actionAdrese($vid, $tip,$aid=0)
{
    // Yii::$app->response->format = Response::FORMAT_JSON;
    
    $model=Location::findOne(['id'=>$aid])??new Location(); 
    $tari=(new yii\db\Query())
    ->select(['name'])
    ->from('countries_eu')  
    ->orderBy(['name'=>SORT_ASC])->all();
    $tariList=''; 
    foreach ($tari as $tara) {
        $tariList .= '<option value="' . $tara['name'] . '">';
    }
    
    return $this->renderAjax('_adresa', [
        'model' => $model,'tip'=>$tip,'vid'=>$vid,'aid'=>$aid,'tariList'=>$tariList
    ]);


}

  public function actionAdreseAjax()
{
    Yii::$app->response->format = Response::FORMAT_JSON;
    
    $vid =  Yii::$app->request->post('vid');
    $tip=  Yii::$app->request->post('tip');
    $aid =  Yii::$app->request->post('aid');
    $vehicle=Vehicle::findOne(['id'=>$vid]);
    $location=Location::findOne(['id'=>$aid])??new Location();   
    
     $location->country =  Yii::$app->request->post('country');
     $location->region =  Yii::$app->request->post('region');
     $location->city =  Yii::$app->request->post('city');
     $location->company= Yii::$app->request->post('company');
     $location->address= Yii::$app->request->post('address');
     $location->save();
       
       
            $adresaStr = $location->company.','.$location->address.', '.$location->city.(!empty($location->region)?', '.$location->region:'')
            .', '.$location->country;               
             $adresaId=$location->id;

           if ($location->save()) { 
            switch ($tip) {
                case 'exp_ai':
                   {
                     $vehicle->exp_adr_start=$adresaStr;
                     $vehicle->exp_adr_start_id=$adresaId;
                      $vehicle->save();
                   }break;
                case 'exp_ad':
                   {
                     $vehicle->exp_adr_end=$adresaStr;
                     $vehicle->exp_adr_end_id=$adresaId;
                      $vehicle->save();
                   } break;
                case 'imp_ai':
                   {
                     $vehicle->imp_adr_start=$adresaStr;
                     $vehicle->imp_adr_start_id=$adresaId;
                      $vehicle->save();
                   }break;
                case 'imp_ad':
                   {
                     $vehicle->imp_adr_end=$adresaStr;
                     $vehicle->imp_adr_end_id=$adresaId;
                      $vehicle->save();
                   }
                    break;
                
                default:
                    # code...
                    break;
            }
        
          return ['success'=>true];             

    } 

    return ['success' => false, 'message' => 'Eroare salvare !'];
}
}
