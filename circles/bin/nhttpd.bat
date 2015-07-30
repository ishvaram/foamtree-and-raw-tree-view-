@ECHO OFF

SET DIRNAME=%~dp0
IF "%DIRNAME%" == "" set DIRNAME=.

java -jar %DIRNAME%nhttpd.jar %1 %2 %3 %4 %5 %6 %7 %8 %9
