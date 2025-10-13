<?php

namespace app\controllers;

use app\models\Invoice;
use app\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\web\Response;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            // allow only the specific user (by username)
                            'allow' => true,
                            'roles' => ['@'], // logged-in users
                            'matchCallback' => function ($rule, $action) {
                                return (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isContabil());
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Invoice models.
     *
     * @return string
     */
    public function actionIndex($moneda)
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'moneda' => $moneda,
        ]);
    }


    /**
     * Displays a single Invoice model.
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
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($moneda)
    {
        $model = new Invoice();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index?moneda=' . $moneda]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'moneda' => $moneda,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index?moneda='.$model->moneda]);
        }

        return $this->render('update', [
            'model' => $model,
            'moneda'=>$model->moneda,
        ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = Invoice::findOne($id);
        if (!$model) {
            return ['success' => false, 'message' => 'Factura nu a fost găsită.'];
    }

    try {
        $model->delete();
        return ['success' => true];
    } catch (\Throwable $e) {
        return ['success' => false, 'message' => 'Eroare la ștergere: ' . $e->getMessage()];
    }
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionData($days, $moneda)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        // --- DataTables parameters ---
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->get('search')['value'] ?? '';
        $columns = [
            'id',
            'dateinvoiced',
            'duedate',
            'nr_factura',
            'partener',
            'valoare_ron',
            'suma_achitata_ron',
            'sold_ron',
            'valoare_eur',
            'suma_achitata_eur',
            'sold_eur',
            'paymentdate',
            'mentiuni',
            'credit_note'
        ];
        $query = Invoice::find()->where(['=', 'moneda', $moneda]);
        $days = (int) $days;
        $breakpoints = [15, 30, 45, 60];

        // Find the previous breakpoint (lower bound)
        $previous = 0;
        foreach ($breakpoints as $point) {
            if ($days > $point) {
                $previous = $point;
            } else {
                break;
            }
        }

        if ($days <= 15) {
            // duedays <= 15
            $query->andWhere(['<=', 'duedays', 15]);
        } elseif ($days > 60) {
            // duedays > 60
            $query->andWhere(['>', 'duedays', 60]);
        } else {
            // duedays between previous and current range
            $query->andWhere(['between', 'duedays', $previous + 1, $days]);
        }

        if (!empty($searchValue)) {
            $query->andFilterWhere([
                'or',
                ['like', 'partener', $searchValue],
                ['like', 'nr_factura', $searchValue],
                ['like', 'invoicedate', $searchValue],
            ]);
        }
        $order = $request->get('order', []);
        if (!empty($order)) {
            $colIndex = $order[0]['column'] ?? 0;
            $colDir = $order[0]['dir'] ?? 'asc';
            if (isset($columns[$colIndex])) {
                $query->orderBy([$columns[$colIndex] => ($colDir === 'desc' ? SORT_DESC : SORT_ASC)]);
            }
        } else {
            $query->orderBy(['dateinvoiced' => SORT_DESC]); // default order
        }
        $totalRecords = (clone $query)->count();
        $payments = $query
            ->offset($start)
            ->limit($length)
            ->all();
        $data = [];
        foreach ($payments as $p) {
            $data[] = [
                'id' => $p->id,
                'dateinvoiced' => Yii::$app->formatter->asDate($p->dateinvoiced, 'dd.MM.yyyy'),
                'duedate' => Yii::$app->formatter->asDate($p->duedate, 'dd.MM.yyyy'),
                'nr_factura' => $p->nr_factura,
                'partener' => $p->partener ?? '(Fără partener)',
                'valoare_ron' => $p->valoare_ron,
                'suma_achitata_ron' => $p->suma_achitata_ron,
                'sold_ron' => $p->sold_ron,
                'valoare_eur' => $p->valoare_eur,
                'suma_achitata_eur' => $p->suma_achitata_eur,
                'sold_eur' => $p->sold_eur,
                'paymentdate' => Yii::$app->formatter->asDate($p->paymentdate, 'dd.MM.yyyy'),
                'mentiuni' => $p->mentiuni,
                'credit_note' => $p->credit_note,
                'diferenta' => $p->diferenta,
            ];
        }

        return [
            'draw' => intval($draw),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords),
            'data' => $data,
        ];
    }

    public function actionDuplicate() {
Yii::$app->response->format = Response::FORMAT_JSON;
    $id = Yii::$app->request->post('id');

    $model = Invoice::findOne($id);
    if (!$model) {
        return ['success' => false, 'message' => 'Factura nu a fost găsită.'];
    }

    $newModel = new Invoice();
    $newModel->attributes = $model->attributes;
    $newModel->id = null; // ensure a new record
    
    if ($newModel->save(false)) {
        return ['success' => true, 'id' => $newModel->id];
    }

    return ['success' => false, 'message' => 'Eroare la salvare.'];
}

public function actionUpdateInline()
{
    Yii::$app->response->format = Response::FORMAT_JSON;

    $id = Yii::$app->request->post('id');
    $field = Yii::$app->request->post('field');
    $value = Yii::$app->request->post('value');

    $model = Invoice::findOne($id);
    if (!$model) {
        return ['success' => false, 'message' => 'Factura nu a fost găsită.'];
    }

    // Validate safe attributes only
    if (!in_array($field, $model->safeAttributes())) {
        return ['success' => false, 'message' => 'Câmp nepermis.'];
    }

    $model->$field = $value;
    if($field==='duedate')
        {
            $model->calculateDueDays();       
            $model->save(false,['duedays']);     
        }    
    if($field==='suma_achitata_ron' || $field==='suma_achitata_eur' || $field==='valoare_ron' || $field==='valoare_eur' )
    {
        if($field==='suma_achitata_ron' || $field==='valoare_ron') {
           $model->calculateSold('RON');
           $model->save(false,['sold_ron']);
        }
        else if($field==='suma_achitata_eur' || $field==='valoare_eur') {
           $model->calculateSold('EUR');
           $model->save(false,['sold_eur']);
        }    
    } 
  

    if ($model->save(false, [$field])) {
        return ['success' => true];
    }

    return ['success' => false, 'message' => 'Eroare la salvare.'];
}
}
