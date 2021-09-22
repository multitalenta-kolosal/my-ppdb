<!-- //@include ('frontend.includes.footer-comment-area') -->

<footer class="footer section pt-6 pt-md-8 pt-lg-10 pb-3 warga-purple text-white overflow-hidden">
    <div class="pattern pattern-soft top warga-purple"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <a class="footer-brand mr-lg-5 d-flex" href="/">
                    <img src="{{asset('img/backend-logo.jpg')}}" height="35" class="mr-3" alt="Footer logo">
                </a>
                <p class="my-4">
                    {!! setting('meta_description') !!}
                </p>
            </div>
            <div class="col-6 col-sm-3 col-lg-2 mb-4 mb-lg-0 text-center">
                <h6>
                    Pages
                </h6>
                <ul class="links-vertical">
                    <li><a target="_blank" href="{{ route('frontend.registrants.index') }}">Pendaftaran</a></li>
                </ul>
            </div>
            <div class="col-6 col-sm-3 col-lg-2 mb-4 mb-lg-0 text-center">
                <h6>
                    Account
                </h6>
                <ul class="links-vertical">
                    @guest
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    @else
                    <li>
                        <a href="#">{{ Auth::user()->name }}</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <!-- <small class="mt-2 form-text">We’ll never share your details. See our <a href="{{route('frontend.privacy')}}" class="font-weight-bold text-underline">Privacy Policy</a></small> -->
            </div>
        </div>

        <hr class="my-4 my-lg-5">

        <div class="row">
            <div class="col pb-4 mb-md-0">
                <div class="d-flex text-center justify-content-center align-items-center">
                    <p class="font-weight-normal mb-0">
                        &copy; {{ app_name() }}, {!! setting('footer_text') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
