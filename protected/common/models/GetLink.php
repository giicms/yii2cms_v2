<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class GetLink extends Model
{
    public $url;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['url'], 'required']
        ];
    }

}
