<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?php echo StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;

/**
 * <?php echo $controllerClass ?> implements the CRUD actions for <?php echo $modelClass ?> model
 */
class <?php echo $controllerClass ?> extends <?php echo 'CRUDController' . "\n" ?>
{

    protected $modelForSearch = '\common\models\search\<?php echo $searchModelClass ?>';
    protected $modelForView = '\common\models\domain\<?php echo $modelClass ?>';
    protected $modelForCreate = '\common\models\domain\<?php echo $modelClass ?>';
    protected $modelForUpdate = '\common\models\domain\<?php echo $modelClass ?>';
    protected $modelForDelete = '\common\models\domain\<?php echo $modelClass ?>';

    protected function getContainerClass()
    {
        return '<?php echo Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/<?php echo Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', '<?php echo $modelClass ?>.Area.Title');
    }

}