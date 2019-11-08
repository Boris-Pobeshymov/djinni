<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedirectLinksRequest;
use Illuminate\Support\Facades\Auth;

use App\RedirectLinks;

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

}
