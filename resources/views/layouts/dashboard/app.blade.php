<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <base href="">
		<title>{{ config('app.name', 'Consejo') }}</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:site_name" content="PSC | PSC-6" />
		<link rel="shortcut icon" href="/assets/media/logos/favicon.png" />
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
