<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <base href="">
		<title>{{ config('app.name', 'Laravel') }}</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<!-- <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" /> -->
		<!-- <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" /> -->
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<!-- <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" /> -->
		<link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<style>
            .v-application,body {
                font-family: 'Poppins', sans-serif !important;
            }
        </style>
	</head>
    <body class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:0px;--kt-toolbar-height-tablet-and-mobile:55px">
            <!-- <v-app style="display:none"> -->
               
                <!-- <v-main> -->
                    <!-- <v-container fluid> -->
					<div id="app" style="height: 100%;">
					<v-app style="background:#fff0;padding:0px;display:none">

						@yield('content')
							</v-app>

					</div>
                    <!-- <router-view />
                        <input type="hidden" id="usuario_id" data-readonly="{{(\Auth::check())?auth()->user()->id :'' }}"> -->
                    <!-- </v-container> -->
                <!-- </v-main> -->
            <!-- </v-app> -->
        <script src="{{ mix('js/app.js') }}"></script>

        <script>var hostUrl = "/assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="/assets/js/widgets.bundle.js"></script>
		<script src="/assets/js/custom/widgets.js"></script>
		<script src="/assets/js/custom/apps/chat/chat.js"></script>
		<script src="/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="/assets/js/custom/utilities/modals/create-app.js"></script>
		<script src="/assets/js/custom/utilities/modals/users-search.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Round|Material+Icons+Outlined" rel="stylesheet">

		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
</html>
