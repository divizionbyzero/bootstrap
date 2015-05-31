<?php
return array(
    'menu'=>array(
        'Администрирование' => array(
            array(
                'title' => 'Пользователи',
                'url' => '/adm/user',
                'active' => 'user',
                'icon' => 'icon-user'
            )
        ),
        'Контактные данные'=> array(
            array(
                'title' => 'Города',
                'url' => '/adm/city',
                'active' => 'city',
                'icon' => 'icon-globe'
            ),
            array(
                'title' => 'Районы',
                'url' => '/adm/area',
                'active' => 'area',
                'icon' => 'icon-home'
            ),
            array(
                'title' => 'Типы контактов',
                'url' => '/adm/contacttype',
                'active' => 'contacttype',
                'icon' => 'icon-list'
            ),
        ),
        'Контент сайта' => array(
            array(
                'title' => 'Организации',
                'url' => '/adm/organization',
                'active' => 'organization',
                'icon' => 'icon-home'
            ),
            array(
                'title' => 'Типы услуг',
                'url' => '/adm/servicetype',
                'active' => 'servicetype',
                'icon' => 'icon-list'
            ),
            array(
                'title' => 'Услуги',
                'url' => '/adm/service',
                'active' => 'service',
                'icon' => 'icon-briefcase'
            )
        )
    ),
    'logo'=>'img/logo.png'
);