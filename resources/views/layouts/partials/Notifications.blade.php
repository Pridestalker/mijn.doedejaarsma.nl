@if(\Auth::user()->unreadNotifications()->exists())
    <notifications-view></notifications-view>
{{--    <li class="nav-item dropdown">--}}
{{--        <a class="nav-link dropdown-toggle" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre href="#">--}}
{{--            <i class="fas fa-bell text-primary"></i>--}}
{{--        </a>--}}

{{--        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">--}}
{{--            @foreach (\Auth::user()->unreadNotifications as $notification)--}}
{{--                <span class="dropdown-item d-flex align-items-center">--}}
{{--                    <a href="{{ route('products.show', \App\Models\Product::find($notification->data['id'])) }}">--}}
{{--                        {{ \App\Models\Product::find($notification->data['id'])->name }}--}}
{{--                    </a>--}}
{{--                    <a href="{{ route( 'user.remove.notification', [\Auth::user()->id, $notification->id]) }}" class="ml-auto">--}}
{{--                        <i class="fas fa-times"></i>--}}
{{--                    </a>--}}
{{--                </span>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </li>--}}
@endif


