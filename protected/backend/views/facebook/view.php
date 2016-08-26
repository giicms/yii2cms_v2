<?php
/* @var $this yii\web\View */


$this->title = $info['title'];
?>



<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($info)) {
            $i = 1;
            foreach ($info['data'] as $key => $value) {
                parse_str($value, $item);
                echo '<p>' . $i . '. ' . $item['type'] . ' <a class="btn btn-primary" href="' . $item['url'] . '?title=' . $info['title'] . '"> Dowload</a><br> <textarea style="height:200px" class="form-control">' . $item['url'] . '</textarea><p>';
                $i++;
            }
        }
        ?>

    </div>
</div>