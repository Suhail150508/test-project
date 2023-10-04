<!-- ========== Left Sidebar Start ========== -->
@php
    $menu_list = App\Helpers\MenuHelper::Menu();
@endphp
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                @foreach($menu_list as $menu)
                    @php
                        $menu_element = App\Helpers\MenuHelper::MenuElement($menu);
                    @endphp
                    <li class="{{ (str_replace('-','_',Request::segment(2)) == explode('.',$menu->route_name)[0] && (str_replace('-','_',Request::segment(2)) != null))?'mm-active':''}}">
                        <a href="{{$menu_element['menu_link']}}" class="{{$menu_element['has_arrow']}} waves-effect">
                            <i class="{{$menu_element['menu_icon']}}"></i>
                            <span key="t-layouts">{{\App\Helpers\MenuHelper::menuName($menu)}}</span>
                        </a>
                        {{-------1st child-----start-------}}
                        @if(count($menu->children) > 0)
                            <ul class="sub-menu" aria-expanded="true">
                                @foreach($menu->children as $sub_menu)
                                    @php
                                        $menu_element = App\Helpers\MenuHelper::MenuElement($sub_menu);
                                    @endphp

                                    <li class="{{ (str_replace('-','_',Request::segment(2)) == explode('.',$sub_menu->route_name)[0] && (str_replace('-','_',Request::segment(2)) != null))?'mm-active':''}}">
                                        <a href="{{$menu_element['menu_link']}}" class="{{$menu_element['has_arrow']}} waves-effect" key="t-vertical"><i class="{{$menu_element['menu_icon']}}"></i>{{\App\Helpers\MenuHelper::menuName($sub_menu)}}</a>

                                        {{-------2nd child-----start-------}}
                                        @if(count($sub_menu->children) > 0)
                                            <ul class="sub-menu" aria-expanded="true">
                                                @foreach($sub_menu->children as $child_menu)
                                                    @php
                                                        $menu_element = App\Helpers\MenuHelper::MenuElement($child_menu);
                                                    @endphp
                                                    <li class="{{ (str_replace('-','_',Request::segment(2)) == explode('.',$child_menu->route_name)[0] && str_replace('-','_',Request::segment(2)) != null)?'mm-active':''}}">
                                                        <a href="{{$menu_element['menu_link']}}" key="t-vertical"><i class="{{$menu_element['menu_icon']}}"></i>{{\App\Helpers\MenuHelper::menuName($child_menu)}}</a>
                                                    </li>
                                                @endforeach

                                            </ul>
                                        @endif
                                        {{-------2nd child-----end-------}}

                                    </li>
                                @endforeach

                            </ul>
                        @endif
                        {{-------1st child-----end-------}}
                    </li>
                @endforeach

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!--  ========== Left Sidebar End ==========  -->
