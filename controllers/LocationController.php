<?php

namespace app\controllers;

use app\models\Cities;
use app\models\Location;
use app\models\LocationSearch;
use app\models\States;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

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
    public function actionCities() {
         \Yii::$app->response->format = Response::FORMAT_JSON;

    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $state_id = $parents[0];

            $cities = Cities::find()
                ->where(['state_id' => $state_id])
                ->select(['id','name'])
                ->orderBy('name')
                ->asArray()
                ->all();

            $out = [];
            foreach ($cities as $city) {
                $out[] = ['id' => $city['id'], 'name' => $city['name']];
            }

            return ['output' => $out, 'selected' => ''];
        }
    }
    return ['output' => '', 'selected' => ''];
    }
      public function actionStates() {
         \Yii::$app->response->format = Response::FORMAT_JSON;

    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $country_id = $parents[0];

            $cities = States::find()
                ->where(['country_id' => $country_id])
                ->select(['id','name'])
                ->orderBy('name')
                ->asArray()
                ->all();

            $out = [];
            foreach ($cities as $city) {
                $out[] = ['id' => $city['id'], 'name' => $city['name']];
            }

            return ['output' => $out, 'selected' => ''];
        }
    }
    return ['output' => '', 'selected' => ''];
    }
}
