@extends('layouts.layoutDirector')
@section('content')
    <section class="admin-settings director-main">
        <h1 class="director-content__heading heading heading__h1">Rechnungen</h1>

        <div class="director-content">

            <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Aktuelle Rechnung</li>
                    <li data-tab="tab-2" class="block__item">Rechnungsarchive</li>
                    <li data-tab="tab-3" class="block__item">Bankverbindung</li>
                    <li data-tab="tab-4" class="block__item">Rechnungsadresse</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <ul class="rechnungen">

                        <li class="rechnungen__item">
                            <div class="rechnungen__wrap">
                                <div class="rechnungen__name">Rechnung vom 22.06.15</div>
                                <div class="rechnungen__desc">Rechnungsbetrag</div>
                                <div class="rechnungen__price">29,99 €</div>
                            </div>
                            <a class="btn btn--red" href="#">Rechnung downloaden</a>
                        </li>

                    </ul>
                </div>

                <div data-tab-id="tab-2" class="tab-content">
                    <ul class="rechnungen">

                        <li class="rechnungen__item">
                            <div class="rechnungen__wrap">
                                <div class="rechnungen__name">Rechnung vom 22.06.15</div>
                                <div class="rechnungen__desc">Rechnungsbetrag</div>
                                <div class="rechnungen__price">29,99 €</div>
                            </div>
                            <a class="btn btn--red" href="#">Rechnung downloaden</a>
                        </li>

                        <li class="rechnungen__item">
                            <div class="rechnungen__wrap">
                                <div class="rechnungen__name">Rechnung vom 22.06.15</div>
                                <div class="rechnungen__desc">Rechnungsbetrag</div>
                                <div class="rechnungen__price">29,99 €</div>
                            </div>
                            <a class="btn btn--red" href="#">Rechnung downloaden</a>
                        </li>

                        <li class="rechnungen__item">
                            <div class="rechnungen__wrap">
                                <div class="rechnungen__name">Rechnung vom 22.06.15</div>
                                <div class="rechnungen__desc">Rechnungsbetrag</div>
                                <div class="rechnungen__price">29,99 €</div>
                            </div>
                            <a class="btn btn--red" href="#">Rechnung downloaden</a>
                        </li>

                    </ul>
                </div>

                <div data-tab-id="tab-3" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <td>Kontoinhaber</td>
                            <td>Vyacheslav Onopchenko</td>
                        </tr>

                        <tr>
                            <td>Kontonummer</td>
                            <td>53123 Bonn</td>
                        </tr>

                        <tr>
                            <td>Bankleitzahl</td>
                            <td>123456789</td>
                        </tr>

                        <tr>
                            <td>Bankname</td>
                            <td>Deutsche Bank</td>
                        </tr>

                        <tr>
                            <td>IBAN</td>
                            <td>DE123 456 789 10 11</td>
                        </tr>

                        <tr>
                            <td>BIC</td>
                            <td>CIDDDXXXX</td>
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