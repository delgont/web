<?php

return [

     /*
    |--------------------------------------------------------------------------
    | Default Menus
    |--------------------------------------------------------------------------
    */
    'menus' => [
        'main_menu' => 'main menu',
        'footer_menu' => 'footer menu',
        'top_bar_menu' => 'top bar menu',
        'your_menu_key' => 'Your Menu Name'
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Menu Items
    | For the post key use the post titles for your default posts in the data configuration file
    |--------------------------------------------------------------------------
    */
    'main_menu' => [
        ['label' => 'Home', 'sort' => '1', 'post' => 'home'],
        ['label' => 'About Us', 'sort' => '2', 'post' => 'About Us'],
        ['label' => 'services', 'sort' => '3', 'post' => 'services'],
        ['label' => 'web development', 'sort' => '3', 'post' => 'web development', 'parent' => 'services'],
        ['label' => 'web hosting', 'sort' => '3', 'post' => 'web hosting', 'parent' => 'services'],
        ['label' => 'computer networking', 'sort' => '3', 'post' => 'computer cabling', 'parent' => 'services'],
        ['label' => 'blog', 'sort' => '4', 'post' => 'blog'],
        ['label' => 'contact us', 'sort' => '4', 'post' => 'contact us']
    ],

    'footer_menu' => [
        ['label' => 'Home', 'sort' => '1', 'post' => 'home'],
        ['label' => 'About Us', 'sort' => '2', 'post' => 'About Us'],
        ['label' => 'services', 'sort' => '3', 'post' => 'services'],
        ['label' => 'blog', 'sort' => '4', 'post' => 'blog'],
        ['label' => 'privacy policy', 'sort' => '4', 'post' => 'privacy policy']
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Page Keys
    |--------------------------------------------------------------------------
    | Each page must have a unique key eg home, about-us, services, contact-us
    | These page keys may used as labels on the navigation menu, but can be edited later
    */
    'pages' => [
        'home' => null,
        'about-us' => ['who we are','another page'],
        'services' => null,
        'blog' => null,
        'contact-us' => null
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Post types
    |--------------------------------------------------------------------------
    | Even though posts may be categorized futher, each post must belong to a specific type
    | Post types can also be entered manually via the cms keeping in mind that they must belong to specific pages or categories
    */
    'post_types' => [
        'blog post', 'service', 'team member'
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Categories -- used to categorise posts and any model that uses the Categorable trait
    |--------------------------------------------------------------------------
    */
    'categories' => [
        'laravel', 'php', 'web development', 'web hosting'
    ],

    'options' => [
        'option_key' => 'default-value-here'
    ],

   
    /**
     * Extend the links in the UI 
     */
    'sidebar_extension' => [
        'web::dashboard.sidebar.links',
        'dashboard.sidebar.links'
    ],

    /*
    |--------------------------------------------------------------------------
    | Your navbar view file - used to provide navbar items
    |--------------------------------------------------------------------------
    */
    'navbar' => 'web.includes.navbar',

    'templates' => [
        'web.templates.contact-us' => ['name' => 'Contact Us', 'preview' => 'img/templates/default.jpg'],
        'web.templates.default-page' => ['name' => 'Default Page', 'preview' => 'img/templates/default.jpg'],
        'web.templates.events-page' => ['name' => 'Events page', 'preview' => 'img/templates/default.jpg']
    ],

];