@php
    $tree = \Webkul\Core\Tree::create();

    foreach (config('core') as $item) {
        $tree->add($item);
    }
@endphp

<div class="fixed top-[57px] h-full bg-white pt-[8px] w-[270px] shadow-[0px_8px_10px_0px_rgba(0,_0,_0,_0.2)] z-[1000] max-lg:hidden transition-all duration-300 group-[.sidebar-collapsed]:w-[70px]">
    <div class="h-[calc(100vh-100px)] overflow-auto journal-scroll group-[.sidebar-collapsed]:overflow-visible">
        <nav class="grid gap-[7px] w-full">
            {{-- Navigation Menu --}}
            @foreach ($menu->items as $menuItem)
                <div class="relative px-[16px] group/item">
                    <a
                        href="{{ $menuItem['url'] }}"
                        class="flex gap-[10px] p-[6px] items-center cursor-pointer hover:rounded-[8px] {{ $menu->getActive($menuItem) == 'active' ? 'bg-blue-600 rounded-[8px]' : ' hover:bg-gray-100' }} peer"
                    >
                        <span class="{{ $menuItem['icon'] }} text-[24px] {{ $menu->getActive($menuItem) ? 'text-white' : ''}}"></span>
                        
                        <p class="text-gray-600 font-semibold whitespace-nowrap group-[.sidebar-collapsed]:hidden {{ $menu->getActive($menuItem) ? 'text-white' : ''}}">
                            @lang($menuItem['name']) 
                        </p>
                    </a>

                    @if (count($menuItem['children']))
                        <div class="{{ $menu->getActive($menuItem) ? ' !grid bg-gray-100' : '' }} hidden pl-[40px] pb-[7px] rounded-b-[8px] z-[100] group-[.sidebar-collapsed]:!hidden group-[.sidebar-collapsed]:absolute group-[.sidebar-collapsed]:top-0 group-[.sidebar-collapsed]:left-[70px] group-[.sidebar-collapsed]:p-[0] group-[.sidebar-collapsed]:bg-white group-[.sidebar-collapsed]:border-l-[1px] group-[.sidebar-collapsed]:border-gray-300 group-[.sidebar-collapsed]:rounded-none group-[.sidebar-collapsed]:shadow-[2px_1px_3px_rgba(0,0,0,0.1)] group-[.sidebar-collapsed]:group-hover/item:!grid">
                            @foreach ($menuItem['children'] as $subMenuItem)
                                <a
                                    href="{{ $subMenuItem['url'] }}"
                                    class="text-[14px] text-{{ $menu->getActive($subMenuItem) ? 'blue':'gray' }}-600 whitespace-nowrap py-[4px] group-[.sidebar-collapsed]:px-[20px] group-[.sidebar-collapsed]:py-[10px] hover:bg-gray-100"
                                >
                                    @lang($subMenuItem['name'])
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>
    </div>

    {{-- Collapse menu --}}
    <v-sidebar-collapse></v-sidebar-collapse>
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-sidebar-collapse-template">
        <div
            class="bg-white fixed w-full max-w-[270px] bottom-0 px-[16px] hover:bg-gray-100 border-t-[1px] border-gray-200 transition-all duration-300 cursor-pointer"
            :class="{'max-w-[70px]': isCollapsed}"
            @click="toggle"
        >
            <div class="flex gap-[10px] p-[6px] items-center">
                <span
                    class="icon-arrow-right text-[24px]"
                    :class="{'!icon-arrow-left': isCollapsed}"
                ></span>

                <p
                    class="text-gray-600 font-semibold transition-all duration-300 select-none"
                    :class="{'group-[.sidebar-collapsed]:invisible': isCollapsed}"
                    v-show="! isCollapsed"
                >
                    @lang('admin::app.components.layouts.sidebar.collapse')
                </p>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-sidebar-collapse', {
            template: '#v-sidebar-collapse-template',

            data() {
                return {
                    isCollapsed: {{ $_COOKIE['sidebar_collapsed'] ?? 0 }},
                }
            },

            methods: {
                toggle() {
                    this.isCollapsed = parseInt(this.isCollapsedCookie()) ? 0 : 1;

                    document.cookie = 'sidebar_collapsed=' + this.isCollapsed + '; path=/';

                    this.$root.$refs.appLayout.classList.toggle('sidebar-collapsed');
                },

                isCollapsedCookie() {
                    const cookies = document.cookie.split(';');

                    for (const cookie of cookies) {
                        const [name, value] = cookie.trim().split('=');

                        if (name === 'sidebar_collapsed') {
                            return value;
                        }
                    }

                    return 0;
                }
            }
        });
    </script>
@endpushOnce