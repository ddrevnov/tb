<?php

namespace App\Http\Controllers\Director;

use App\Tarif;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Gate;

class DirectorTariffsController extends DirectorController
{
    //вывод всех тарифов
    public function tariffs() 
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }
        $this->data['tariffs'] = Tarif::select('id', 'name', 'created_at', 'price', 'status')
                                        ->orderBy('created_at', 'desc')->paginate(15);

        return view('director.tariffs', $this->data);
    }

    //страница создания нового тарифа
    public function createTariff()
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }
        return view('director.tariff_create', $this->data);
    }

    //сохранение или редактирование тарифа
    public function storeTariff(Requests\StoreTariff $request)
    {
        //если отсутствует input price, значит был выбран беспатный тариф, для него необходимо ставить price = 0
        if(!isset($request->price)){
            $request['price'] = 0;
        }

        //редактирование существующего тарифа
        if($request->has('tariff_id')){
            Tarif::find($request->tariff_id)->update($request->all());
            return redirect()->route('tariffs');
        }

        Tarif::create($request->all());
        return redirect()->route('tariffs');
    }
    
    //страница редактирования тарифа
    public function editTariff(Request $request)
    {
        $this->data['tariff_edit'] = Tarif::find($request->id);
        return view('director.tariff_create', $this->data);
    }

    //удаление тарифа
    public function removeTariff(Request $request)
    {
        Tarif::find($request->id)->delete();
        return redirect()->route('tariffs');
    }
}
