<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <li class="{{ Active::route('AdminOverview') }}"><a href="{{ route('AdminOverview') }}">Overview <span class="sr-only">(current)</span></a></li>
  </ul>
  <ul class="nav nav-sidebar">
    <li class="{{ Active::routePattern('AdminCategory*') }}"><a href="{{ route('AdminCategoryIndex') }}">Categories</a></li>
    <li class="{{ Active::routePattern('AdminProduct*') }}"><a href="{{ route('AdminProductIndex') }}">Products</a></li>
  </ul>
</div>
