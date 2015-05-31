<?php
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'super-administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Super Administrator',
        'children' => array(
            'administrator',
        ),
        'bizRule' => null,
        'data' => null
    )
);