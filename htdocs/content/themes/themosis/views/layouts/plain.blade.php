<!doctype html>
<html {!! get_language_attributes() !!}>
<head>
  <meta charset="{{ get_bloginfo('charset') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  @head
</head>
<body @php(body_class())>
  <div id="page" class="site">
    <main id="main" class="site-main" style="padding:2rem;">
      @yield('content')
    </main>
  </div>
  @footer
</body>
</html>
