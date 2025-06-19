<?php

return [
    "name"=> "Ecomm",
    "title"=> "Ecomm",
    "slug"=> "ecomm",
    "thumbnail"=> "https://img.site/p/300/160",
    "is_dev" => env('MODULE_ECOMM_ENV')?true:false,
    "excerpt"=> "Product Buying system",
    "description"=> "Product Buying system",
    "download_link"=> "",
    "author_name"=> "Kartik",
    "author_website"=> "https://vaah.dev",
    "version"=> "0.0.1",
    "is_migratable"=> true,
    "is_sample_data_available"=> false,
    "db_table_prefix"=> "vh_ecomm_",
    "providers"=> [
        "\\VaahCms\\Modules\\Ecomm\\Providers\\EcommServiceProvider"
    ],
    "aside-menu-order"=> null
];
