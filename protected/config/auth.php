<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    1 => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Psychologist',
        'bizRule' => null,
        'data' => null
    ),
    2 => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Lawyer',
        'children' => array(
            1,
        ),
        'bizRule' => null,
        'data' => null
    ),
    5 => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'bizRule' => null,
        'data' => null
    ),
    6 => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Volunteer',
        'bizRule' => null,
        'data' => null
    ),
);
