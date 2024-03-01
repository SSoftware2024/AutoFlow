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
use App\Facade\MoneyConvert;
use App\Http\Controllers\Controller;
use App\Models\DrivingSchool\Vehicles;
use Illuminate\Support\Facades\Auth;

class VehiclesController extends Controller
{
    /**==========================================VIEWS=================================== */
    public function index()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Veículos')
            ->setLink('Lista');
        $vehicles = Vehicles::where('company_id', Auth::user()->company_id)->paginate(10);

        $vehicles->getCollection()->transform(function ($value) {
            $value->ipva_value = MoneyConvert::getDbMoney($value->ipva_value);
            $value->ipva_generate = date('d/m/Y',strtotime($value->ipva_generate));
            return $value;
        });
        return Inertia::render('DrivingSchool/Vehicles/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'vehicles' => $vehicles
        ]);
    }
    public function viewCreate()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Veículos')
            ->setLink('Lista', route: route('user.driving_school.vehicles.index'))
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
            'ipva_generate' => ['required', 'date','after_or_equal:today'], //validar para data ser maior ou igual a hoje
            'ipva_value' => ['required', 'numeric'],
        ],[
            'after_or_equal' => "O campo :attribute deve ser uma data posterior ou igual a ".date('d/m/Y')
        ],[
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
