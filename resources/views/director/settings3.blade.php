@extends('layouts.layoutDirector')
@section('content')
    <section class="admin-settings director-main">
        <h1 class="director-content__heading heading heading__h1">Persönliche Daten</h1>

        <div class="director-content">

            <div class="block">
                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Avatar</li>
                    <li data-tab="tab-2" class="block__item">Kontakt Daten</li>
                    <li data-tab="tab-3" class="block__item">Anschrift</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <div class="logo-block">
                        <div>
                            <a class="logo-block__btn btn btn--gray" href="#">Datei auswählen</a>
                        </div>
                        <div class="logo-block__img">
                            <img src="images/content/graficon.jpg" alt="">
                        </div>
                        <div class="logo-block__edit"></div>
                        <a class="logo-block__btn btn btn--red" href="#">Speichern</a>
                    </div>
                </div>

                <div data-tab-id="tab-2" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <td>Telefon</td>
                            <td>022812345</td>
                        </tr>

                        <tr>
                            <td>Mobile</td>
                            <td>01234556678</td>
                        </tr>

                        <tr>
                            <td>E-Mail:</td>
                            <td>info@timebox24.com</td>
                        </tr>

                        <tr>
                            <td>Passwort</td>
                            <td>************</td>
                        </tr>

                        <tr>
                            <td>Skype</td>
                            <td>grafikondesign.de</td>
                        </tr>

                        <tr>
                            <td>Geschlecht</td>
                            <td>Weiblich</td>
                        </tr>

                    </table>
                    <a class="director-kunden__btn btn btn--red" href="#">Jetzt ändern</a>
                </div>

                <div data-tab-id="tab-3" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <td>Name</td>
                            <td>Wagner</td>
                        </tr>

                        <tr>
                            <td>Vorname</td>
                            <td>Dima</td>
                        </tr>

                        <tr>
                            <td>Strasse / Nr</td>
                            <td>Musterstrasse 64</td>
                        </tr>

                        <tr>
                            <td>PLZ / Stadt</td>
                            <td>5123 Bonn</td>
                        </tr>

                        <tr>
                            <td>Bundesland</td>
                            <td>NRW</td>
                        </tr>

                        <tr>
                            <td>Land</td>
                            <td>Deutschland</td>
                        </tr>

                    </table>
                    <a class="director-kunden__btn btn btn--red" href="#">Jetzt ändern</a>
                </div>

            </div>

        </div>

    </section>
@stop