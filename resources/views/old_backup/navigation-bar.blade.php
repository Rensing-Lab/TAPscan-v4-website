<!DOCTYPE html>

<div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">TAPscan</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item {{ (request()->is('/taps*')) ? 'active' : '' }}">
        <a class="nav-link" href="/taps">TAPs <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/species">Species</a>
      </li>
      @auth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Datatables
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/taps">TAPs</a>
          <a class="dropdown-item" href="/rules">TAP Rules</a>
          <a class="dropdown-item" href="/species">Species</a>
        </div>
      </li>
    @endauth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tools
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Compare</a>
          <a class="dropdown-item" href="#">Visualization</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Other</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">News</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </ul>
<div class="dropdown">

  <button class="btn btn-secondary" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
    Dropdown
  </button>


@guest
<div class="dropdown-menu dropdown-menu-right">
  {{-- <form class="px-4 py-3">
    <div class="form-group">
      <label for="exampleDropdownFormEmail1">Email address</label>
      <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
    </div>
    <div class="form-group">
      <label for="exampleDropdownFormPassword1">Password</label>
      <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="dropdownCheck">
        <label class="form-check-label" for="dropdownCheck">
          Remember me
        </label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
  </form> --}}

  <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="form-group row">
          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

          <div class="col-md-6">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>

      <div class="form-group row">
          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

          <div class="col-md-6">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>

      <div class="form-group row">
          <div class="col-md-6 offset-md-4">
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                  <label class="form-check-label" for="remember">
                      {{ __('Remember Me') }}
                  </label>
              </div>
          </div>
      </div>

      <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-primary">
                  {{ __('Login') }}
              </button>

              @if (Route::has('password.request'))
                  <a class="btn btn-link" href="{{ route('password.request') }}">
                      {{ __('Forgot Your Password?') }}
                  </a>
              @endif
          </div>
      </div>
  </form>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">New around here? Sign up</a>
  <a class="dropdown-item" href="#">Forgot password?</a>
</div>
@endguest

@auth
<div class="dropdown-menu dropdown-menu-right">

  <form method="POST" action="{{ route('logout') }}">
      @csrf

      <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-primary">
                  {{ __('Logout') }}
              </button>
          </div>
      </div>
  </form>
</div>
@endauth


  </div>
</nav>
</div>

{{-- ###########
Datatable + Laravel Scout
########### --}}


{{-- <div style="position:relative;z-index:1">
<div><ul class="navigation" id="nav">
  <li><a id="TAPview" href="index">TAPfamily view</a></li>
  <li><a id="speciesView" href="species">Species view</a></li>
  <li><a id="news" href="news">News</a></li>
  <li><a id="contact" href="TAPtalk">Contact</a></li>
  <li><a id="about" href="about">About</a></li>
  <li>
    <input type="text" name="search" id="search" placeholder="search here...." class="form-control">
  </li>
  <!-- <input type="text" name="input" id="textbox" placeholder="Search..."> -->
</ul>
</div>
</div> --}}



<!-- <div style="position:relative;z-index:2;left:72%" id="result"></div> -->
<!-- <body>
    <div style="position:absolute;z-index:2"></div>
    <div style="position:absolute;z-index:1"></div>
</body> -->

{{-- <style>
.ui-autocomplete-category {
  font-weight: bold;
  padding: .2em .4em;
  margin: .8em 0 .2em;
  line-height: 1.5;
}
</style> --}}

{{-- <script type="text/javascript">

$(function() {
  $.widget( "custom.catcomplete", $.ui.autocomplete, {
  _create: function() {
    this._super();
    this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
  },
  _renderMenu: function( ul, items ) {
    var that = this,
      currentCategory = "";
    $.each( items, function( index, item ) {
      var li;
      if ( item.category != currentCategory ) {
        ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
        currentCategory = item.category;
      }
      li = that._renderItemData( ul, item );
      if ( item.category ) {
        li.attr( "aria-label", item.category + " : " + item.label );
      }
    });
  }
});

   $( "#search" ).catcomplete({
     source: 'search.php',
     select:function(event, ui){
       window.location.href = ui.item.html;
     }
   });
});

// var textBox = document.getElementById('textbox'),
//   resultContainer = document.getElementById('result')
//
// // keep this global to abort it if already a request is running even textbox is upated
// var ajax = null;
// var loadedUsers = 0; // number of users shown in the results
//
// textBox.onkeyup = function() {
//   // "this" refers to the textbox
//   var val = this.value;
//
//   // trim - remove spaces in the begining and the end
//   val = val.replace(/^\s|\s+$/, "");
//
//   // check if the value is not empty
//   if (val !== "") {
//     // search for data
//     searchForData(val);
//   } else {
//     // clear the result content
//     clearResult();
//   }
// }
//
//
// function searchForData(value, isLoadMoreMode) {
//   // abort if ajax request is already there
//   if (ajax && typeof ajax.abort === 'function') {
//     ajax.abort();
//   }
//
//   // nocleaning result is set to true on load more mode
//   if (isLoadMoreMode !== true) {
//     clearResult();
//   }
//
//   // create the ajax object
//   ajax = new XMLHttpRequest();
//   // the function to execute on ready state is changed
//   ajax.onreadystatechange = function() {
//     if (this.readyState === 4 && this.status === 200) {
//       try {
//         var json = JSON.parse(this.responseText)
//       } catch (e) {
//         noUsers();
//         return;
//       }
//
//       if (json.length === 0) {
//         if (isLoadMoreMode) {
//           alert('No more to load');
//         } else {
//           noUsers();
//         }
//       } else {
//         showUsers(json);
//       }
//
//
//     }
//   }
//   // open the connection
//   ajax.open('GET', 'search.php?input=' + value + '&startFrom=' + loadedUsers , true);
//   // send
//   ajax.send();
// }
//
// function showUsers(data) {
//   // the function to create a row
//   function createRow(rowData) {
//     // creating the wrap
//     var wrap = document.createElement("div");
//     // add a class name
//     wrap.className = 'row'
//
//     // name holder
//     var name = document.createElement("span");
//     name.innerHTML = rowData.name;
//
//     // picture of the user
//     // var picture = document.createElement("img");
//     // picture.src = rowData.picture;
//     // picture.className = 'picture';
//
//     // show descript on click
//     wrap.onclick = function() {
//       alert(rowData.description);
//     }
//
//     // wrap.appendChild(picture);
//     wrap.appendChild(name);
//
//     // append wrap into result container
//     resultContainer.appendChild(wrap);
//   }
//
//   // loop through the data
//   for (var i = 0, len = data.length; i < len; i++) {
//     // get each data
//     var userData = data[i];
//     // create the row (see above function)
//     createRow(userData);
//   }
//
//   //  create load more button
//   var loadMoreButton = document.createElement("span");
//   loadMoreButton.innerHTML = "Load More";
//   // add onclick event to it.
//   loadMoreButton.onclick = function() {
//     // searchForData() function is called in loadMoreMode
//     searchForData(textBox.value, true);
//     // remove loadmorebutton
//     this.parentElement.removeChild(this);
//   }
//   // append loadMoreButton to result container
//   resultContainer.appendChild(loadMoreButton);
//
//   // increase the user count
//   loadedUsers += len;
// }
//
// function clearResult() {
//   // clean the result <div>
//   resultContainer.innerHTML = "";
//   // make loaded users to 0
//   loadedUsers = 0;
// }
//
// function noUsers() {
//   resultContainer.innerHTML = "No Users";
// }


</script> --}}

{{-- <ul class="navigation" id="navigation-show" style="display:none; position: fixed; top: 0px; left: 0px; z-index: 10000">
  <li><a id="TAPview" href="index.php">TAPfamily view</a></li>
  <li><a id="speciesView" href="species.php">Species view</a></li>
  <li><a id="news" href="news.php">News</a></li>
  <li><a id="contact" href="TAPtalk.php">Contact</a></li>
  <li><a id="about" href="about.php">About</a></li>
</ul> --}}
