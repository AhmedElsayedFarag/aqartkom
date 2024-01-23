<?php

namespace Modules\Transaction\Http\Controllers\Admin;

use App\Exports\TransactionsExport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Modules\Transaction\Entities\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // dd(request()->all());
        //filter by name , phone , date , status
        $transactions = Transaction::query()
            ->search(request()->get('search'))
            ->statusFilter(request()->get('status'))
            ->dateRange(request()->get('date'))
            ->latest()
            ->paginate(15);
        return view('transaction::index', \compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transaction::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('transaction::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('transaction::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    public function exportExcel()
    {
        return (new TransactionsExport(
            request()->get('search'),
            request()->get('status'),
            request()->get('date'),
        ))->download('transactions_' . now()->toDateString() . '.xlsx');
    }


    public function getPackageBills(){
        $transactions = Transaction::query()
            ->search(request()->get('search'))
            ->statusFilter(request()->get('status'))
            ->dateRange(request()->get('date'))
            ->latest()
            ->paginate(15);
        return view('transaction::package_bills', compact('transactions'));
    }
    public function showPackageBills($id){
        return view('transaction::package_bills_show', [
            'transaction'=> Transaction::findOrFail($id)
        ]);
    }
    public function editPackageBills($id){
        return view('transaction::package_bills_edit', [
            'transaction'=> Transaction::findOrFail($id)
        ]);
    }
    public function updatePackageBills($id,Request $request){}
}
