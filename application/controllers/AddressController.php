<?php
class AddressController extends FrontController
{
    public function actionGet()
    {
        $attr = array(
            'order'=>'sort_order'
        );

        $addresses = Address::model()->findAll($attr);

        if(count($addresses) && $addresses)
        {
            $output = array();

            foreach($addresses as $address)
            {
                $model = Service::model()->findByPk($address->service_id);
                $service = $model->title;
                $organization = Organization::model()->findByPk($model->organization_id)->name;
                $organization_id = Organization::model()->findByPk($model->organization_id)->organization_id;

                $output[] = array(
                    'organization_id'=>$organization_id,
                    'organization'=>$organization,
                    'service'=>$service,
                    'service_id'=>$address->service_id,
                    'title'=>$address->title,
                    'city'=>$address->city,
                    'area'=>$address->area,
                    'address'=>$address->address,
                    'map_lat'=>$address->map_lat,
                    'map_lng'=>$address->map_lng,
                    'hostName'=>$_SERVER['SERVER_NAME'],
                    'file_name'=>$address->file_name,
                    'thumb_dir'=>Address::thumb_dir,
                );
            }

            echo json_encode($output);
        }
    }
}