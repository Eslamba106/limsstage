<aside class="left-sidebar mt-3">
    <!-- Sidebar scroll-->
    <?php $user = auth()->guard('admins')->user();
    $lang = Session::get('locale');
    ?>
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <i class="fas fa-home"></i>
                        <span class="hide-menu">{{ translate('dashboard') }}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <i class="fa fa-users"></i>

                        <span class="hide-menu">{{ __('roles.tenant_management') }} </span>
                    </a>

                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.tenant_management') }}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">{{ __('roles.all_tenants') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.schema') }}" class="sidebar-link">
                        <i class="fas fa-project-diagram"></i>
                        <span class="hide-menu">{{ translate('Plans') }}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.conversation_requests') }}" class="sidebar-link">
                        <i class="fas fa-file-alt"></i> <span
                            class="hide-menu">{{ translate('conversation_requests') }}</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.logout') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-directions"></i>
                        <span class="hide-menu">{{ __('login.logout') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
