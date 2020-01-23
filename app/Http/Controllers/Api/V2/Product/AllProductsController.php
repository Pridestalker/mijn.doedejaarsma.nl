<?php

namespace App\Http\Controllers\Api\V2\Product;

use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Order\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AllProductsController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        if ($this->isAdmin() || $this->isDesigner()) {
            $orders = $this->createAdminCollection($request);
        } else {
            $orders = $this->createUserCollection($request);
        }

        return $orders;
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    protected function createAdminCollection($request): AnonymousResourceCollection
    {
        $orders = \App\Models\Order::query();

        /** @noinspection StaticInvocationViaThisInspection */
        $orders->whereIn('status', $this->getAllStatus($request));

        if ($this->wantsOrderBy($request, 'deadline')) {
            $orders->orderByDesc('deadline');
        }

        if ($this->wantsOrderBy($request, 'name')) {
            $orders->orderByDesc('name');
        }

        if ($this->wantsOrderBy($request, 'status')) {
            $orders->orderByDesc('status');
        }

        return Order::collection($orders->paginate($this->getPerPage($request)));
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    protected function createUserCollection($request): AnonymousResourceCollection
    {
        $orders = \App\Models\Order::query();

        if ($this->wantsAllFromTeam($request)) {
            /** @noinspection StaticInvocationViaThisInspection */
            $orders->whereIn('user_id', Auth::user()->bedrijf->first()->users()->pluck('id')->toArray());
        } else {
            $orders->where('user_id', '=', Auth::user()->id);
        }

        /** @noinspection StaticInvocationViaThisInspection */
        $orders->whereIn('status', $this->getAllStatus($request));

        if ($this->wantsOrderBy($request, 'deadline')) {
            $orders->orderByDesc('deadline');
        }

        if ($this->wantsOrderBy($request, 'name')) {
            $orders->orderByDesc('name');
        }

        if ($this->wantsOrderBy($request, 'status')) {
            $orders->orderByDesc('status');
        }

        return Order::collection($orders->paginate($this->getPerPage($request)));
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function wantsAllFromTeam($request): bool
    {
        return $request->input('team') === 'true';
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function isAdmin(): bool
    {
        if (null === Auth::user() || !Auth::user()) {
            throw new \Exception('User not logged in.');
        }

        return Auth::user()->isAn('admin');
    }


    private function isDesigner(): bool
    {
        if (null === Auth::user() || !Auth::user()) {
            throw new \Exception('User not logged in.');
        }

        return Auth::user()->isA('designer');
    }

    /**
     * Gets the per page parameter from the request or 15.
     *
     * @param Request $request
     *
     * @return int
     */
    private function getPerPage(Request $request): int
    {
        if ($per_page = $request->input('per_page')) {
            return (int) $per_page;
        }

        return 15;
    }

    private function getAllStatus(Request $request)
    {
        return $request->input('status');
    }

    /**
     * @param Request $request
     * @param String $field
     * @return bool
     */
    private function wantsOrderBy(Request $request, $field)
    {
        return $request->has('ordered') && $request->input('ordered') === $field;
    }

    private function isSearching(Request $request)
    {
        return $request->has('name');
    }
}
