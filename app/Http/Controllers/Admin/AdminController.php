<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

use App\Models\Admin\Admin;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\Order;

class AdminController extends Controller
{
    //login
    public function login()
    {
        return view('admin.login');
    }

    //loginProcess
    public function loginProcess(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }


    // dashboard
    public function dashboard()
    {
        $categoriesCount = Category::select()->count();
        $productsCount = Product::select()->count();
        $ordersCount = Order::select()->count();
        $adminsCount = Admin::select()->count();

        return view('admin.index', compact('categoriesCount', 'productsCount', 'ordersCount', 'adminsCount'));
    }


    //allAdmins
    public function allAdmins()
    {
        $allAdmins = Admin::select()->orderBy('id', 'desc')->get();

        return view('admin.alladmins', compact('allAdmins'));
    }

    //createAdmins
    public function createAdmins()
    {
        return view('admin.createadmins');
    }

    //storeAdmins
    public function storeAdmins(Request $request)
    {

        $storeAdmins = Admin::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        if ($storeAdmins) {
            return Redirect::route('all.admins')->with(['success' => 'Admin created successfully']);
        }
    }


    //deleteAdmins
    // public function deleteAdmins($id)
    // {
    //     $deleteAdmins = Admin::find($id);
    //     $deleteAdmins->delete();
    //     if ($deleteAdmins) {
    //         return Redirect::route('all.admins')->with(['delete' => 'Admin deleted successfully']);
    //     }
    // }



    //displayAllCategories
    public function displayAllCategories()
    {
        $categories = Category::select()->orderBy('id', 'desc')->get();
        return view('admin.allcategories', compact('categories'));
    }

    //createCategories
    public function createCategories()
    {
        return view('admin.createcategories');
    }

    //storeCategories
    public function storeCategories(Request $request)
    {

        // Request()->validate([
        //     'name' => 'required|max:255',
        //     'description' => 'required',
        //     'image' => 'required | image | max: 2048',
        //     'icon' => 'required | image | max: 2048',
        // ]);

        $destinationPath = 'assets/img/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $categories = Category::create([
            "name" => $request->name,
            "description" => $request->description,
            "image" => $myimage,
            "icon" => $request->icon
        ]);
        if ($categories) {
            return Redirect::route('all.categories')->with(['success' => 'Category created successfully']);
        }
    }


    //editCategories
    public function editCategories($id)
    {
        $category = Category::find($id);
        return view('admin.editcategories', compact('category'));
    }

    //updateCategories
    public function updateCategories(Request $request, $id)
    {
        $updateCategories = Category::find($id);
        $updateCategories->update($request->all());
        if ($updateCategories) {
            return Redirect::route('all.categories')->with(['update' => 'Category updated successfully']);
        }
    }

    //deleteCategories
    public function deleteCategories($id)
    {
        $deleteCategories = Category::find($id);
        if (File::exists(public_path('assets/img/' . $deleteCategories->image))) {
            File::delete(public_path('assets/img/' . $deleteCategories->image));
        } else {
            //dd('File does not exists.');
        }
        $deleteCategories->delete();
        if ($deleteCategories) {
            return Redirect::route('all.categories')->with(['delete' => 'Category deleted successfully']);
        }
    }


    //displayAllProducts
    public function displayAllProducts()
    {
        $products = Product::select()->orderBy('id', 'desc')->get();
        return view('admin.allproducts', compact('products'));
    }

    //createProducts
    public function createProducts()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.createproducts', compact('categories', 'products'));
    }

    //storeProducts
    public function storeProducts(Request $request)
    {


        $destinationPath = 'assets/img/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);


        $storeProducts = Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "image" => $myimage,
            "exp_date" => $request->exp_date,
            "category_id" => $request->category_id,

        ]);
        if ($storeProducts) {
            return Redirect::route('all.products')->with(['success' => 'Product created successfully']);
        }
    }


    //deleteProducts
    public function deleteProducts($id)
    {
        $deleteProducts = Product::find($id);

        if (File::exists(public_path('assets/img/' . $deleteProducts->image))) {
            File::delete(public_path('assets/img/' . $deleteProducts->image));
        } else {
            //dd('File does not exists.');
        }

        $deleteProducts->delete();
        if ($deleteProducts) {
            return Redirect::route('all.products')->with(['delete' => 'Product deleted successfully']);
        }
    }



    //displayAllOrders
    public function displayAllOrders()
    {
        $allOrders = Order::select()->orderBy('id', 'desc')->get();

        return view('admin.allorders', compact('allOrders'));
    }

    //editOrder
    public function editOrders($id)
    {
        $editOrder = Order::find($id);

        return view('admin.editorders', compact('editOrder'));
    }
    //updateOrders
    public function updateOrders(Request $request, $id)
    {
        $order = Order::find($id);

        $order->update($request->all());

        if ($order) {

            return redirect::route('all.orders')->with(['update' => 'Order status updated successfully']);
        }
    }

    //deleteOrders
    public function deleteOrders($id)
    {
        $deleteOrder = Order::find($id);
        $deleteOrder->delete();
        return redirect::route('all.orders')->with(['delete' => 'Order deleted successfully']);
    }



    //allCities
    public function allCities()
    {
        $cities = City::select()->orderBy('id', 'desc')->get();
        return view('admins.allcities', compact('cities'));
    }

    //createCities
    public function createCities(Request $request)
    {
        $cities = City::all();
        $countries = Country::all();
        return view('admins.createcities', compact('cities', 'countries'));
    }


    //storeCities
    public function storeCities(Request $request)
    {
        Request()->validate([
            'name' => 'required|max:255',
            'image' => 'required | image | max: 2048',
            'num_days' => 'required',
            'price' => 'required',
            'country_id' => 'required',
        ]);

        $destinationPath = 'assets/images/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $storeCities = City::create([
            "name" => $request->name,
            "image" => $myimage,
            "num_days" => $request->num_days,
            "price" => $request->price,
            "country_id" => $request->country_id,
        ]);
        if ($storeCities) {
            return Redirect::route('admin.all.cities')->with(['success' => 'City created successfully']);
        }
    }

    //deleteCities
    public function deleteCities($id)
    {
        $deleteCities = City::find($id);
        if (File::exists(public_path('assets/images/' . $deleteCities->image))) {
            File::delete(public_path('assets/images/' . $deleteCities->image));
        } else {
            //dd('File does not exists.');
        }
        $deleteCities->delete();
        if ($deleteCities) {
            return Redirect::route('admin.all.cities')->with(['delete' => 'City deleted successfully']);
        }
    }
}
