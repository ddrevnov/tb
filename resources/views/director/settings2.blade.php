@extends('layouts.layoutDirector')
@section('content')
    <section class="admin-settings director-main">
        <h1 class="director-content__heading heading heading__h1">Firmendetails</h1>

        <div class="director-content">

            <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Das Unternehmen</li>
                    <li data-tab="tab-2" class="block__item">Logo</li>
                    <li data-tab="tab-3" class="block__item">Öffnungszeiten</li>
                    <li data-tab="tab-4" class="block__item">Standort/e</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <p class="admin-settings__text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu

                        pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, </p>

                    <a class="admin-settings__btn btn btn--red" href="#">Speichern</a>
                </div>

                <div data-tab-id="tab-2" class="tab-content">
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

                <div data-tab-id="tab-3" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <td>Montag</td>
                            <td>08:00 - 17:00</td>
                        </tr>

                        <tr>
                            <td>Dienstag</td>
                            <td>08:00 - 17:00</td>
                        </tr>

                        <tr>
                            <td>Mittwoch</td>
                            <td>Geschlossen</td>
                        </tr>

                        <tr>
                            <td>Donnerstag</td>
                            <td>08:00 - 17:00</td>
                        </tr>

                        <tr>
                            <td>Freitag</td>
                            <td>08:00 - 17:00</td>
                        </tr>

                        <tr>
                            <td>Samstag</td>
                            <td>Geschlossen</td>
                        </tr>
                    </table>
                    <a href="#" class="admin-settings__btn btn btn--red f-right">Jetzt ändern</a>
                </div>

                <div data-tab-id="tab-4" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <td>Firma und Rechtsform</td>
                            <td>Vyacheslav Onopchenko</td>
                        </tr>

                        <tr>
                            <td>Vorname & Nachnahme</td>
                            <td>53123 Bonn</td>
                        </tr>

                        <tr>
                            <td>PLZ/Ort</td>
                            <td>123456789</td>
                        </tr>

                        <tr>
                            <td>Strabe/Nr</td>
                            <td>Deutsche Bank</td>
                        </tr>

                        <tr>
                            <td>Adresszusatz</td>
                            <td>DE123 456 789 10 11</td>
                        </tr>

                    </table>
                    <a href="#" class="admin-settings__btn btn btn--red f-right">Jetzt ändern</a>
                </div>

            </div>

        </div>

    </section>
    @stop