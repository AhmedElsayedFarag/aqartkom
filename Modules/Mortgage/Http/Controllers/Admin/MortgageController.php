<?php

namespace Modules\Mortgage\Http\Controllers\Admin;

use App\DataTransferObjects\MortgageExportDto;
use App\Exports\MortgagesExport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Mortgage\Entities\Mortgage;

class MortgageController extends Controller
{
    /**
     *
     * index , export , delete
     */
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $records = Mortgage::query()
            ->search(request()->get('search'))
            ->age(request()->get('age'))
            ->bank(request()->get('bank'))
            ->area(request()->get('area'))
            ->latest()
            ->paginate(10);
        return view('mortgage::index', compact('records'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Mortgage $mortgage)
    {
        $mortgage->delete();
        return success_delete('mortgage.delete');
    }
    public function export()
    {
        $dto = new MortgageExportDto(
            search: request()->get('search'),
            age: request()->get('age'),
            bank: request()->get('bank'),
            area: request()->get('area'),
        );
        return \Excel::download(new MortgagesExport($dto), 'التمويل العقاري-' . now()->format('Y-m-d') . '.xlsx');
    }
}
