<?php
namespace App\Helpers\FinalClass;

use App\Facade\MessagesFactory;
use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Models\Company;
use App\Models\OperatorCashier;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class AuthManager
{
    public function login(Request $request)
    {
        $user = null;
        if($request->isAdmin()){
            $user = $this->loginAdmin($request);
        }else if($request->isOperatorCashier()){
            $user = $this->loginGeneric($request, OperatorCashier::class);
        }else{
            $user = $this->loginGeneric($request, User::class);
        }
        return $user;
    }

    private function loginAdmin(Request $request)
    {
        $administrator = Administrator::where('email', $request->email)->first();

        if ($administrator && Hash::check($request->password, $administrator->password)) {
            return $administrator;
        }
    }
    private function loginGeneric(Request $request, string $model)
    {
        $user_orm = app($model);
        $user = $user_orm::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if($this->companyIsActive($user->company_id)){
                if($request->remember){
                    // cookies here
                }
                return $user;
            }else{
                MessagesFactory::alertSwal()->warning('Empresa não está mais ativa, por favor contate seu suporte!')->generate();
            }
        }
    }

    private function companyIsActive($company_id): bool
    {
        return (bool) Company::where('id', $company_id)->first()->active;
    }
}
