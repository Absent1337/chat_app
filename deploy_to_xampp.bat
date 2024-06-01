@echo off
REM Path to XAMPP htdocs
set HTDOCS_PATH=G:\xampp\htdocs\chat_app

REM Path to your project
set PROJECT_PATH=C:\Users\Miłosz Gałecki\OneDrive\Studia\Informatyka\Programowanie Aplikacji Internetowych\chat_app

REM Create target directories if they do not exist
if not exist "%HTDOCS_PATH%\css" mkdir "%HTDOCS_PATH%\css"
if not exist "%HTDOCS_PATH%\js" mkdir "%HTDOCS_PATH%\js"

REM Copy files to htdocs
xcopy /E /I /Y "%PROJECT_PATH%\css" "%HTDOCS_PATH%\css"
xcopy /E /I /Y "%PROJECT_PATH%\js" "%HTDOCS_PATH%\js"
copy "%PROJECT_PATH%\index.php" "%HTDOCS_PATH%"
copy "%PROJECT_PATH%\messages.php" "%HTDOCS_PATH%"

@REM REM Import database (replace "your_database_name" with your actual database name)
@REM "G:\xampp\mysql\bin\mysql" -u root -pYOURPASSWORD your_database_name < "%PROJECT_PATH%\baza_danych.sql"

echo Deployment completed!