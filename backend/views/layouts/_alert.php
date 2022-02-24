<?php
/**
 * User: Burak Efe
 * Date: 24.02.2022
 * Time: 15:42
 */

$session = Yii::$app->session;

$alert = $session->get('alert');

if($alert){

    if($alert["type"] === "success"){ ?>

        <script>
            iziToast.success({
                title: '<?php echo $alert["title"]; ?>',
                message: '<?php echo $alert["text"]; ?>',
                position : "topCenter"
            })
        </script>

    <?php } else { ?>

        <script>
            iziToast.error({
                title: '<?php echo $alert["title"]; ?>',
                message: '<?php echo $alert["text"]; ?>',
                position : "topCenter"
            })
        </script>

    <?php }
}

$session->remove('alert');

?>


