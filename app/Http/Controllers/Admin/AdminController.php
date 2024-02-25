<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enum\Database\LevelAccessAdmin;
use Laravel\Jetstream\Contracts\DeletesTeams;
use App\Actions\Fortify\PasswordValidationRules;

class AdminController extends Controller
{
    use PasswordValidationRules;
    /**==========================================VIEWS=================================== */
    public function index(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Administrador')
            ->setLink('Lista');
        $administrators = Administrator::where('id', '!=', Auth::id())->paginate(10);
        return Inertia::render('Admin/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'administrators' => $administrators
        ]);
    }
    public function createView(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Administrador')
            ->setLink('Lista', route: route('admin.index'))
            ->setLink('Novo');
        return Inertia::render('Admin/Create', [
            'breadcrumb' => $breadcrumb->generate(),
            'level_access_admin' => LevelAccessAdmin::getArrayObject()
        ]);
    }
    public function editView(Administrator $administrator)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Administrador')
            ->setLink('Lista', route: route('admin.index'))
            ->setLink('Editar');
        return Inertia::render('Admin/Edit', [
            'breadcrumb' => $breadcrumb->generate(),
            'level_access_admin' => LevelAccessAdmin::getArrayObject(),
            'administrator' => $administrator
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:administrators'],
            'password' => $this->passwordRules(),
            'level_access' => ['required', Rule::enum(LevelAccessAdmin::class)],
        ], [], [
            'level_access' => 'nível de acesso',
        ]);
        try {
            DB::transaction(function () use ($request) {
                Administrator::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'level_access' => $request->level_access,
                    'email_verified_at' => now()
                ]);
                MessagesFactory::toast()
                    ->success('Registro criado com sucesso')
                    ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        } catch (\Error $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', Rule::unique('administrators', 'email')->ignore($request->id)],
            'password' => $this->passwordRulesExists(),
            'level_access' => ['required', Rule::enum(LevelAccessAdmin::class)],
        ], [], [
            'level_access' => 'nível de acesso',
        ]);
        try {
            DB::transaction(function () use ($request) {
                $id = $request->id;
                $toast = MessagesFactory::toast();
                Administrator::where('id', $id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'level_access' => $request->level_access,
                    'email_verified_at' => now()
                ]);
                if (!empty($request->password)) {
                    Administrator::where('id', $id)->update([
                        'password' => Hash::make($request->password),
                    ]);
                    $toast->success('Senha atualizada com sucesso');
                }
                $toast->success('Registro atualizado com sucesso')
                    ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        } catch (\Error $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function delete(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = Administrator::find($id);
                $user->deleteProfilePhoto();
                $user->tokens->each->delete();
                $user->delete();
                MessagesFactory::toast()->success("Registro deletado com sucesso")
                    ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        } catch (\Error $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
