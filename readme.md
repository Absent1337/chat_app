# Witryna do wymiany informacji pomiędzy wychowawczynią i rodzicami

## Opis aplikacji

### Logowanie

*Ekran logowania umożliwia użytkownikom (rodzicom oraz nauczycielom) logowanie się do systemu przy użyciu ich nazwy użytkownika oraz hasła.*

### Panel wiadomości

*Panel wiadomości wyświetla wszystkie przesłane wiadomości. Nauczyciel ma możliwość wysyłania wiadomości do wszystkich lub do wybranego rodzica, podczas gdy rodzice mogą przesyłać wiadomości jedynie do nauczyciela.*

### Wysyłanie wiadomości

*Formularz pozwala użytkownikowi na wpisanie wiadomości i wysłanie jej do wybranego odbiorcy (w przypadku nauczyciela) lub do wszystkich (w przypadku rodzica).*

## Instrukcja uruchomienia

### Wymagania
- [XAMPP](https://www.apachefriends.org/index.html) z uruchomionymi usługami Apache oraz MySQL.

### Kroki uruchomienia

1. **Skopiuj pliki projektu**:
    - Skopiuj zawartość folderu `projekt/htdocs` do `C:\xampp\htdocs`.

2. **Import bazy danych**:
    - Uruchom `phpMyAdmin` przez przeglądarkę (np. wchodząc na `http://localhost/phpmyadmin`).
    - Stwórz nową bazę danych, np. `komunikacja_rodzice_wychowawczyni`.
    - Zaimportuj plik `baza_danych.sql` do stworzonej bazy danych.

3. **Uruchomienie aplikacji**:
    - Otwórz przeglądarkę internetową i wejdź na adres `http://localhost/projekt`.

4. **Dane logowania**:
    - Nauczyciel:
        - Username: `teacher1`
        - Password: `password1`
    - Rodzic:
        - Username: `parent1`
        - Password: `password1`
        - Username: `parent2`
        - Password: `password2`