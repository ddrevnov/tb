@extends('layouts.layoutDirector')
@section('content')
    <section class="admin-settings director-main">
        <h1 class="director-content__heading heading heading__h1">Tarif & Vertragsinfos</h1>

        <div class="director-content">

            <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Ihr Tarif</li>
                    <li data-tab="tab-2" class="block__item">Tarif wechseln</li>
                    <li data-tab="tab-3" class="block__item">Kündigung vormerken</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <div class="tarif">
                        <h2 class="tarif__heading">PREMIUM</h2>
                        <p class="tarif__desc">Ideal für Fortgeschrittene</p>
                        <ul class="tarif__list">
                            <li class="tarif__item"><i></i>Bis 6 Mitarbeiter</li>
                            <li class="tarif__item"><i></i>Mitarbeiter Zugang</li>
                            <li class="tarif__item"><i></i>Kundenverwaltung</li>
                            <li class="tarif__item"><i></i>Terminerinnerung via E-Mail</li>
                            <li class="tarif__item"><i></i>Terminkalender</li>
                            <li class="tarif__item"><i></i>Kundenkommunikation</li>
                            <li class="tarif__item"><i></i>Buchungstool für Website</li>
                            <li class="tarif__item"><i></i>Buchungstool für Facebook</li>
                            <li class="tarif__item"><i></i>Newsletter Modul (1500 Empfänger)</li>
                            <li class="tarif__item"><i></i>Online Reports</li>
                        </ul>
                    </div>

                    <div class="tarif-info">
                        <table class="table tarif-info__table">
                            <tr>
                                <td>Vertragsbeginn:</td>
                                <td>09.04.2015</td>
                            </tr>

                            <tr>
                                <td>Vertragsende:</td>
                                <td>08.04.2017</td>
                            </tr>

                            <tr>
                                <td>Rechnungszeitraum:</td>
                                <td>vom 13. des Monats bis 12. des Folgemonats</td>
                            </tr>

                            <tr>
                                <td>Grundgebühr:</td>
                                <td>39,99 €</td>
                            </tr>
                        </table>
                    </div>

                    <a class="admin-settings__btn btn btn--red f-right" href="#">Speichern</a>
                </div>

                <div data-tab-id="tab-2" class="tab-content">
                    <p class="admin-settings__text">Hier finden Sie die Zusammenfassung der gewünschten Änderungen zu Ihren Tarifoptionen.
                    </p>
                    <p class="admin-settings__text">
                        Sie beauftragen die Änderung durch Klick des Buttons "Jetzt kaufen" bzw. "Abbestellen".
                    </p>
                    <div class="tarif">
                        <h2 class="tarif__heading">PREMIUM</h2>
                        <p class="tarif__desc">Ideal für Fortgeschrittene</p>
                        <ul class="tarif__list">
                            <li class="tarif__item"><i></i>Bis 6 Mitarbeiter</li>
                            <li class="tarif__item"><i></i>Mitarbeiter Zugang</li>
                            <li class="tarif__item"><i></i>Kundenverwaltung</li>
                            <li class="tarif__item"><i></i>Terminerinnerung via E-Mail</li>
                            <li class="tarif__item"><i></i>Terminkalender</li>
                            <li class="tarif__item"><i></i>Kundenkommunikation</li>
                            <li class="tarif__item"><i></i>Buchungstool für Website</li>
                            <li class="tarif__item"><i></i>Buchungstool für Facebook</li>
                            <li class="tarif__item"><i></i>Newsletter Modul (1500 Empfänger)</li>
                            <li class="tarif__item"><i></i>Online Reports</li>
                        </ul>
                        <div class="tarif__price">Grundgebühr: 9,99 €</div>
                    </div>
                    <div class="tarif-block">
                        <input type="checkbox" class="checkbox tarif-block__checkbox">
                        <div class="tarif-block__desc">
                            <h3 class="tarif-block__heading">Vertragsbedingungen und Widerrufsbelehrung</h3>
                            <p class="tarif-block__text">Ich bestelle auf Grundlage der AGB, der Leistungsbeschreibung sowie der gültigen Preisliste. Mir steht ein gesetzliches Widerrufsrecht zu.</p>
                        </div>
                    </div>
                    <div class="change-tarif">

                        <div class="change-tarif__tarif">
                            <div class="change-tarif__header">
                                Ihr Tarif: PREMIUM <span class="f-right">39,99 €</span>
                            </div>
                            <div class="tarif">
                                <h2 class="tarif__heading">PREMIUM</h2>
                                <p class="tarif__desc">Ideal für Fortgeschrittene</p>
                                <ul class="tarif__list">
                                    <li class="tarif__item"><i></i>Bis 6 Mitarbeiter</li>
                                    <li class="tarif__item"><i></i>Mitarbeiter Zugang</li>
                                    <li class="tarif__item"><i></i>Kundenverwaltung</li>
                                    <li class="tarif__item"><i></i>Terminerinnerung via E-Mail</li>
                                    <li class="tarif__item"><i></i>Terminkalender</li>
                                    <li class="tarif__item"><i></i>Kundenkommunikation</li>
                                    <li class="tarif__item"><i></i>Buchungstool für Website</li>
                                    <li class="tarif__item"><i></i>Buchungstool für Facebook</li>
                                    <li class="tarif__item"><i></i>Newsletter Modul (1500 Empfänger)</li>
                                    <li class="tarif__item"><i></i>Online Reports</li>
                                </ul>
                                <div class="tarif__price">Grundgebühr: 9,99 €</div>
                            </div>
                        </div>
                        <div class="change-tarif__tarif">
                            <select class="change-tarif__header change-tarif__select" name="" id="">
                                <option value="val1">Bitte wählen Sie den Tarif aus</option>
                                <option value="val2">Bitte wählen Sie den Tarif aus</option>
                            </select>
                            <div class="tarif">
                                <h2 class="tarif__heading">PREMIUM</h2>
                                <p class="tarif__desc">Ideal für Fortgeschrittene</p>
                                <ul class="tarif__list">
                                    <li class="tarif__item"><i></i>Bis 6 Mitarbeiter</li>
                                    <li class="tarif__item"><i></i>Mitarbeiter Zugang</li>
                                    <li class="tarif__item"><i></i>Kundenverwaltung</li>
                                    <li class="tarif__item"><i></i>Terminerinnerung via E-Mail</li>
                                    <li class="tarif__item"><i></i>Terminkalender</li>
                                    <li class="tarif__item"><i></i>Kundenkommunikation</li>
                                    <li class="tarif__item"><i></i>Buchungstool für Website</li>
                                    <li class="tarif__item"><i></i>Buchungstool für Facebook</li>
                                    <li class="tarif__item"><i></i>Newsletter Modul (1500 Empfänger)</li>
                                    <li class="tarif__item"><i></i>Online Reports</li>
                                </ul>
                                <div class="tarif__price">Grundgebühr: 9,99 €</div>
                            </div>
                        </div>

                    </div>
                    <a href="#" class="admin-settings__btn btn btn--red f-right">Jetzt ändern</a>

                </div>

                <div data-tab-id="tab-3" class="tab-content">

                    <div class="tarif-step1">
                        <p>Sollten Sie Ihren Vertrag bei timebox23 kündigen wollen, können Sie hier die Vertragskündigung vormerken lassen.</p>
                        <p>Bitte beachten Sie: <br>
                            Ihre Online Kündigungsvormerkung ist 10 Tage lang gültig. Sollten Sie sich innerhalb dieser Frist telefonisch nicht melden, um Ihren Kündigungswunsch zu bestätigen, so verfällt Ihre Vormerkung automatisch und der Vertrag läuft weiter. Unsere weiteren Dienste stehen Ihnen nach Beendigung des Vertrages nicht mehr zur Verfügung. Bitte beachten Sie, dass der Zeitpunkt des Anrufs ausschlaggebend für die Einhaltung Ihrer Kündigungsfrist ist.</p>
                        <p>Bitte halten Sie beim Anruf Ihre vierstellige Persönliche Kundenkennzahl bereit. Diese wird zur weiteren Bearbeitung Ihres Auftrags benötigt.</p>
                    </div>

                    <div class="tarif-step2">
                        <table class="table table--striped">

                            <tr>
                                <td>Vertragsinhaber</td>
                                <td>Vyacheslav Onopchenko</td>
                            </tr>

                            <tr>
                                <td>Kundennummer</td>
                                <td>46544</td>
                            </tr>

                            <tr>
                                <td>Tarif</td>
                                <td>Premium</td>
                            </tr>

                            <tr>
                                <td>Vertrag aktiv seit </td>
                                <td>01.07.2015</td>
                            </tr>

                            <tr>
                                <td>Früheste Kündigungstermin</td>
                                <td>30.06.2016</td>
                            </tr>
                        </table>
                        <select class="tarif-step2__select" name="">
                            <option value="">Technikche Probleme</option>
                            <option value="">Tarif</option>
                            <option value="">Rechnung</option>
                            <option value="">Keine Angaben</option>
                        </select>
                    </div>

                    <div class="tarif-step3">
                        <p>Sollten Sie Ihren Vertrag bei timebox23 kündigen wollen, können Sie hier die Vertragskündigung vormerken lassen.</p>
                        <p>Bitte beachten Sie: <br>
                            Ihre Online Kündigungsvormerkung ist 10 Tage lang gültig. Sollten Sie sich innerhalb dieser Frist telefonisch nicht melden, um Ihren Kündigungswunsch zu bestätigen, so verfällt Ihre Vormerkung automatisch und der Vertrag läuft weiter. Unsere weiteren Dienste stehen Ihnen nach Beendigung des Vertrages nicht mehr zur Verfügung. Bitte beachten Sie, dass der Zeitpunkt des Anrufs ausschlaggebend für die Einhaltung Ihrer Kündigungsfrist ist.</p>
                        <p>Bitte halten Sie beim Anruf Ihre vierstellige Persönliche Kundenkennzahl bereit. Diese wird zur weiteren Bearbeitung Ihres Auftrags benötigt.</p>
                    </div>

                    <a href="#" class="admin-settings__btn btn btn--red f-right">Jetzt ändern</a>
                </div>

            </div>

        </div>

    </section>
@stop