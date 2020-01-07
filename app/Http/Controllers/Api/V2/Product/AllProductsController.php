<?php

namespace App\Http\Controllers\Api\V2\Product;

use Auth;
use App\User;
use App\Models\Team;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Order\Order;
use App\Http\Controllers\Controller;
use Facebook\WebDriver\Exception\NullPointerException;
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
        if ($this->isAdmin()) {
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
        return Order::collection(\App\Models\Order::paginate($this->getPerPage($request)));
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    protected function createUserCollection($request): AnonymousResourceCollection
    {
        if ($this->wantsAllFromTeam($request)) {
            $orders = collect();
            /** @var Team $team */
            $team = Auth::user()->teams()->firstOrFail();

            foreach ($team->users as $user) {
                foreach ($user->orders as $order) {
                    $orders->push($order);
                }
            }

            return Order::collection($orders);
        }

        return Order::collection(Auth::user()->orders);
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
}
