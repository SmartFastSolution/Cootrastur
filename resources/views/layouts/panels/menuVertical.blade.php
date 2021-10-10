@can($menu->can)
<li class="dropdown {{ ActiveAll($menu->submenu)}}">
    <a href="#{{ $menu->url}}" class="nav-link has-dropdown" aria-expanded="{{ expanded($menu->submenu) }}"><i data-feather="{{ $menu->icon }}"></i><span>{{ $menu->name }}
    </span></a>
    <ul class="dropdown-menu {{submenu($menu->submenu)}}" id="{{$menu->url}}">
       @foreach ($menu->submenu as $submenu)
           @if ($submenu->can)
               @can($submenu->can)
               <li class="{{active($submenu->url)}}">
                <a class="nav-link" href="{{ route($submenu->route)}}">{{$submenu->name}}</a>
               </li>
               @endcan                     
            @else
            <li class="{{active($submenu->url)}}">
                <a class="nav-link" href="{{ route($submenu->route)}}">{{$submenu->name}}</a>
               </li>  
           @endif
       @endforeach
    </ul>
 </li>   
@endcan