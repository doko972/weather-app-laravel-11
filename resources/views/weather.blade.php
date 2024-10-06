@php
    use Carbon\Carbon;
    Carbon::setLocale('fr');
@endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Application</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <nav>
        <div>
            <a class="logo" href="#" style="color: white; text-decoration: none; font-size: 24px;">Application de Météo</a>
        </div>
    </nav>

    <div class="container">
        <h1>Météo</h1>

        <form action="{{ route('weather.form') }}" method="post" class="form-group">
            @csrf
            <div class="form-group">
                <select name="city" id="city">
                    <option value="-1">-- Sélectionnez la Ville --</option>
                    <option value="paris">Paris</option>
                    <option value="marseille">Marseille</option>
                    <option value="lyon">Lyon</option>
                    <!-- Ajoute d'autres villes ici -->
                </select>
            </div>
            <button type="submit">Rechercher</button>
        </form>

        <div class="weather-card">
            <h5>Etat</h5>
            @if (isset($data['weather'][0]['main']))
                @php
                    $weatherCondition = strtolower($data['weather'][0]['main']);
                    $weatherImages = [
                        'clear' => 'clear.png',
                        'clouds' => 'cloud.png',
                        'rain' => 'rain.png',
                    ];

                    $image = $weatherImages[$weatherCondition] ?? null;
                @endphp

                @if ($image)
                    <img src="../images/{{ $image }}" alt="Image de {{ $data['weather'][0]['main'] }}" style="height: 100px;">
                @else
                    <p>Image indisponible pour {{ $data['weather'][0]['main'] }}</p>
                @endif
            @else
                <p>Aucune donnée météo disponible</p>
            @endif
        </div>

        <div class="weather-card weather-info">
            <h5>Détails</h5>
            <p>Pays: <b>{{ $data["sys"]["country"] ?? '--' }}</b></p>
            <p>Ville: <b>{{ $data["name"] ?? '--' }}</b></p>
            <p>Lever du soleil: 
                <b>
                    @if (isset($data["sys"]["sunrise"]))
                        {{ Carbon::createFromTimestamp($data["sys"]["sunrise"])->setTimezone('Europe/Paris')->format('H:i:s') }}
                    @else
                        --
                    @endif
                </b>
            </p>
            <p>Coucher de soleil: 
                <b>
                    @if (isset($data["sys"]["sunset"]))
                        {{ Carbon::createFromTimestamp($data["sys"]["sunset"])->setTimezone('Europe/Paris')->format('H:i:s') }}
                    @else
                        --
                    @endif
                </b>
            </p>
            <p>Date: 
                <b>
                    @if (isset($data["sys"]))
                        {{ Carbon::createFromTimestamp($data["sys"]["sunrise"])->setTimezone('Europe/Paris')->translatedFormat('d F Y') }}
                    @else
                        --
                    @endif
                </b>
            </p>
        </div>

        <div class="weather-card weather-info">
            <h5>Température</h5>
            <p>Température: 
                <b>{{ isset($data["main"]["temp"]) ? round(($data["main"]["temp"] - 32) * 5 / 9, 2) . ' °C' : '--' }}</b>
            </p>
            <p>Température ressentie: 
                <b>{{ isset($data["main"]["feels_like"]) ? round(($data["main"]["feels_like"] - 32) * 5 / 9, 2) . ' °C' : '--' }}</b>
            </p>
        </div>

        <div class="weather-card weather-info">
            <h5>Vent</h5>
            <p>Vitesse du vent: 
                <b>{{ $data["wind"]["speed"] ?? '--' }} m/h</b>
            </p>
            <p>Angle du vent: 
                <b>{{ $data["wind"]["deg"] ?? '--' }}°</b>
            </p>
        </div>
    </div>

    <footer>
        <div>
            <span>© 2024 Météo with Laravel 11. doko972.</span>
        </div>
    </footer>

</body>

</html>
