<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Classificados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="{{ URL::asset('css/estilo.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />
</head>

<body class="">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24">
            </a>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M17.0444645,19.6408084 C16.0341578,20.7072432 14.9539241,21.6794535 13.8734451,22.539835 C13.4948263,22.8413277 13.1427142,23.1076689 12.8258367,23.3365249 C12.6334551,23.4754671 12.4939372,23.5720962 12.4160251,23.6240376 C12.1641006,23.7919873 11.8358994,23.7919873 11.5839749,23.6240376 C11.5060628,23.5720962 11.3665449,23.4754671 11.1741633,23.3365249 C10.8572858,23.1076689 10.5051737,22.8413277 10.1265549,22.539835 C9.04607586,21.6794535 7.96584218,20.7072432 6.95553549,19.6408084 C4.02367618,16.546068 2.25,13.2943283 2.25,9.99999985 C2.25,4.6152236 6.61522375,0.25 12,0.25 C17.3847763,0.25 21.75,4.6152236 21.75,9.99999985 C21.75,13.2943283 19.9763238,16.546068 17.0444645,19.6408084 Z M12.9390549,21.3664148 C13.9679509,20.5471087 14.9970922,19.6208815 15.9555355,18.6091914 C18.6486762,15.7664318 20.25,12.8306714 20.25,9.99999987 C20.25,5.44365074 16.5563491,1.75 12,1.75 C7.44365086,1.75 3.75,5.44365074 3.75,9.99999987 C3.75,12.8306714 5.35132382,15.7664318 8.04446451,18.6091914 C9.00290782,19.6208815 10.0320491,20.5471087 11.0609451,21.3664148 C11.3996944,21.6361596 11.7151776,21.87558 12,22.0825458 C12.2848224,21.87558 12.6003056,21.6361596 12.9390549,21.3664148 Z M12,13.7499999 C9.92893219,13.7499999 8.25,12.0710677 8.25,9.99999987 C8.25,7.92893205 9.92893219,6.24999987 12,6.24999987 C14.0710678,6.24999987 15.75,7.92893205 15.75,9.99999987 C15.75,12.0710677 14.0710678,13.7499999 12,13.7499999 Z M12,12.2499999 C13.2426407,12.2499999 14.25,11.2426406 14.25,9.99999987 C14.25,8.75735918 13.2426407,7.74999987 12,7.74999987 C10.7573593,7.74999987 9.75,8.75735918 9.75,9.99999987 C9.75,11.2426406 10.7573593,12.2499999 12,12.2499999 Z"></path>
                    </svg>
                </button>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <button class="btn btn-outline-success" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M16.8399523,15.7792921 L21.5303301,20.4696699 C21.8232233,20.7625631 21.8232233,21.2374369 21.5303301,21.5303301 C21.2374369,21.8232233 20.7625631,21.8232233 20.4696699,21.5303301 L15.7792921,16.8399523 C14.3486717,18.0325324 12.5081226,18.75 10.5,18.75 C5.94365081,18.75 2.25,15.0563492 2.25,10.5 C2.25,5.94365081 5.94365081,2.25 10.5,2.25 C15.0563492,2.25 18.75,5.94365081 18.75,10.5 C18.75,12.5081226 18.0325324,14.3486717 16.8399523,15.7792921 L16.8399523,15.7792921 Z M15.3290907,15.2161873 C16.517579,13.9994267 17.25,12.3352464 17.25,10.5 C17.25,6.77207794 14.2279221,3.75 10.5,3.75 C6.77207794,3.75 3.75,6.77207794 3.75,10.5 C3.75,14.2279221 6.77207794,17.25 10.5,17.25 C12.3352464,17.25 13.9994267,16.517579 15.2161873,15.3290907 C15.2327733,15.3085794 15.2506009,15.2887389 15.2696699,15.2696699 C15.2887389,15.2506009 15.3085794,15.2327733 15.3290907,15.2161873 L15.3290907,15.2161873 Z"></path>
                    </svg>
                </button>
            </form>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="/">Home</a>
                    <a class="nav-link active" href="#">Features</a>
                    <a class="nav-link active" href="#">Pricing</a>
                </div>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link active">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="nav-link active">Log in</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-link active">Register</a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>
</body>

</html>