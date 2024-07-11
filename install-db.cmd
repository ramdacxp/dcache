@echo off
setlocal
set ROOT=%~dp0
set BIN=%ROOT%bin
set ZIP=%BIN%\maria.zip

echo Root: %ROOT%
IF NOT EXIST %BIN% mkdir %BIN%

if "%1" == "fast" goto :fast

REM Download
echo ### DOWNLOAD
del /f /q %ZIP% 2>NUL
curl -o %ZIP% https://mirror.wtnet.de/mariadb/mariadb-10.11.8/winx64-packages/mariadb-10.11.8-winx64.zip

:fast

REM Cleanup db folders
echo ### CLEANUP
rmdir /s /q %BIN%\db 2>NUL
rmdir /s /q %BIN%\mariadb-* 2>NUL

REM Unzip
echo ### UNZIP
call npx qzip unzip %ZIP% %BIN%
move %BIN%\mariadb-* %BIN%\db

REM Init mysql (system table, my.ini, ... in data dir)
echo ### ONETIME SETUP
%BIN%\db\bin\mysql_install_db.exe

endlocal
