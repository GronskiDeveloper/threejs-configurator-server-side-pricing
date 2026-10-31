# Praca AI-first: notatki dla tego repo

Trzymam ten plik w repozytorium, bo buduję z Claude Code (Anthropic) i chcę, żeby podział „człowiek/AI" był widoczny z drzewa plików, a nie deklarowany w README. Rekruter, klient albo kolega z zespołu ma tu dowody, nie ogólniki.

## Podział pracy człowiek vs AI

| Warstwa | Kto zrobił | Dlaczego tak |
|---|---|---|
| Pomysł i teza repo | **Człowiek**. Zdecydowałem, że całe repo stoi na jednej lekcji: cena liczy się na serwerze, nigdy w przeglądarce. Reszta jest tylko po to, żeby ten kontrast był widać. | To nie jest techniczny detal, tylko błąd architektury, który widuję u klientów. Startera nie buduje się wokół czegoś, w co sam nie wierzę. |
| Setup sceny Three.js (renderer, environment, cień, kamera) | **Draft AI, strojenie człowieka** | Boilerplate Claude pisze poprawnie. Moje było dołożyć `RoomEnvironment` i miękki cień, bo płaskie światła sprawiają, że drewno wygląda jak plastik, i odrzucić domyślny rig trzypunktowy. |
| Logika ceny (preview w JS vs `price.php`) | **Design człowieka, kod obu stron AI** | Podział jest sednem: `guess()` w przeglądarce to tylko podgląd dla płynności suwaka, `price.php` liczy od zera z regułami serwera i to jego liczba trafia do zamówienia. Walidację po stronie serwera dopisałem sam, bo to nie jest miejsce na improwizację modelu. |
| UI panelu | **Draft AI, decyzje człowieka** | Kolor niesie lekcję: cena-preview jest bursztynowa („nie ufaj"), odpowiedź serwera zielona („serwer wygrywa"). To moja decyzja, nie Claude. Trzymam vanilla JS bez frameworka, żeby dało się to wrzucić w motyw WordPress. |
| README + linki do grodev.pl | **Człowiek** | Decyzje marketingowe zostają u mnie. |

## Co zweryfikowałem przed wypchnięciem

- Otworzyłem `index.html` w przeglądarce: scena renderuje się, zero błędów w konsoli, importmapa bez problemów CORS.
- Puściłem detektor anty-wzorców na `index.html` (gradient-text, kontrast, za mały tekst, braki a11y). Jedno trafienie, tekst 11px, podbite do 12px. Czysto.
- Sprawdziłem `price.php`: odrzuca wymiary spoza zakresu i nieznane wykończenia kodem 422, nie liczy ceny z danych, którym nie ufa.

## Znane pułapki dla następnej iteracji AI

- **Preview z przeglądarki NIGDY nie jest ceną wiążącą.** Jeśli następny przebieg zechce „uprościć" i usunąć `price.php`, licząc cenę tylko w JS, to jest dokładnie ten błąd, przeciw któremu stoi to repo. Odrzucić.
- **Nie przenosić reguł cenowych do klienta** dla wygody. Reguła biznesowa żyje na serwerze.
- **Nie dodawać bundlera.** Importmapa i `<script type="module">` to cały pomysł. Vite czy webpack tu nie wchodzą.
- Kolor materiału zmieniać przez `.setHex()` na istniejącym materiale, nie przez podmianę instancji, bo psuje to cień i environment.

## Kiedy sięgać po Claude na tym projekcie, a kiedy pisać samodzielnie

- **Sięgnąć po Claude:** nowy produkt zamiast regału, nowy typ wykończenia, inny backend zamiast PHP pod tę samą logikę.
- **Zrobić samodzielnie:** cokolwiek dotyka reguł wyceny albo walidacji po stronie serwera. Zły wzorzec tutaj to bug, który kosztuje prawdziwego klienta.
