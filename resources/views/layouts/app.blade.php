<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Aimme App - +960 9660028') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <!-- Bulma Version 0.7.4-->
    <link rel="stylesheet" href="{{asset('/css/dhivehifonts.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{mix('/sass/app-compiled.css')}}">
    <link rel="stylesheet" href="{{mix('/sass/bulma-css-compiled.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('/css/admin-light.css')}}"> -->

    <style type="text/css">
    [v-cloak] {display: none;}
    </style>

    <style type="text/css">
        div#app.section {
          padding-top: 10px;
        }
        nav.navbar {
          border-top: 4px solid #276cda;
          margin-bottom: 1rem;
        }
        .navbar-item.brand-text {
          font-weight: 300;
        }
        .navbar-item, .navbar-link {
          font-size: 14px;
          font-weight: 700;
          text-decoration:none;
        }
        a.navbar-item:hover {
          text-decoration:none !important;
        }
        .menu-label {
          color: #8F99A3;
          letter-spacing: 1.3;
          font-weight: 700;
        }
        .menu-list a {
          color: #0F1D38;
          font-size: 14px;
          font-weight: 700;
          text-decoration:none;
        }
        .menu-list a:hover {
          background-color: transparent;
          color: #276cda;
          text-decoration:none;
        }
        .menu-list a.is-active {
          background-color: transparent;
          color: #276cda;
          font-weight: 700;
          text-decoration:none;
        }

    </style>

    <style type="text/css">
    @page {
      size: A4;
      margin: 0;
    }
    @media print {
      html, body {
        width: 210mm;
        height: 297mm;
        background-color: red;
/*        padding-right: 2px;
        padding-left: 2px;*/
        margin-right: 200px;
      }
      .no-print, .no-print * {
        display: none !important;
        /*visibility: hidden;*/
      }
      a {
        text-decoration:none !important;
        color: black;
      }
      i {
        color: #F5F5F5;
      }
      h1, h2 {
        color: #F5F5F5;
      }
    }

    .center {
      text-align: center !important;
    }
    .fit {
      width:1%;
      white-space:nowrap;
    }
    .small-box {
      border: 1px solid transparent;
      -webkit-appearance: none;
      align-items: center;
      max-width: 100%;
      width: 100%;
      /*border-radius: 4px;*/
      /*box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);*/
      /*box-shadow: 0 1px 1px rgba(10, 10, 10, 0.1), 1px 1px 1px 1px rgba(10, 10, 10, 0.1);*/
      box-shadow: 0 0px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
      /*border: 1px solid #4A4A4A;*/
      display: inline-flex;
      font-size: 1rem;
      height: 2.25em;
      justify-content: flex-start;
      line-height: 1.5;
      padding-bottom: calc(0.375em - 1px);
      padding-left: calc(0.625em - 1px);
      padding-right: calc(0.625em - 1px);
      padding-top: calc(0.375em - 1px);
      position: relative;
      vertical-align: top;
    }
    .dhivehi, .dhivehi * {
      text-align: right;
      direction:rtl;
      /*unicode-bidi:bidi-override;*/
      font-family:'MV_Faseyha';
    }
    .right {
      text-align: right !important;
    }
    .mv {
      font-family: 'MV_Faseyha';
      direction:rtl;
      text-align: right;
    }
    .ltr {
      direction: ltr !important;
      unicode-bidi:bidi-override;
    }
    .selectdv select {
        background-color: white;
        border-color: #dbdbdb;
        color: #363636;
        cursor: pointer;
        display: block;
        font-size: 1em;
        max-width: 100%;
        outline: none;
    }
    .selectdv:not(.is-multiple):not(.is-loading)::after {
        border-color: #3273dc;
        left: 1.125em;
        z-index: 4;
    }
    .selectdv:not(.is-multiple) {
      height: 2.25em;
    }
    .selectdv {
      -moz-appearance: none;
      -webkit-appearance: none;
      -webkit-box-align: center;
          -ms-flex-align: center;
              align-items: center;
      border: 1px solid transparent;
      border-radius: 4px;
      -webkit-box-shadow: none;
              box-shadow: none;
      display: -webkit-inline-box;
      display: -ms-inline-flexbox;
      display: inline-flex;
      font-size: 1rem;
      height: 2.25em;
      -webkit-box-pack: start;
          -ms-flex-pack: start;
              justify-content: flex-start;
      line-height: 1.5;
      padding-bottom: calc(0.375em - 1px);
      padding-left: calc(0.625em - 1px);
      padding-right: calc(0.625em - 1px);
      padding-top: calc(0.375em - 1px);
      position: relative;
      vertical-align: top;
    }
    </style>
</head>

<body>

    <!-- START NAV -->
    @include('layouts.admin-light.top-nav')
    <!-- END NAV -->
    <div class="section" id="app">
        <div class="columns">
            <div class="columnno-print">
                @include('layouts.admin-light.menu')
            </div>
            <div class="column">
                @yield('content')
            </div>
        </div>
    </div>
    <script type="text/javascript">
      function toggleMenu() {
        var sideMenu = document.getElementById('side-menu');
        var closedSideMenu = document.getElementById('closed-side-menu');
        if (sideMenu.style.display === "none") {
          sideMenu.style.display = "block";
          closedSideMenu.style.display = "none";
        } else {
          sideMenu.style.display = "none";
          closedSideMenu.style.display = "block";
        }
      }
      function hideMenu() {
        toggleMenu();
      }
      function showMenu() {
        toggleMenu();
      }
    </script>
    <script type="text/javascript" src="{{mix('/js/app-compiled.js')}}"></script>
    @yield('page-last-scripts')
</body>

</html>
