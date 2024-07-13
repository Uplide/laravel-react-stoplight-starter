<?php


namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\CompanyRequest;
use App\Http\Requests\Backoffice\CompanyUpdateRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Modules\Filter\FilterService;
use App\Modules\Filter\FilterTableRequest;

/**
 * @tags 😻 Dashboard > 3 > Companies
 */
class CompanyController extends Controller
{
    protected $filterService;

    public function __construct(FilterService $filterService, Request $request)
    {
        $this->filterService = $filterService;
        if (@$request->skip) {
            $this->filterService->skip = intval($request->skip);
        }

        if (@$request->take) {
            $this->filterService->take = intval($request->take);
        }
    }

    /**
     * List Companies
     *
     * Bu servis şirketleri listelemek için kullanılmaktadır. Pagianble bir şekilde listeler
     */
    public function index(FilterTableRequest $request)
    {
        $options = $request->all();
        if (!empty($options['group'])) {
            return response()->json(
                $this->filterService->getGroups($request, new Company())
            );
        }

        $query = $this->filterService->getWhereFilter($options, new Company());
        $totalCount = $query->count();
        $items = $query
            ->take($this->filterService->take)
            ->skip(($this->filterService->skip - 1) * $this->filterService->take)
            ->get(['id', 'name', 'logo', 'email', 'phone', 'address', 'description', 'created_at']);

        return response()->json([
            'items' => $items,
            'meta' => [
                'totalItems' => $totalCount,
                'itemCount' => $items->count(),
                'itemsPerPage' => (int) $this->filterService->take,
                'totalPages' => ceil($totalCount / (int) $this->filterService->take),
                'currentPage' => (int) $this->filterService->skip,
            ],
        ]);
    }

    /**
     * Get Company
     *
     * Bu servis şirket bilgilerini getirmek için kullanılmaktadır.
     */
    public function show(Request $request, $id)
    {
        $company = Company::where("id", intval($id))->first();
        if (!@$company->id) {
            return response()->json([
                'message' => 'Şirket bulunamadı.',
            ], 404);
        }

        return response()->json($company, 200);
    }

    /**
     * Create Company
     *
     * Bu servis şirket oluşturmak için kullanılmaktadır.
     */
    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->all());

        return response()->json([
            'message' => 'Şirket oluşturuldu.',
            'company' => $company
        ], 201);
    }

    /**
     * Update Company
     *
     * Bu servis şirketi düzenlemek için kullanılmaktadır.
     */
    public function update(CompanyUpdateRequest $request, $id)
    {
        $company = Company::where("id", intval($id))->first();
        if (!@$company->id) {
            return response()->json([
                'message' => 'Şirket bulunamadı!',
            ], 422);
        }

        $company->update($request->all());

        return response()->json([
            'message' => 'Şirket düzenlendi.',
            'company' => $company
        ], 200);
    }

    /**
     * Delete Company
     *
     * Bu servis şirketi silmek için kullanılmaktadır.
     */
    public function destroy(Request $request, $id)
    {
        $company = Company::where("id", intval($id))->first();
        if (!@$company->id) {
            return response()->json([
                'message' => 'Şirket bulunamadı.',
            ], 404);
        }

        $company->delete();

        return response()->json([
            "message" => "Silme işlemi başarılı"
        ], 200);
    }
}
