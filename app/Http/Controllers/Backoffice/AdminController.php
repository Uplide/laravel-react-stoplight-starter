<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\AdminRequest;
use App\Http\Requests\Backoffice\AdminUpdateRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Modules\Filter\FilterService;
use App\Modules\Filter\FilterTableRequest;
use Illuminate\Support\Facades\Hash;

/**
 * @tags 😻 Dashboard > 2 > Admin
 */
class AdminController extends Controller
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
     * List Admin
     *
     * Bu servis yönetici listelemek için kullanılmaktadır. Pagianble bir şekilde listeler
     */
    public function index(FilterTableRequest $request)
    {
        $options = $request->all();
        if (!empty($options['group'])) {
            return response()->json(
                $this->filterService->getGroups($request, new Admin())
            );
        }

        $query = $this->filterService->getWhereFilter($options, new Admin());
        $totalCount = $query->count();
        $items = $query
            ->take($this->filterService->take)
            ->skip(($this->filterService->skip - 1) * $this->filterService->take)
            ->get(['id', 'name', "surname", "phone", "email", 'created_at']);

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
     * Get Admin
     *
     * Bu servis yönetici bilgilerini getirmek için kullanılmaktadır.
     *
     * @response AdminResource
     */
    public function get(Request $request)
    {
        $admin = Admin::where("id", intval($request->route("id")))->first();
        if (!@$admin->id) {
            return response()->json([
                'message' => 'Yönetici bulunamdı.',
            ], 404);
        }

        return new AdminResource($admin);
    }

    /**
     * Create Admin
     *
     * Bu servis yönetici oluşturmak için kullanılmaktadır.
     */
    public function store(AdminRequest $request)
    {
        $admin = Admin::create(
            [
                'name' => $request->name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'phone_code' => $request->phone_code,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );

        return response()->json([
            /**
             * @var string Mesaj
             * @example Yönetici oluşturuldu
             */
            'message' => 'Yönetici oluşturuldu.',

            /** @var AdminResource */
            'admin' => new AdminResource($admin)
        ], 201);
    }

    /**
     * Update Admin
     *
     * Bu servis yönetici düzenleme için kullanılmaktadır.
     */
    public function update(AdminUpdateRequest $request)
    {
        $admin = Admin::where("id", intval($request->route("id")))->first();
        if (!@$admin->id) {
            return response()->json([
                'message' => 'Yönetici bulunamdı!',
            ], 422);
        }

        Admin::where("id", $admin->id)->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'phone_code' => $request->phone_code,
            'email' => $request->email,
            'password' => @$request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return response()->json([
            'message' => 'Yönetici düzenlendi.',
        ], 201);
    }


    /**
     * Delete Admin
     *
     * Bu servis yönetici silmeye yarar.
     */
    public function delete(Request $request)
    {
        $admin = Admin::where("id", intval($request->route("id")))->first();
        if (!@$admin->id) {
            return response()->json([
                'message' => 'Yönetici bulunamdı.',
            ], 404);
        }

        Admin::destroy($admin->id);
        return response()->json([
            "message" => "Silme işlemi başarılı"
        ], 201);
    }
}
