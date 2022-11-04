<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExistingCustomer;
use App\Http\Requests\StoreNewCustomer;
use App\Http\Requests\StoreSeller;
use App\Http\Requests\UpdateCustomer;
use App\Http\Requests\UpdateSeller;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.index')->only('indexAdmin');
        $this->middleware('can:cuenta.actualizar')->only('actualizarCuenta');
        $this->middleware('can:usersCustomer.update')->only('update_customer');
        $this->middleware('can:usersSeller.create')->only('create_seller');
        $this->middleware('can:usersSeller.store')->only('store_seller');
        $this->middleware('can:usersSeller.update')->only('update_seller');
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

// ADMIN
    public function update_admin(Request $request)
    {
        // Validar contraseña actual del usuario con la contraseña actual ingresada en el formulario.
        $result_current_password = Hash::check($request->current_password, Auth::user()->password);
        $new_password_hash = Hash::make($request->new_password);
        $result_new_password =  Hash::check($request->new_password_confirmation, $new_password_hash);
        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail)
                {
                    if (Hash::check($value, Auth::user()->password)) {
                        $fail('La contraseña actual ingresada no coincide.');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return redirect('cuenta')
            ->withErrors($validator);
        }
        $validator->validate();
        return $result_new_password;
    }

    // CUSTOMER
    public function create_existing_customer()
    {
        return view('auth.create-existing-customer');
    }

    public function create_new_customer()
    {
        return view('auth.create-new-customer');
    }

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
        return view('auth.login', ['newEmail' => $request->email]);
    }
    public function store_existing_customer(StoreExistingCustomer $request)
    {
        $user = $this->createUser($request->email, $request->password, 'Customer');
        $customer = Customer::where('dni', $request->dni)->first();
        $customer->user_id = $user->id;
        $customer->save();
        Alert::success('La cuenta se creó correctamente.');
        return view('auth.login', ['newEmail' => $request->email]);
    }
    // update customer
    public function update_customer(UpdateCustomer $request)
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

    public function update_seller(UpdateSeller $request)
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
