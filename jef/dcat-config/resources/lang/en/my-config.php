<?php

return [
    'iframe' => [
        'title'         => 'Custom Configurations',
        'description'   => 'Mode',
        'error_body'    => 'Group not set, Please go to the plug-in page to configure the group first',
        'btn'           => 'Add'
    ],

    'fields' => [
        'name'          => 'Unique Key',
        'title'         => 'Title',
        'type'          => 'Data Type',
        'group'         => 'Group',
        'content'       => 'Content',
        'tip'           => 'Tip',
    ],

    'default_database' => [
        'basic_title'           => 'Site Name',
        'basic_tip'             => 'Please fill in the site name',
        'beian_title'           => 'Site Record No.',
        'beian_tip'             => 'Please fill in the site record number',
        'forbiddenip_title'     => 'Black List',
        'forbiddenip_tip'       => 'Each row records one piece of data',
        'configgroup_title'     => 'Config Group',
        'configgroup_tip'       => '',
        'configgroup_basic'     => 'Basic Config',
        'configgroup_dictionary' => 'Dictionary Config',
    ],

    'response' => [
        'success'   => 'Operation Succeeded',
        'error'     => 'Operation Failed , Please Contact The Developer',
    ],

    'type' => [
        'string'        => 'String',
        'number'        => 'Number',
        'mobile'        => 'Mobile',
        'url'           => 'URL',
        'email'         => 'Email',
        'color'         => 'Color',
        'date'          => 'Date',
        'time'          => 'Tile',
        'datetime'      => 'Datetime',
        'image'         => 'Image',
        'multipleImage' => 'MultipleImage',
        'file'          => 'File',
        'multipleFile'  => 'MultipleFile',
        'textarea'      => 'Textarea',
        'editor'        => 'Editor',
        'json'          => 'JSON',
    ]
];
