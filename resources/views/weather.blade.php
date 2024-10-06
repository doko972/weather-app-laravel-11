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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-bottom: 60px;
            /* Height of the footer */
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px;
            /* Height of the footer */
            background-color: #f5f5f5;
        }

        p.card-text {
            margin-top: -10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Application de Météo</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5 mb-4">Météo</h1>
        <div class="input-group mb-3">
            <form action="{{ route('weather.form') }}" method="post" class="form-inline">
                @csrf
                <div class="d-flex">
                    <div class="form-group">
                        <select class="form-select" name="city" id="city">
                            <option value="-1">-- Selectionez la Ville --</option>
                            <option value="paris">Paris</option>
                            <option value="marseille">Marseille</option>
                            <option value="lyon">Lyon</option>
                            <option value="toulouse">Toulouse</option>
                            <option value="nice">Nice</option>
                            <option value="nantes">Nantes</option>
                            <option value="strasbourg">Strasbourg</option>
                            <option value="montpellier">Montpellier</option>
                            <option value="bordeaux">Bordeaux</option>
                            <option value="lille">Lille</option>
                            <option value="rennes">Rennes</option>
                            <option value="reims">Reims</option>
                            <option value="le-havre">Le Havre</option>
                            <option value="saint-etienne">Saint-Étienne</option>
                            <option value="toulon">Toulon</option>
                            <option value="grenoble">Grenoble</option>
                            <option value="dijon">Dijon</option>
                            <option value="angers">Angers</option>
                            <option value="nîmes">Nîmes</option>
                            <option value="villeurbanne">Villeurbanne</option>
                            <option value="clermont-ferrand">Clermont-Ferrand</option>
                            <option value="caen">Caen</option>
                            <option value="limoges">Limoges</option>
                            <option value="brest">Brest</option>
                            <option value="tours">Tours</option>
                            <option value="amiens">Amiens</option>
                            <option value="metz">Metz</option>
                            <option value="perpignan">Perpignan</option>
                            <option value="besancon">Besançon</option>
                            <option value="orléans">Orléans</option>
                        </select>
                    </div>
                    <button style="margin-left: 20px;" class="btn btn-primary">Rechercher</button>
                </div>
            </form>

        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Etat</h5>
                        <br>
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
                                                    <img src="../images/{{ $image }}" alt="Image de {{ $data['weather'][0]['main'] }}"
                                                        style="height: 100px;">
                                                @else
                                                    <p>Image indisponible pour {{ $data['weather'][0]['main'] }}</p>
                                                @endif
                        @else
                            <p>Aucune donnée météo disponible</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Details</h5>
                        <br>
                        <p class="card-text">Pays:
                            <b>
                                @if (isset($data["sys"]["country"]))
                                    {{ $data["sys"]["country"] }}
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Ville:
                            <b>
                                @if (isset($data["name"]))
                                    {{ $data["name"] }}
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Lever du soleil:
                            <b>
                                @if (isset($data["sys"]["sunrise"]))
                                    {{ Carbon::createFromTimestamp($data["sys"]["sunrise"])->setTimezone('Europe/Paris')->format('H:i:s') }}
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Coucher de soleil:
                            <b>
                                @if (isset($data["sys"]["sunset"]))
                                    {{ Carbon::createFromTimestamp($data["sys"]["sunset"])->setTimezone('Europe/Paris')->format('H:i:s') }}
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Date:
                            <b>
                                @if (isset($data["sys"]))
                                    {{ Carbon::createFromTimestamp($data["sys"]["sunrise"])->setTimezone('Europe/Paris')->translatedFormat('d F Y') }}
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Temperature &deg; C</h5>
                        <br>
                        <p class="card-text">Temp:
                            <b>
                                @if (isset($data["main"]["temp"]))
                                    {{ round(($data["main"]["temp"] - 32) * 5 / 9, 2) }} °C
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Min Temp:
                            <b>
                                @if (isset($data["main"]["temp_min"]))
                                    {{ round(($data["main"]["temp_min"] - 32) * 5 / 9, 2) }} °C
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Max Temp:
                            <b>
                                @if (isset($data["main"]["temp_max"]))
                                    {{ round(($data["main"]["temp_max"] - 32) * 5 / 9, 2) }} °C
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Temp Ressentie:
                            <b>
                                @if (isset($data["main"]["feels_like"]))
                                    {{ round(($data["main"]["feels_like"] - 32) * 5 / 9, 2) }} °C
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Precipitation &percnt;</h5>
                        <br>
                        <p class="card-text">Humidité:
                            <b>
                                @if (isset($data["main"]["humidity"]))
                                    {{ $data["main"]["humidity"] }} &percnt;

                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Pression atmosphérique:
                            <b>
                                @if (isset($data["main"]["pressure"]))
                                    {{ $data["main"]["pressure"] }} hPa
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Pression au Niveau de la Mer:
                            <b>
                                @if (isset($data["main"]["sea_level"]))
                                    {{ $data["main"]["sea_level"] }} hPa
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Pression au Niveau du Sol:
                            <b>
                                @if (isset($data["main"]["grnd_level"]))
                                    {{ $data["main"]["grnd_level"] }} hPa
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Visibilité:
                            <b>
                                @if (isset($data["Visibility"]))
                                    {{ $data["Visibility"] }}
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Vent m/h</h5>
                        <br>
                        <p class="card-text">Vitesse:
                            <b>
                                @if (isset($data["wind"]["speed"]))
                                    {{ $data["wind"]["speed"] }} m/h
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                        <p class="card-text">Angle:
                            <b>
                                @if (isset($data["wind"]["deg"]))
                                    {{ $data["wind"]["deg"] }}
                                @else
                                    --
                                @endif
                            </b>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br><br>
    <footer class="footer">
        <div class="container">
            <span class="text-muted">© 2024 Météo with Laravel 11. doko972.</span>
        </div>
    </footer>
</body>

</html>