<aside class="left-sidebar mt-3">
    <!-- Sidebar scroll-->
    <?php
    $lang = Session::get('locale');
    ?>
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">


                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{ route('scan_page') }}" aria-expanded="false">
                        <i class="fa fa-barcode"></i>

                        <span class="hide-menu">{{ translate('scan_Barcode') }} </span>
                    </a>
                </li>
                @if (\App\helper\Helpers::module_check('test_method_management'))


                    @can('test_method_management')
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fa fa-flask"></i>

                                <span class="hide-menu">{{ translate('test_method_management') }} </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                @can('all_test_methods')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.test_method') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ translate('all_test_methods') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('all_units')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.unit') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ translate('all_units') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('all_result_types')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.result_type') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ translate('all_result_types') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                @endif
                <!--  Test Method Management End-->


                <!--  Sample Management Start-->
                @can('sample_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-microscope"></i>

                            <span class="hide-menu">{{ translate('sample_management') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @can('all_samples')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.sample') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('assign_test_to_the_samples') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('all_plants')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.plant') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_plants') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('all_plants')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.master_sample') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('create_samples') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('toxic_degree_management')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.toxic_degree') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_toxic_degrees') }}</span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                <!--  Sample Management End-->
                <!--  Submission Management Start-->
                @can('submission_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-microscope"></i>

                            <span class="hide-menu">{{ translate('submission_management') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @can('all_submissions')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.submission') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_submissions') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('all_sample_routine_scheduler')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.submission.schedule') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_sample_routine_scheduler') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('all_frequencies')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.frequency') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_frequencies') }}</span>
                                    </a>
                                </li>
                            @endcan


                        </ul>
                    </li>
                @endcan
                @can('result_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-microscope"></i>

                            <span class="hide-menu">{{ translate('result_management') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @can('all_results')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.result') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_results_pending') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.result_completed') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_results_completed') }}</span>
                                    </a>
                                </li>
                            @endcan




                        </ul>
                    </li>
                @endcan

                @can('coa_settings')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-microscope"></i>

                            <span class="hide-menu">{{ translate('coa_Template_Designer') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">

                            <li class="sidebar-item">
                                <a href="{{ route('admin.template_designer') }}" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu">{{ translate('template_Designer_List') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('coa_generation_settings')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-microscope"></i>

                            <span class="hide-menu">{{ translate('coa_Generation_Settings') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">

                            <li class="sidebar-item">
                                <a href="{{ route('coa_generation_setting.list') }}" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu">{{ translate('coa_Generation_Settings_List') }}</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('admin.email') }}" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu">{{ translate('email_List') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('coa_generation_settings')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-microscope"></i>

                            <span class="hide-menu">{{ translate('certificate_Management') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">

                            <li class="sidebar-item">
                                <a href="{{ route('admin.certificate') }}" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu">{{ translate('certificate_List') }}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan

                <!--  Submission Management End-->

                @can('user_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fa fa-users"></i>

                            <span class="hide-menu">{{ translate('user_management') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @can('all_users')
                                <li class="sidebar-item">
                                    <a href="{{ route('user_managment') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_users') }}</span>
                                    </a>
                                </li>
                            @endcan
                            {{-- @can('all_users') --}}
                            <li class="sidebar-item">
                                <a href="{{ route('client.list') }}" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu">{{ translate('clients_List') }}</span>
                                </a>
                            </li>

                        </ul>
                        {{-- @endcan --}}
                    </li>
                @endcan

                @can('admin_roles')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fa fa-id-badge"></i>


                            <span class="hide-menu">{{ translate('roles') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('show_admin_roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('roles') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('all_roles') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('create_admin_roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('roles.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('create_role') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('admin_roles')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fa fa-id-badge"></i>


                            <span class="hide-menu">{{ translate('system_Setup') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('show_admin_roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('language.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('languages') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_admin_roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('profile.update', auth()->id()) }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ translate('profile') }}</span>
                                    </a>
                                </li>
                            @endcan
                            <!-- #region -->
                        </ul>
                    </li>
                @endcan
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('logout') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-directions"></i>
                        <span class="hide-menu">{{ translate('login.logout') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
