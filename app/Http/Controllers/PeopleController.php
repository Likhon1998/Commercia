<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PeopleController extends Controller
{
    // INDEX with search and pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = People::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('bin_number', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        $people = $query->latest()->paginate(10)->withQueryString();

        return view('people.index', compact('people'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('people.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:people,email',
            'person_type' => 'required|array',
            'person_type.*' => 'in:customer,supplier,employee,other',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'bin_number' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name', 'email', 'phone', 'address', 'country', 'city', 'bin_number', 'status'
        ]);

        $data['person_type'] = json_encode($request->person_type);

        if (in_array('employee', $request->person_type)) {
            $request->validate([
                'user_email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'role' => 'required|exists:roles,name',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->user_email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);

            $data['user_id'] = $user->id;
        }

        People::create($data);

        return redirect()->route('people.index')->with('success', 'Person added successfully.');
    }

    public function edit(People $person)
    {
        $roles = Role::all();

        $person->person_type = is_array($person->person_type)
            ? $person->person_type
            : json_decode($person->person_type, true) ?? [];

        $user = $person->user;
        $selectedRole = $user ? $user->getRoleNames()->first() : null;

        return view('people.edit', compact('person', 'roles', 'user', 'selectedRole'));
    }

    public function update(Request $request, People $person)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'bin_number' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'person_type' => 'nullable|array',
            'user_email' => 'nullable|email',
            'password' => 'nullable|confirmed|min:6',
            'role' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $person->name = $data['name'];
        $person->phone = $data['phone'] ?? null;
        $person->email = $data['email'] ?? null;
        $person->bin_number = $data['bin_number'] ?? null;
        $person->city = $data['city'] ?? null;
        $person->country = $data['country'] ?? null;
        $person->address = $data['address'] ?? null;
        $person->status = $request->has('status') ? true : false;
        $person->person_type = json_encode($data['person_type'] ?? []);
        $person->save();

        if (in_array('employee', $data['person_type'] ?? [])) {
            $user = $person->user;

            if (!$user) {
                $user = new User();
                $user->name = $person->name;
                $user->email = $data['user_email'];
                $user->password = bcrypt('defaultpassword'); // You can adjust this logic
                $user->save();

                $person->user_id = $user->id;
                $person->save();
            } else {
                if ($data['user_email'] && $data['user_email'] !== $user->email) {
                    $user->email = $data['user_email'];
                }
            }

            if (!empty($data['password'])) {
                $user->password = bcrypt($data['password']);
            }

            $user->save();

            if ($data['role']) {
                $user->syncRoles([$data['role']]);
            }
        } else {
            // Optional: unlink user if employee removed
            // $person->user()->dissociate();
            // $person->save();
        }

        return redirect()->route('people.index')->with('success', 'Person updated successfully.');
    }

    public function destroy(People $person)
    {
        if ($person->user_id) {
            $user = User::find($person->user_id);
            if ($user) {
                $user->delete();
            }
        }

        $person->delete();

        return redirect()->back()->with('success', 'Person deleted successfully.');
    }
}
