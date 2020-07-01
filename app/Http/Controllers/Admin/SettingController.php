<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $settins = [];

        $dbsettings = Setting::get();

        foreach($dbsettings as $dbsetting){
            $settings[ $dbsetting['name'] ] = $dbsetting['content'];
        }

        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }
        
    public function save(Request $request){
        $data = $request->only([
            'logo',
            'title',
            'subtitle',
            'email',
            'endereco',
            'telefone',
            'bgcolor',
            'colortitle',
            'colorsubtitle',
            'textcolor'
        ]);

        $validator = $this->validator($data);

        if($validator->fails()){
            //redireciona
            return redirect()->route('settings')
            ->withErrors($validator);
        }
        foreach($data as $item => $value){
            Setting::where('name', $item)->update([
                'content' => $value
            ]);
        }

            return redirect()->route('settings')
                ->with('warning', 'Informações alteradas com sucesso!!');

    }

    protected function validator($data){
        return FacadesValidator::make($data,[
            'logo' => ['string', 'max:100'],
            'title' => ['string', 'max:100'],
            'subtitle' => ['string', 'max:100'],
            'email' => ['string', 'email'],
            'endereco' => ['string', 'max:100'],
            'telefone' => ['string', 'max:100'],
            'bgcolor' => ['string', 'regex:/#[A-Z0-9]{6}/i'],
            'colortitle' => ['string', 'regex:/#[A-Z0-9]{6}/i'],
            'colorsubtitle' => ['string', 'regex:/#[A-Z0-9]{6}/i'],
            'textcolor' => ['string', 'regex:/#[A-Z0-9]{6}/i'],
        ]);
    }
}
