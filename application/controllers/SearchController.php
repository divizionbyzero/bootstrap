<?php
class SearchController extends FrontController
{
    public function actionIndex()
    {
        if($_POST['SearchWord'])
        {
            $res = Yii::app()->db->createCommand('

                SELECT
                        DISTINCT(`service`.`service_id`) as `id`,
                        `service`.`title` as `title`,
                        `organization`.`name` AS `organization_name`,
                        `service`.`description` AS `description`,
                        CONCAT( \'/\', \'service\', \'/\', \'show\', \'/\', \'service_id\', \'/\', `service`.`service_id`) AS `url`
                FROM
                        `service`
                        LEFT JOIN `service_type` ON `service`.`service_type_id` = `service_type`.`service_type_id`
                        LEFT JOIN `organization` ON `service`.`organization_id` = `organization`.`organization_id`
                        LEFT JOIN `address` ON `address`.service_id = `service`.`service_id`
                        LEFT JOIN `area` ON `area`.area_id = `address`.`area_id`
                        LEFT JOIN `city` ON `city`.city_id = `address`.`city_id`
                        LEFT JOIN `contact` ON `contact`.address_id = `address`.`address_id`
                        LEFT JOIN `contact_type` ON `contact_type`.contact_type_id = `contact`.`contact_type_id`
                WHERE
                        service.`title` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `service`.`description` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `organization`.`description` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `organization`.`title` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `area`.`name` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `city`.`name` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `contact`.`contact` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `address`.`address` LIKE \'%' . $_POST['SearchWord'] . '%\'
                        OR `service_type`.`name` LIKE \'%' . $_POST['SearchWord'] . '%\'

                ORDER BY `title`')->queryAll();

            $this->title('Результаты поиска');
            $this->render('list', array(
                'res'=>$res
            ));
        }
    }
}