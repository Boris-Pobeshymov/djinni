<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedirectLinksRequest;
use Illuminate\Support\Facades\Auth;

use App\RedirectLinks;
use App\Statistic;

class RedirectLinksController extends Controller
{

    public function index()
    {
        return RedirectLinks::all();
    }

    public function store(RedirectLinksRequest $request)
    {
        $redirect = RedirectLinks::create($request->validated());
        return $redirect;
    }

    public function show(RedirectLinks $redirect)
    {
        return  RedirectLinks::findOrFail($redirect);
    }

    public function update(RedirectLinksRequest $request, $id)
    {
        $redirect = RedirectLinks::findOrFail($id);
        $redirect->fill($request->except(['id']));
        $redirect->save();
        return response()->json($redirect);
    }

    public function destroy(RedirectLinksRequest $request, $id)
    {
        $redirect = RedirectLinks::findOrFail($id);
        if($redirect->delete()) return response(null, 204);
    }

    public function checkRedirect(RedirectLinksRequest $request, $any){
        $redirect = RedirectLinks::where('slug', $any)
                                    ->where('status', 1)
                                    ->first();
        if($redirect){

            $ip = $request->ip();
            $position = \Stevebauman\Location\Facades\Location::get($ip);

            $statistic = new Statistic;

            $statistic->redirect_id = $redirect->id;
            $statistic->headers = json_encode($request->headers->all());
            $statistic->user_agent = $request->header('user-agent');
            $statistic->ip = $ip;
            if($position) {
                $statistic->country = $position->countryName;
                $statistic->region = $position->regionName;
                $statistic->city = $position->cityName;
            }
            $statistic->save();

            return redirect($redirect->old_slug);

        }else{
            abort(404);
        }
    }

    public function getStatistic(RedirectLinksRequest $request, $id){
        $all = Statistic::where('redirect_id', $id)->get();
        return response(count($all), 200);
    }

}
