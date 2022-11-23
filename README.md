
```php
composer require delgont/web
```


### Navigation Menu

##### Configuration

<small style="color:green;"><b>Note</b></small>
<ol>
    <li><i>Make sure your default pages | posts are set in the `config/data` configuration file for easy pupolation of menu items.</i></li>
    <li>Also make sure your navigation blade is located at `views/web/includes/navbar` or you can specify the blade that holds the navigation menu by seting the `navbar` option in the `config/web` configuration file.</li>
</ol>

```php
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
```

```php
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">Janont</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if ($mainMenuItems)
                    @if (count($mainMenuItems->navbarMenuItems))
                        @foreach ($mainMenuItems->navbarMenuItems as $item)
                            @if (count($item->children) > 0)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $item->label }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @foreach ($item->children as $child)
                                            <li><a class="dropdown-item" href="{{ url(($child->menuable->slug) ?? '/') }}">{{ $child->label }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link text-capitalize" aria-current="page" href="{{ url(($item->menuable->slug) ?? '/') }}">{{ $item->label }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endif           
            </ul>
            <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
      </div>
    </div>
  </nav>
```


## Posts

Posts is the primary way of storing web page content for your content delivery application.

```php
Route::get('{slug}', 'WebController@index')->where('slug', '([A-Za-z0-9\-\/]+)')->name('web.page');
```


```php
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Web\Http\Controllers\Controller;

class WebController extends Controller{}
```

### Page Sections


When constructing content delivery application, pages may have sections with specific data. The data may be content of specify post type or post category.

Blade sections that hold data of specific type by default should be stored in `web\sections\oftype` directory in your the views directory.  However you are free to organize them the way you wish. Blade sections that hold data of specific category are placed in `web\sections\ofcategory` .

#### Using View Composers to avail data of specify type to your sections

1. Create composer for specific type of posts

```php
namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Web\Concerns\OfType;

class ServicesComposer
{
    use OfType;

    public function compose(View $view)
    {
        $view->with('services', $this->getPostsOfType('service'));
    }
}
```

2. Create `ViewSeriveProvider` to hold your `ViewComposers`

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['web.sections.oftype.services', 'web.sections.oftype.services-dark'],
            'App\Http\View\Composers\ServicesComposer'
        );

    }
}
```

3. Your blade  section

```php
<section class="container-xxl py-5 services-section">
    <div class="container">
        <div class="row">
            @if (count($services))
                @foreach ($services as $service)
                    <div class="col-lg-4 service-item">
                        <img src="{{ asset($service->post_featured_image) }}" alt="" class="img-fluid" />
                        <div class="py-2 px-1">
                            <h3>{{ $service->post_title }}</h3>
                            <div>{{ str_limit($service->extract_text, 150) }}</div>
                            <div class="row author py-3">
                                @if ($service->author)
                                    <div class="col-lg-2"><img src="{{ asset($service->author->avator->url) }}" alt="" class="img-fluid rounded-circle"></div>
                                    <div class="col-lg-10 pt-1">{{ $service->author->name }}</div>
                                @endif
                            </div>
                            <div class="readmore">
                                <a href="{{ ($service->slug) ? url($service->slug) : '#' }}" class="btn btn-md btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
```

####Using View Composers to avail data of specify post category to your sections



---

#### Quick Commands

Use these commands to refresh your application during theme development.

1. Install Delgont `php artisan delgont:install --fresh`
2. Install Delgont Web `php artisan web:install --fresh`
3. Migrate Your DB `php artisan migrate:fresh`
4. Create Default User `php artisan delgont:user --create --default`
5. Populate Post Types `php artisan posttype:sync`
7. Populate Categories `php artisan category:sync`
7. Populate Categories `php artisan template:sync`
6. Populate Your Page Content `php artisan page:sync`
5. Populate Menus For Navigation Menu `php artisan menu:sync`
5. Populate Menus For Navigation MenuItems `php artisan menuitem:sync`