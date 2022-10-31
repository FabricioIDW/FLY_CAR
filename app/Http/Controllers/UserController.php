<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExistingCustomer;
use App\Http\Requests\StoreNewCustomer;
use App\Http\Requests\StoreSeller;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.index')->only('indexAdmin');
        $this->middleware('can:usersSeller.create')->only(['create_seller', 'store_seller']);
    }

    public function actualizarCuenta()
    {
        return view('profile.actualizar-cuenta');
    }

    public function userList()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    public function userEdit(User $user)
    {
        return $user;
    }
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // CUSTOMER
    public function create_existing_customer()
    {
        return view('auth.create-existing-customer');
    }

    public function create_new_customer()
    {
        return view('auth.create-new-customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_new_customer(StoreNewCustomer $request)
    {
        $user = $this->createUser($request->email, $request->password, 'Customer');
        $customer = Customer::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'lastName' => $request->lastName,
            'birthDate' => $request->birthDate,
            'address' => $request->address,
            'email' => $request->email,
            'user_id' => $user->id,
        ]);
        Alert::success('La cuenta se creó correctamente.');
        return view('auth.login');
    }
    public function store_existing_customer(StoreExistingCustomer $request)
    {
        $user = $this->createUser($request->email, $request->password, 'Customer');
        $customer = Customer::where('dni', $request->dni)->first();
        $customer->user_id = $user->id;
        $customer->save();
        Alert::success('La cuenta se creó correctamente.');
        return view('auth.login');
    }
    // update customer
    public function update_customer(Request $request)
    {
        Auth::user()->customer->update([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'address' => $request->address,
            'birthDate' => $request->birthDate,
        ]);
        Alert::success('La cuenta se actualizó correctamente.');
        return  view('profile.actualizar-cuenta');
    }
    // SELLER
    public function create_seller()
    {
        return view('auth.create-seller-account');
    }
    public function store_seller(StoreSeller $request)
    {
        $user = $this->createUser($request->email, $request->password, 'Seller');
        $seller = Seller::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'lastName' => $request->lastName,
            'user_id' => $user->id,
        ]);
        Alert::success('La cuenta del vendedor ' . $request->name . ' ' . $request->lastName . ' se creó correctamente');
        return view('auth.create-seller-account');
    }

    public function update_seller(Request $request)
    {
        Auth::user()->seller->update([
            'name' => $request->name,
            'lastName' => $request->lastName,
        
        ]);
        Alert::success('La cuenta se actualizó correctamente.');
        return  view('profile.actualizar-cuenta');
    }

    private function createUser($email, $password, $role)
    {
        return User::create([
            'email' => $email,
            'password' => bcrypt($password),
        ])->assignRole($role);
    }

    public function indexAdmin()
    {
        return view('indexAdmin');
    }
}
