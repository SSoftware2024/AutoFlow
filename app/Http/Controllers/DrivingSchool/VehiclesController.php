<?php

namespace App\Http\Controllers\DrivingSchool;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Enum\Database\DrivingWallet;
use App\Http\Controllers\Controller;
use App\Models\DrivingSchool\Vehicles;
use Illuminate\Support\Facades\Auth;

class VehiclesController extends Controller
{
    /**==========================================VIEWS=================================== */
    public function viewCreate()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Veículos')
            ->setLink('Lista')
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/Vehicles/Create', [
            'breadcrumb' => $breadcrumb->generate(),
            'driving_wallet' => DrivingWallet::getArrayObjectSelect(),
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        $request->validate([
            'surname' => ['required','min:5'],
            'plate' => ['required'],
            'category' => ['required', Rule::enum(DrivingWallet::class)],
            'ipva_generate' => ['required', 'date'],
            'ipva_value' => ['required', 'numeric'],
        ],[],[
            'surname' => 'modelo carro',
            'plate' => 'placa',
            'ipva_generate' => 'IPVA data',
            'ipva_value' => 'IPVA valor',
        ]);
        try {
            DB::transaction(function () use ($request) {
                $data = $request->all();
                $data['plate'] = strtoupper($data['plate']);
                $user = Auth::user();
                Vehicles::create([
                    ...$data,
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
                ]);
                MessagesFactory::toast()->success('Operação concluída com sucesso')
                ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }catch (\Error $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    /**===================================METODOS ROUTES AXIOS=================================== */
    /**===================================METODOS VARIADOS=================================== */
}
