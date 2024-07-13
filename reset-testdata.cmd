@echo off
setlocal
set ROOT=%~dp0
set BIN=%ROOT%bin

echo ### RESET DATABASE TEST DATA
%BIN%\db\bin\mysql.exe --user=root < reset-testdata.sql

endlocal
