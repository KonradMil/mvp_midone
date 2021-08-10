@extends('layouts.menu_footer')

@section('content')
    <br/><br/>
    <div class="container">
        <div class="row">
            <div class=" col-12 text-left">
                <h1>{{trans('ue.title')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                    <img class="full-width" src="{{url('images/plakat1.jpg')}}" alt="Lets start">
            </div>
        </div>
        <div class="ofs" style="margin-top: 50px;">
        <div class="row">

            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Projektant Programista.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Oferta pracy - Projektant programista.pdf</h5>
                </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - wynajem robota.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - wynajem robota.pdf</h5>
                </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - oprogramowanie stanowiska.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - oprogramowanie stanowiska.pdf</h5>
                </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Koordynator prac B+R.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Oferta pracy - Koordynator prac B+R.pdf</h5>
                </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - wynajem hali.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - wynajem hali.pdf</h5>
            </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Specjalista ds. prac B+R .pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Oferta pracy - Specjalista ds. prac B+R.pdf</h5>
                </a>
            </div>
        </div>
        <div class="row">
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Kierownik projektu.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Oferta pracy - Kierownik Projektu.pdf</h5>
                </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - zakup komputerow.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - zakup komputerów.pdf</h5>
                </a>
            </div>


            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - usluga doradcza.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - usługa doradcza.pdf</h5>
                </a>
            </div>


            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - ubezpieczenie.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - zakup ubezpieczenia.pdf</h5>
                </a>
            </div>

{{--            <a href="{{url('pdf')}}/Zapytanie-ofertowe-ubezpieczenie.pdf">--}}
            <div class=" col-2 text-left">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - zakup materiałów do badan.pdf</h5>
            </div>
{{--            </a>--}}

            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Oferta pracy - projektant.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Oferta pracy - Projektant.pdf</h5>
                </a>
            </div>
        </div>
        <div class="row">

            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - zakup bazy danych.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - zakup bazy danych.pdf</h5>
                </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Zapytanie ofertowe - licencje na programy.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Zapytanie ofertowe - licencje na programy.pdf</h5>
                </a>
            </div>
            <div class=" col-2 text-left">
                <a href="{{url('pdf')}}/Specjalista ds. robotyzacji.pdf">
                <img src="{{url('icons/pdf-icon.png')}}"/>
                <h5>Oferta pracy - Specjalista ds. robotyzacji.pdf</h5>
                </a>
            </div>

        </div>
            </div>
    </div>

@endsection

@section('styles')
    <style>
        .ofs h5 {
            width: 80%;
            padding-left: 10%;
            margin-top: 10px;

        }
        .ofs .text-left {
            cursor: pointer;
            margin-bottom: 10px;
        }
        .ofs img {
            width: 100%;
        }
        li {
            font-size: 1rem;
        }

        .flex-column p {
            width: 80%;
            margin-left: 10%;
            margin-top: 10px;
            text-align: center;
            color: white;
            font-size: 1.2rem;
        }

        .flex-column picture img {
            width: 50%;
            justify-self: center;
            align-items: center;
        }

        .flex-column picture {
            display: flex;
            align-self: center;
            justify-content: center;
        }

        .row {
            -webkit-animation: opa 4s;
            -moz-animation: opa 4s;
            -o-animation: opa 4s;
            animation: opa 4s;
        }

        .full-width {
            width: 100%;
        }

        .graySection {
            background-color: #EEEEEE;
            padding-bottom: 8vw;
        }

        .graySkewTop {
            background-color: #EEEEEE;
            height: 10vw;
            transform: skewY(3deg) translateY(7vw);
        }

        .graySkewBottom {
            background-color: #EEEEEE;
            height: 6vw;
            transform: skewY(-3deg) translateY(-3vw);
        }

        .purpleSection {
            background-color: rgb(62, 46, 114);
            padding-bottom: 8vw;
        }

        .purpleSkewTop {
            background-color: rgb(62, 46, 114);
            height: 10vw;
            transform: skewY(3deg) translateY(7vw);
        }

        .purpleSkewBottom {
            background-color: rgb(62, 46, 114);
            height: 6vw;
            transform: skewY(-3deg) translateY(-3vw);
        }

        h1 {
            margin-bottom: 5%;
            color: #3A2B68;
            font-size: 30px;
            font-weight: bold;
        }

        @media (min-width: 768px) {
            h1 {
                font-size: 45px;
            }

            .onlyMin {
                display: none;
            }
        }

        @media (max-width: 767px) {
            .onlyMax {
                display: none;
            }
        }

        /* ANIMACJE */
        @-webkit-keyframes opa {
            from {
                left: -100%;
            }
            to {
                left: 0%;
            }
        }

        @-moz-keyframes opa {
            from {
                left: -100%;
            }

            to {
                left: 0%;
            }
        }

        @-o-keyframes opa {
            from {
                left: -100%;
            }

            to {
                left: 0%;
            }
        }

        @keyframes opa {
            from {
                opacity: 0%;
            }
            to {
                opacity: 100%;
            }
        }

        .cap {
            padding-top: 400px;
        }
    </style>
@endsection
@section('scripts')
    <script>

    </script>
@endsection
