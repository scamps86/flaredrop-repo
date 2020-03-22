@echo off

set /p ask=All projects will be deployed as its own configurations. Are you sure? (y/n)

if %ask%==y (
	for /r C:\REPOSITORY\ %%G in (*Deploy.xml) do (
		cd "%%~dpG"
		echo -
		echo - STARTING DEPLOY FOR: %%~pG
		echo -
		call ant -buildfile "%%G" Reset
		echo -
		echo - DEPLOY SUCCESSFULLY: %%~pG
		echo -
	)
)

pause