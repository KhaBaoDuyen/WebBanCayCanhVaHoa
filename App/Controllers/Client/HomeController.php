<?php

namespace App\Controllers\Client;

use App\Helpers\NotificationHelper;
use App\Views\Client\Components\Notification;
use App\Views\Client\Components\Search;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Home;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Views\Client\Contact;
use App\Views\Client\Pages\Blogs\Instruction;
use App\Views\Client\About;
use App\Views\Client\Layouts\Header;

class HomeController
{
    // hiển thị danh sách
    public static function index()
    {
        $product = new ProductModel();
        $data['products'] = $product->getAllProduct();

        $categogy = new CategoryModel();
        $data['categogy'] = $categogy->getAllProductByStatus();
        // Notification::render();
        // NotificationHelper::unset();
        Header::render();
        Home::render($data);
        Footer::render();
    }
    public static function contact()
    {
        Header::render();
        Contact::render();
        Footer::render();
    }
    public static function instruction()
    {
        Header::render();
        Instruction::render();
        Footer::render();
    }
    public static function about()
    {
        Header::render();
        About::render();
        Footer::render();
    }
    public static function Search()
    {
        $keyword = $_GET['keyword'] ?? '';
       $products = ProductModel::searchByKeyword($keyword);
        Header::render();
        Search::render(['keyword' => $keyword, 'products' => $products]);
        Footer::render();
    }


}
