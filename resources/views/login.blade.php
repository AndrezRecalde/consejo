<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Round|Material+Icons+Outlined" rel="stylesheet">

    <!--end::Global Stylesheets Bundle-->
    <title>{{config('app.name')}} - Login</title>
    
</head>

<body id="kt_body" class="bg-body">
    <div id="app" style="height:100%">
        <v-app>
            <router-view />
        </v-app>
    </div>
</body>
<script src="{{ mix('/js/app.js') }}"></script>

</html>

</html>